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
use App\Models\Contenitori;

class ContenitoriController extends Controller {

    public function mostraContenitore($id) {
        
    }

    public function listaContenitori() {
        $contenitori = DB::table('contenitori')
                ->leftJoin('parrocchie', 'contenitori.id_parrocchia', '=', 'parrocchie.id')
                ->leftJoin('ambiti', 'contenitori.id_ambito', '=', 'ambiti.id')
                ->leftJoin('parrocchie as parrAmbito', 'ambiti.id_parrocchia', '=', 'parrAmbito.id')
                ->select('contenitori.nome', 'contenitori.id', //
                        'parrocchie.nome as nome_parrocchia', //
                        'parrAmbito.nome as nome_parrocchia_ambito', //
                        'ambiti.nome as nome_ambito'
                )
                ->orderBy('contenitori.nome', 'asc')
                ->paginate(100);

        return View::make('contenitori.listaContenitori', compact('contenitori'));
    }

    public function visualizzaMascheraInserimentoContenitore() {

        $this->impostaAmbitiComboTotali();

        Session::put('inserimemtoContenitore', true);

        return View::make('contenitori.inserimentoContenitore');
    }

    public function visualizzaMascheraModificaContenitore($id) {

        $this->impostaAmbitiComboTotali();

        $contenitore = Contenitori::find($id);

        Session::put('inserimemtoContenitore', false);

        return View::make('contenitori.modificaContenitore', compact('contenitore'));
    }

    public function saveCreateContenitore() {

        $data = Input::all();
        $rules = array(
            'nome' => 'required'
        );

        $messages = array(
            'nome.required' => 'Valorizzare Nome'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {

            if (Session::get('inserimemtoContenitore')) {
                $contenitori = new Contenitori;
            } else {
                $contenitori = Contenitori::find(Input::get('id'));
            }

            $contenitori->nome = Input::get('nome');
            $contenitori->id_parrocchia = Input::get('id_parrocchia');
            $contenitori->id_ambito = Input::get('id_ambito');
            $contenitori->id_user = Session::get('user')->id;
            $contenitori->save();
            return Redirect::to('listaContenitori');
        } else {
            return Redirect::to('visualizzaMascheraInserimentoContenitore')->withInput()->withErrors($validator);
        }
    }

    public function domandaDeleteContenitore($id) {
        $contenitore = Contenitori::find($id);
        return View::make('contenitori.deleteContenitore', compact('contenitore'));
    }

    public function deleteContenitore() {
        $contenitore = Contenitori::findOrFail(Input::get('id'));
        $contenitore->delete();
        return Redirect::action('ContenitoriController@listaContenitori');
    }

    private function impostaAmbitiComboTotali() {
        $ambitiComboTotali = DB::table('ambiti')
                ->orderBy('nome', 'asc')
                ->lists('nome', 'id');
        Session::put('ambitiComboTotali', $ambitiComboTotali);
    }

}
