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
use App\Models\ParrocchieUsers;

class ParrocchieUtentiController extends Controller {

    public function listaParrocchieUtenti() {
        $parrocchieUtenti = DB::table('parrocchie_users')
                ->join('users', 'parrocchie_users.id_user', '=', 'users.id')
                ->join('parrocchie', 'parrocchie_users.id_parrocchia', '=', 'parrocchie.id')
                ->select('parrocchie_users.id', //
                        'parrocchie.nome as nome_parrocchia', //
                        'users.nome as nome_user', 'parrocchie_users.pubblica_bollettini', 'parrocchie_users.pubblica_news', 'parrocchie_users.gestisci_primo_piano'
                )
                ->paginate(10);
        return View::make('parrocchieUtenti.listaParrocchieUsers', compact('parrocchieUtenti'));
    }

    public function visualizzaMascheraInserimentoUtenteParrocchia() {

        Session::put('inserimentoUtenteParrocchia', true);

        $parrocchieCombo = DB::table('parrocchie')
                ->select('parrocchie.id', 'parrocchie.nome')
                ->orderBy('parrocchie.nome', 'asc')
                ->lists('nome', 'id');

        $usersCombo = DB::table('users')
                ->select('users.id', 'users.nome')
                ->orderBy('users.nome', 'asc')
                ->lists('nome', 'id');

        return View::make('parrocchieUtenti.inserimentoUtenteParrocchia', compact('parrocchieCombo', 'usersCombo'));
    }

    public function visualizzaMascheraModificaParrocchiaUser($id) {
        $parrocchieUsers = ParrocchieUsers::find($id);

        Session::put('inserimentoUtenteParrocchia', false);

        $parrocchieCombo = DB::table('parrocchie')
                ->select('parrocchie.id', 'parrocchie.nome')
                ->orderBy('parrocchie.nome', 'asc')
                ->lists('nome', 'id');

        $usersCombo = DB::table('users')
                ->select('users.id', 'users.nome')
                ->orderBy('users.nome', 'asc')
                ->lists('nome', 'id');

        return View::make('parrocchieUtenti.modificaUtenteParrocchia', compact('parrocchieCombo', 'usersCombo', 'parrocchieUsers'));
    }

    public function deleteUtenteParrocchia($id) {
        $parrocchieUsers = ParrocchieUsers::find($id);
        $parrocchieUsers->delete();
        return Redirect::to('listaParrocchieUtenti');
    }

    public function saveCreateUtenteParrocchia() {

        $data = Input::all();
        $rules = array(
            'id_user' => array('required', 'not_in:default'),
            'id_parrocchia' => array('required', 'not_in:default')
        );

        $messages = array(
            'id_user.not_in' => 'Valorizzare Utente',
            'id_parrocchia.not_in' => 'Valorizzare Parrocchia'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {

            if (Session::get('inserimentoUtenteParrocchia')) {
                $parrocchieUsers = new ParrocchieUsers;
                $parrocchieUsers->id_user = Input::get('id_user');
                $parrocchieUsers->id_parrocchia = Input::get('id_parrocchia');
            } else {
                $parrocchieUsers = ParrocchieUsers::find(Input::get('id'));
                //return Input::get('id');
            }
            //return Input::get('id_user');

            $pubNews = Input::get('pubblica_news');
            if ($pubNews == null) {
                $parrocchieUsers->pubblica_news = 0;
            } else {
                $parrocchieUsers->pubblica_news = 1;
            }

            $pubBollettini = Input::get('pubblica_bollettini');
            if ($pubBollettini == null) {
                $parrocchieUsers->pubblica_bollettini = 0;
            } else {
                $parrocchieUsers->pubblica_bollettini = 1;
            }

            $gestisciPrimoPiano = Input::get('gestisci_primo_piano');
            if ($gestisciPrimoPiano == null) {
                $parrocchieUsers->gestisci_primo_piano = 0;
            } else {
                $parrocchieUsers->gestisci_primo_piano = 1;
            }

            $parrocchieUsers->save();
            return Redirect::to('listaParrocchieUtenti');
        } else {
            return Redirect::to('visualizzaMascheraInserimentoUtenteParrocchia')->withInput()->withErrors($validator);
        }
    }

}
