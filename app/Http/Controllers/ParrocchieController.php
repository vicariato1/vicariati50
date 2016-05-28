<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use DB;
use View;
use Input;
use Validator;
use Redirect;
use App\Models\Parrocchia;
use App\Models\ParrocchieDipendenze;
use GrahamCampbell\Flysystem\Facades\Flysystem;

class ParrocchieController extends Controller {

    public function mostraParrocchia($id) {


        $parrocchia = DB::table('parrocchie')
                ->where('parrocchie.id', $id)
                ->first();
        Session::put('parrocchiaSelezionata', $parrocchia);

        Session::put('tipoVicariatoUP', $parrocchia->tipologia);


//        if ($parrocchia->tipologia == 'UP1') {
//            return redirect()->action('NeController@up1');
//        }
//        if ($parrocchia->tipologia == 'UP2') {
//            return redirect()->route('NeController@up2');
//        }
//        if ($parrocchia->tipologia == 'UP3') {
//            return redirect()->route('NeController@up3');
//        }

        $dipendenze = DB::table('parrocchie_dipendenze')
                ->where('parrocchie_dipendenze.id_parrocchia', $id)
                ->lists('parrocchie_dipendenze.id_dipendenza');

        Session::put('dipendenze', $dipendenze);


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
                ->join('users', 'news.id_user', '=', 'users.id')
                ->leftJoin('parrocchie', 'news.id_parrocchia', '=', 'parrocchie.id')
                ->leftJoin('ambiti', 'news.id_ambito', '=', 'ambiti.id')
                ->whereIn('news.id_parrocchia', $dipendenze)
                ->where('news.id_contenitore', null)
                ->orderBy('news.created_at', 'desc')
                ->get();

        $visualizzaContenitore = Session::get('visualizzaContenitore');
        $newss = DB::table('news')
                ->select(
                        'news.id as id_task', //
                        'news.title', //
                        'news.id_user', //
                        'news.created_at', //
                        'data_evento_da', //
                        'news.count', //
                        'ambiti.nome as nome_ambito', //
                        'parrocchie.nome as nome_parrocchia', //
                        'users.nome as nome_user'//
                )
                ->leftJoin('users', 'news.id_user', '=', 'users.id')
                ->leftJoin('parrocchie', 'news.id_parrocchia', '=', 'parrocchie.id')
                ->leftJoin('ambiti', 'news.id_ambito', '=', 'ambiti.id')
                ->where('news.posizione_primo_piano_parrocchia_gruppo', 0)
                ->whereIn('news.id_parrocchia', $dipendenze)
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
                ->where('contenitori.id_parrocchia', $id)
                ->orderBy('contenitori.nome', 'asc')
                ->paginate(100);


        $newsScroll = DB::table('news')
                ->select(
                        'news.id as id_task', //
                        'news.title', //
                        'news.data_evento_da' //
                )
                ->whereIn('news.id_parrocchia', $dipendenze)
                ->where('news.data_evento_da', '>=', date('Y-m-d'))
                ->orderBy('news.created_at', 'desc')
                ->get();

        $utenteAbilitatoParrocchia = false;
        $utenteAbilitatoModificaOrari = false;
        if (Session::get('utenteAutenticato')) {
            $parrocchieUsers = DB::table('parrocchie_users')
                    ->where('parrocchie_users.id_parrocchia', $id)
                    ->where('parrocchie_users.id_user', Session::get('user')->id)
                    ->first();

            if (Session::get('user')->admin == 1) {
                $utenteAbilitatoParrocchia = true;
            }
            if (isset($parrocchieUsers)) {
                $utenteAbilitatoParrocchia = true;
                if ($parrocchia->tipologia != 'UP1' and $parrocchia->tipologia != 'UP2' and $parrocchia->tipologia != 'UP3') {
                    $utenteAbilitatoModificaOrari = true;
                }
            }
        }
        $orari = "";
        if ($parrocchia->tipologia == 'UP1' or $parrocchia->tipologia == 'UP2' or $parrocchia->tipologia == 'UP3') {

            $parrocchia->nomeDisplay = 'Unità pastorale ' . $parrocchia->nome;
            $parrocchie = DB::table('parrocchie')
                    ->select('nome', 'body', 'orario_festivo', 'orario_prefestivo', 'orario_feriale')//
                    ->whereIn('parrocchie.id', $dipendenze)
                    ->where('parrocchie.id', '<>', $id)
                    ->orderBy('nome', 'asc')//
                    ->get();

            $body = "";
            foreach ($parrocchie as $parr) {
                $body .= '<b>' . $parr->nome . '</b>' . '<br />';
                $body .= $parr->body . '<br />';

                $orari .= '<b>' . $parr->nome . '</b>' . '<br />';
                $orari .= 'Festivo: ' . $parr->orario_festivo . '<br />';
                $orari .= 'Pre-Festivo: ' . $parr->orario_prefestivo . '<br />';
                $orari .= 'Feriale: ' . $parr->orario_feriale . '<br />';
            }
            $parrocchia->body = $body;
        } else {
            $parrocchia->nomeDisplay = 'Parrocchia ' . $parrocchia->nome;

            if (isset($parrocchia->orario_festivo) or
                    isset($parrocchia->orario_prefestivo) or
                    isset($parrocchia->feriale)) {

                $orari .= '<b>Festivo</b>: ' . $parrocchia->orario_festivo . '<br /><br />';
                $orari .= '<b>Pre-Festivo</b>: ' . $parrocchia->orario_prefestivo . '<br /><br />';
                $orari .= '<b>Feriale</b>: ' . $parrocchia->orario_feriale . '<br />';
            }
        }
        $parrocchia->orari = $orari;

        if ($parrocchia->tipologia == 'UP1' or $parrocchia->tipologia == 'UP2' or $parrocchia->tipologia == 'UP3') {
            $ambiti = DB::table('ambiti')->orderBy('ambiti.nome', 'asc')//
                    ->select('ambiti.nome', 'ambiti.id')//
                    ->whereIn('ambiti.id_parrocchia', $dipendenze)
                    ->get();
        } else {
            $ambiti = DB::table('ambiti')->orderBy('ambiti.nome', 'asc')//
                    ->select('ambiti.nome', 'ambiti.id')//
                    ->where('ambiti.id_parrocchia', '=', $id)
                    ->get();
        }

        $bollettini = DB::table('bollettini')
                ->leftJoin('parrocchie', 'bollettini.id_parrocchia', '=', 'parrocchie.id')
                ->select(
                        'bollettini.id', //
                        'bollettini.data_bollettino', //
                        'bollettini.id_user', //
                        'bollettini.count', //
                        'parrocchie.nome as nome_parrocchia', //
                        'bollettini.created_at', //
                        'bollettini.title' //
                )
                ->orderBy('bollettini.created_at', 'desc')
                ->whereIn('bollettini.id_parrocchia', $dipendenze)
                ->simplePaginate(5);


        return View::make('parrocchie.parrocchia', compact('newss', 'parrocchia', 'ambiti', 'bollettini', 'newsScroll', 'newsPrimoPiano', 'utenteAbilitatoParrocchia', 'utenteAbilitatoModificaOrari', 'contenitori', 'parrocchie'));
    }

//    public function selezioneParrocchia() {
//        $id = Input::get('id');
//        $luoghi = DB::table('luoghi')->where('id_parrocchia', $id)->select('id', 'nome')->get();
//        return Response::json($luoghi);
//    }

    public function visualizzaContenitoreParrocchia($id) {
        Session::put('visualizzaContenitore', $id);
        return $this->mostraParrocchia(Session::get('parrocchiaSelezionata')->id);
    }

    public function saveCorpoParrocchia() {
        $id = Session::get('parrocchiaSelezionata')->id;
        $parrocchia = Parrocchia::find($id);
        $parrocchia->body = Input::get('body');
        $parrocchia->save();
        Session::flash('flash_message', 'Testo modificato correttamente');
        return Redirect::action('ParrocchieController@mostraParrocchia', $id);
    }

    public function listaParrocchie() {
        $parrocchie = DB::table('parrocchie')
                ->select('parrocchie.nome', 'parrocchie.id')
                ->orderBy('parrocchie.nome', 'asc')
                ->paginate(100);

        foreach ($parrocchie as $parrocchia) {
            $parr = DB::table('parrocchie_dipendenze')
                    ->select('parrocchie_dipendenze.id_dipendenza')
                    ->where('parrocchie_dipendenze.id_parrocchia', $parrocchia->id)
                    ->where('parrocchie_dipendenze.id_dipendenza', '<>', $parrocchia->id)
                    ->paginate();
            $sP = '';
            foreach ($parr as $p) {
                $parrocchiaD = Parrocchia::find($p->id_dipendenza);
                $sP = $sP . ' - ' . $parrocchiaD->nome . '<br>';
            }
            $parrocchia->dipendenze = $sP;
        }
        return View::make('parrocchie.listaParrocchie', compact('parrocchie'));
//return $sP;
    }

    public function visualizzaMascheraInserimentoParrocchia() {

        Session::put('inserimemtoParrocchia', true);

        return View::make('parrocchie.inserimentoParrocchia');
    }

    public function visualizzaMascheraModificaParrocchia($id) {
        $parrocchie = Parrocchia::find($id);

        Session::put('inserimemtoParrocchia', false);

//$parro = DB::table('parrocchie')->orderBy('nome', 'asc')->lists('nome', 'id');

        return View::make('parrocchie.modificaParrocchia', compact('parrocchie'));
    }

    public function saveCreateParrocchia() {

        $data = Input::all();
        $rules = array(
            'nome' => 'required');

        $messages = array(
            'nome.required' => 'Valorizzare Parrocchia'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {

            if (Session::get('inserimemtoParrocchia')) {
                $parrocchia = new Parrocchia;
                $parrocchia->tipologia = 'P';
            } else {
                $parrocchia = Parrocchia::find(Input::get('id'));
            }
            $file = Input::file('immagineParrocchia');
            $flysystem = Flysystem::connection('localChiese');
            if (isset($file)) {
                $dirfile = $file->getClientOriginalName();
                if ($flysystem->has($dirfile)) {
                    $flysystem->delete($dirfile);
                }
                $stream = fopen($file, 'r+');
                $flysystem->writeStream($dirfile, $stream);
                fclose($stream);
                $parrocchia->nome_file_immagine = $file->getClientOriginalName();
            }

            $parrocchia->nome = Input::get('nome');
            $parrocchia->id_user = Session::get('user')->id;
            $parrocchia->visualizza_bollettini = Input::get('visualizza_bollettini');
            $parrocchia->label_link_diretto_1 = Input::get('label_link_diretto_1');
            $parrocchia->link_diretto_1 = Input::get('link_diretto_1');
            $parrocchia->save();



            $parrocchieCombo = DB::table('parrocchie')
                    ->orderBy('nome', 'asc')
                    ->lists('nome', 'id');
            Session::put('parrocchieCombo', $parrocchieCombo);

            return Redirect::to('listaParrocchie');
        } else {
            return Redirect::to('visualizzaMascheraInserimentoParrocchie')->withInput()->withErrors($validator);
        }
    }

    public function domandaDeleteParrocchia($id) {
        $parrocchia = Parrocchia::find($id);
        return View::make('parrocchie.deleteParrocchia', compact('parrocchia'));
    }

    public function deleteParrocchia() {
        $parrocchia = Parrocchia::findOrFail(Input::get('id'));
        $parrocchia->delete();
        return Redirect::action('ParrocchieController@listaParrocchie');
    }

    public function inserisciDipendenza($id) {
        $parrocchia = Parrocchia::findOrFail($id);
        return View::make('parrocchie.inserisciDipendenza', compact('parrocchia'));
    }

    public function effettuaInserimentoDipendenza() {
        $ParrocchieDipendenze = new ParrocchieDipendenze;
        $ParrocchieDipendenze->id_parrocchia = Input::get('id');
        $ParrocchieDipendenze->id_dipendenza = Input::get('id_parrocchia');
        $ParrocchieDipendenze->save();
        return Redirect::to('listaParrocchie');
    }

}
