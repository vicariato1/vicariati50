<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use DB;
//use DateTime;
use View;
use Input;
use Validator;
//use Illuminate\Support\MessageBag;
use Redirect;
use App\Models\Parrocchia;

class OrariController extends Controller {

    public function orari_lista() {
        
        $tipoVicariatoUP = Session::get('tipoVicariatoUP');
        
        $dipendenze = DB::table('parrocchie_dipendenze')
                ->select("parrocchie_dipendenze.id_dipendenza")
                ->join('parrocchie', 'parrocchie_dipendenze.id_parrocchia', '=', 'parrocchie.id')
                ->where('parrocchie.tipologia', '=', $tipoVicariatoUP)
                ->lists('id_dipendenza');
        
        
        
        
        $orari = DB::table('parrocchie')
                ->leftJoin('users', 'parrocchie.id_user', '=', 'users.id')
                ->select(
                        'users.nome as nome_user', //
                        'parrocchie.id', //
                        'parrocchie.nome', //
                        'parrocchie.orario_feriale', //
                        'parrocchie.orario_festivo', //
                        'parrocchie.orario_prefestivo', //
                        'parrocchie.note', 'parrocchie.updated_at'
                )
                ->where('parrocchie.tipologia', 'P')
                ->whereIn('parrocchie.id', $dipendenze)
                ->orderBy('parrocchie.nome', 'asc')
                ->get();

        foreach ($orari as $orario) {
            if (Session::get('utenteAutenticato')) {
                $parrocchie_users = DB::table('parrocchie_users')
                        ->select(
                                'parrocchie_users.id' //
                        )
                        ->where('parrocchie_users.id_parrocchia', $orario->id)
                        ->where('parrocchie_users.id_user', Session::get('user')->id)
                        ->first();

                if (isset($parrocchie_users->id)) {
                    $orario->utenteAppartenenteAParrocchia = true;
                } else {
                    $orario->utenteAppartenenteAParrocchia = false;
                }
            } else {
                $orario->utenteAppartenenteAParrocchia = false;
            }
        }

        return View::make('orari.lista', compact('orari'));
    }

    public function orari_dettaglio($id) {
        $parrocchia = Parrocchia::find($id);
        return View::make('orari.dettaglio', compact('parrocchia'));
    }

    public function orari_salva() {
        //echo "sono in save orario";

        $data = Input::all();
        $rules = array(
            'orario_festivo' => 'required',
            'orario_feriale' => 'required',
            'orario_prefestivo' => 'required'
        );

        $messages = array(
            'orario_festivo' => 'Digitare orario festivo',
            'orario_feriale' => 'Digitare orario feriale',
            'orario_prefestivo' => 'Digitare orario prefestivo',
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {
            $parrocchia = Parrocchia::find(Input::get('id'));
            $parrocchia->orario_festivo = Input::get('orario_festivo');
            $parrocchia->orario_prefestivo = Input::get('orario_prefestivo');
            $parrocchia->orario_feriale = Input::get('orario_feriale');
            $parrocchia->id_user = Session::get('user')->id;
            $parrocchia->save();


            return Redirect::action('OrariController@orari_lista');
        }
        return Redirect::action('OrariController@orari_dettaglio', Input::get('id'))->withInput()->withErrors($validator);
    }

}
