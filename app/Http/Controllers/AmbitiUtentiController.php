<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use DB;
use View;
use Input;
use Validator;
use Redirect;
use App\Models\AmbitiUsers;
use App\Models\User;
use App\Models\Ambiti;

class AmbitiUtentiController extends Controller {

    public function listaAmbitiUtenti() {
        $ambitiUtenti = DB::table('ambiti_users')
                ->join('ambiti', 'ambiti_users.id_ambito', '=', 'ambiti.id')
                ->leftJoin('users', 'ambiti_users.id_user', '=', 'users.id')
                ->join('parrocchie', 'ambiti.id_parrocchia', '=', 'parrocchie.id')
                ->select('ambiti.nome', //
                        'ambiti_users.id', //
                        'ambiti_users.gestisci_primo_piano', //
                        'parrocchie.nome as nome_parrocchia', //
                        'users.nome as nome_user'
                )
                ->orderBy('ambiti.nome', 'asc')
                ->paginate(10);
        //return $ambitiUtenti;
        return View::make('ambitiUtenti.listaAmbitiUtenti', compact('ambitiUtenti'));
    }

    public function visualizzaMascheraInserimentoUtenteAmbito() {

        Session::put('inserimemtoUtenteAmbito', true);

        $ambitiCombo = DB::table('ambiti')
                ->select('ambiti.id', 'ambiti.nome')
                ->orderBy('ambiti.nome', 'asc')
                ->lists('nome', 'id');

        $usersCombo = DB::table('users')
                ->select('users.id', 'users.nome')
                ->orderBy('users.nome', 'asc')
                ->lists('nome', 'id');

        return View::make('ambitiUtenti.inserimentoUtenteAmbito', compact('ambitiCombo', 'usersCombo'));
    }

    public function visualizzaMascheraModificaUtenteAmbito($id) {
        $ambitiUsers = AmbitiUsers::find($id);
        $user = User::find($ambitiUsers->id_user);
        $ambito = Ambiti::find($ambitiUsers->id_ambito);

        $ambitiUsers->user = $user->nome;
        $ambitiUsers->ambito = $ambito->nome;

        Session::put('inserimemtoUtenteAmbito', false);

        return View::make('ambitiUtenti.modificaUtenteAmbito', compact('ambitiUsers'));
    }

    public function deleteUtenteAmbito($id) {
        $ambitiUsers = AmbitiUsers::find($id);
        $ambitiUsers->delete();
        return Redirect::to('listaAmbitiUtenti');
    }

    public function saveCreateUtenteAmbito() {

        $data = Input::all();
        $rules = array(
            'id_user' => array('required', 'not_in:default'),
            'id_ambito' => array('required', 'not_in:default')
        );

        $messages = array(
            'id_user.not_in' => 'Valorizzare Utente',
            'id_ambito.not_in' => 'Valorizzare Ambito'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {

            if (Session::get('inserimemtoUtenteAmbito')) {
                $ambiti = new AmbitiUsers;
            } else {
                $ambiti = AmbitiUsers::find(Input::get('id'));
            }

            $gestisciPrimoPiano = Input::get('gestisci_primo_piano');
            if ($gestisciPrimoPiano == null) {
                $ambiti->gestisci_primo_piano = 0;
            } else {
                $ambiti->gestisci_primo_piano = 1;
            }

            $ambiti->id_user = Input::get('id_user');
            $ambiti->id_ambito = Input::get('id_ambito');
            $ambiti->save();
            return Redirect::to('listaAmbitiUtenti');
        } else {
            return Redirect::to('visualizzaMascheraInserimentoUtenteAmbito')->withInput()->withErrors($validator);
        }
    }

    public function saveModificaUtenteAmbito() {

        $ambiti = AmbitiUsers::find(Input::get('id'));

        $gestisciPrimoPiano = Input::get('gestisci_primo_piano');
        if ($gestisciPrimoPiano == null) {
            $ambiti->gestisci_primo_piano = 0;
        } else {
            $ambiti->gestisci_primo_piano = 1;
        }
        $ambiti->save();
        return Redirect::to('listaAmbitiUtenti');
    }

}
