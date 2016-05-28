<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use DB;
use View;
use Input;
use Validator;
use Redirect;
use App\Models\Ambiti;

//phil1

class AmbitiController extends Controller {

    public function mostraAmbito($id) {

        $newsPrimoPiano = DB::table('news')
                ->select(
                        'news.id as id_task', //
                        'news.title', //
                        'news.created_at', //
                        'data_evento_da', //
                        'news.count', //
                        'news.id_user', //
                        'ambiti.nome as nome_ambito', //
                        'parrocchie.nome as nome_parrocchia', //
                        'users.nome as nome_user'//
                )
                ->where('news.posizione_primo_piano_parrocchia_gruppo', '>', 0)
                ->leftJoin('users', 'news.id_user', '=', 'users.id')
                ->leftJoin('parrocchie', 'news.id_parrocchia', '=', 'parrocchie.id')
                ->leftJoin('ambiti', 'news.id_ambito', '=', 'ambiti.id')
                ->where('news.id_ambito', $id)
                ->where('news.id_contenitore', null)
                ->orderBy('news.created_at', 'desc')
                ->get();
        
        $visualizzaContenitore = Session::get('visualizzaContenitore');
        $newss = DB::table('news')
                ->select(
                        'news.id as id_task', //
                        'news.title', //
                        'news.body', //
                        'news.created_at', //
                        'data_evento_da', //
                        'news.count', //
                        'news.id_user', //
                        'ambiti.nome as nome_ambito', //
                        'parrocchie.nome as nome_parrocchia', //
                        'users.nome as nome_user'//
                )
                ->leftJoin('users', 'news.id_user', '=', 'users.id')
                ->leftJoin('parrocchie', 'news.id_parrocchia', '=', 'parrocchie.id')
                ->leftJoin('ambiti', 'news.id_ambito', '=', 'ambiti.id')
                ->where('news.posizione_primo_piano_parrocchia_gruppo', 0)
                ->where('news.id_ambito', $id)
                ->where(function($query) use ($visualizzaContenitore) {
                    if (is_null($visualizzaContenitore)) {
                        $query->where('news.id_contenitore', null);
                    } else {
                        $query->where('news.id_contenitore', $visualizzaContenitore);
                    }
                })
                ->orderBy('news.created_at', 'desc')
                ->paginate(20);

        Session::put('visualizzaContenitore', null);

        $contenitori = DB::table('contenitori')
                ->select(
                        'contenitori.id', //
                        'contenitori.nome'
                )
                ->where('contenitori.id_ambito', $id)
                ->orderBy('contenitori.nome', 'asc')
                ->paginate(100);

        $ambito = DB::table('ambiti')
                ->where('ambiti.id', $id)
                ->first();

        Session::put('ambitoSelezionato', $ambito);

        $ambitiUtenti = DB::table('ambiti_users')
                ->leftJoin('users', 'ambiti_users.id_user', '=', 'users.id')
                ->select('users.nome')
                ->where('ambiti_users.id_ambito', Session::get('ambitoSelezionato')->id)
                ->where('users.admin', 0) // non amministratore
                ->orderBy('users.nome', 'asc')
                ->get();

        $rigaResponsabili = "";
        if (count($ambitiUtenti) > 1) {
            $rigaResponsabili = "Responsabili: ";
        } else {
            $rigaResponsabili = "Responsabile: ";
        }
        $cnt = 0;
        foreach ($ambitiUtenti as $ambitiUtente) {
            $cnt++;
            $rigaResponsabili .= $ambitiUtente->nome;
            if ($cnt < count($ambitiUtenti)) {
                $rigaResponsabili .= ', ';
            }
        }

        $str = Session::get('utenteAutenticato');

        $utenteAppartenenteAmbito = DB::table('ambiti_users')
                ->select('id')
                ->where('ambiti_users.id_ambito', Session::get('ambitoSelezionato')->id)
                ->where(function($query) use ($str) {
                    if ($str) {
                        $query->where('ambiti_users.id_user', Session::get('user')->id);
                    }
                })
                ->first();

        if (isset($utenteAppartenenteAmbito->id)) {
            $ambito->utenteAppartenenteAmbito = true;
        } else {
            $ambito->utenteAppartenenteAmbito = false;
        }

        return View::make('ambiti.ambito', compact('newss', 'ambito', 'rigaResponsabili', 'contenitori', 'newsPrimoPiano'));
    }

    public function visualizzaContenitoreAmbito($id) {
        Session::put('visualizzaContenitore', $id);
        //return Session::get('visualizzaContenitore');
        return $this->mostraAmbito(Session::get('ambitoSelezionato')->id);
    }

    public function saveCorpoAmbito() {
        $id = Session::get('ambitoSelezionato')->id;
        $ambiti = Ambiti::find($id);
        $ambiti->body = Input::get('body');
        $ambiti->save();
        Session::flash('flash_message','Testo modificato correttamente');

        return Redirect::action('AmbitiController@mostraAmbito', Session::get('ambitoSelezionato')->id);
    }

    public function listaAmbiti() {
        $ambiti = DB::table('ambiti')
                ->leftJoin('parrocchie', 'ambiti.id_parrocchia', '=', 'parrocchie.id')
                ->select('ambiti.nome', 'ambiti.id', //
                        'parrocchie.nome as nome_parrocchia', 'ambiti.pubblica_prima_pagina'
                )
                ->orderBy('ambiti.nome', 'asc')
                ->paginate(100);
        return View::make('ambiti.listaAmbiti', compact('ambiti'));
    }

    public function visualizzaMascheraInserimentoAmbito() {

        Session::put('inserimemtoAmbito', true);

        return View::make('ambiti.inserimentoAmbito');
    }

    public function visualizzaMascheraModificaAmbito($id) {
        $ambiti = Ambiti::find($id);

        Session::put('inserimemtoAmbito', false);

        return View::make('ambiti.modificaAmbito', compact('ambiti'));
    }

    public function saveCreateAmbito() {

        $data = Input::all();
        $rules = array(
            'nome' => 'required',
            'id_parrocchia' => array('required', 'not_in:default')
        );

        $messages = array(
            'nome.required' => 'Valorizzare Nome',
            'id_parrocchia.required' => 'Valorizzare Parrocchia',
            'id_parrocchia.not_in' => 'Valorizzare Parrocchia'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {

            if (Session::get('inserimemtoAmbito')) {
                $ambiti = new Ambiti;
            } else {
                $ambiti = Ambiti::find(Input::get('id'));
            }
            $pubPrimaPagina = Input::get('pubblica_prima_pagina');
            if ($pubPrimaPagina == null) {
                $ambiti->pubblica_prima_pagina = 0;
            } else {
                $ambiti->pubblica_prima_pagina = 1;
            }

            $ambiti->nome = Input::get('nome');
            $ambiti->id_parrocchia = Input::get('id_parrocchia');
            $ambiti->label_link_diretto_1 = Input::get('label_link_diretto_1');
            $ambiti->link_diretto_1 = Input::get('link_diretto_1');
            $ambiti->save();
            return Redirect::to('listaAmbiti');
        } else {
            return Redirect::to('visualizzaMascheraInserimentoAmbito')->withInput()->withErrors($validator);
        }
    }

    public function domandaDeleteAmbito($id) {
        $ambito = Ambiti::find($id);
        return View::make('ambiti.deleteAmbito', compact('ambito'));
    }

    public function deleteAmbito() {
        $ambito = Ambiti::findOrFail(Input::get('id'));
        $ambito->delete();
        return Redirect::action('AmbitiController@listaAmbiti');
    }

}
