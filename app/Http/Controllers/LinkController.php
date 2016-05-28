<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use DB;
use View;
use Input;
use Validator;
use Redirect;
use App\Models\Collegamenti;

class LinkController extends Controller {

    public function listaLink($id) {
        $links = DB::table('collegamenti')
                ->select('collegamenti.id', //
                        'collegamenti.titolo_link', //
                        'collegamenti.link'
                )
                ->orderBy('collegamenti.titolo_link', 'asc')
                ->get();
        return View::make('link.lista', compact('links'));
    }

        public function listaLinkgestione($id) {
        $links = DB::table('collegamenti')
                ->select('collegamenti.id', //
                        'collegamenti.titolo_link', //
                        'collegamenti.link'
                )
                ->orderBy('collegamenti.titolo_link', 'asc')
                ->get();
        return View::make('link.listaGestione', compact('links'));
    }

    public function visualizzaMascheraInserimentoLink() {
        Session::put('inserimentoLink', true);
        return View::make('link.inserimentoCollegamento');
    }

    public function visualizzaMascheraModificaLink($id) {
        $collegamento = Collegamenti::find($id);
        Session::put('inserimentoLink', false);
        return View::make('link.modificaCollegamento', compact('collegamento'));
    }

    public function domandaDeleteLink($id) {
        $collegamento = Collegamenti::find($id);

        return View::make('link.deleteCollegamento', compact('collegamento'));
    }

    public function deleteCollegamento() {
        $collegamento = Collegamenti::findOrFail(Input::get('id'));
        $collegamento->delete();
        return Redirect::to('listaLinkGestione/1');
    }
    public function saveCreateCollegamento() {

        $data = Input::all();
        $rules = array(
            'titolo_link' => 'required',
            'link' => 'required'
        );

        $messages = array(
            'nome_link.required' => 'Valorizzare Nome Link',
            'link.required' => 'Valorizzare Link'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {
            if (Session::get('inserimentoLink')) {
                $collegamento = new Collegamenti;
            } else {
                $collegamento = Collegamenti::find(Input::get('id'));
            }

            $collegamento->titolo_link = Input::get('titolo_link');
            $collegamento->link = Input::get('link');
            $collegamento->save();
            //return Redirect::to('listaLink',array(1));
            return Redirect::to('listaLinkGestione/1');
            
        } else {
            return Redirect::to('visualizzaMascheraInserimentoLink')->withInput()->withErrors($validator);
        }
    }
}
