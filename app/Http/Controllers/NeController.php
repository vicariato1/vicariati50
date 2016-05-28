<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use \Illuminate\Support\Facades\DB;
use DateTime;
use View;
use Input;
use Validator;
//use Illuminate\Support\MessageBag;
use Redirect;
use App\Models\Task;
use App\Models\Attachment;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Illuminate\Support\Facades\File;
use SplFileInfo;
use Image;

class NeController extends Controller {

    public function home() {

        $arr = $this->visualizzaMain('V');

        $view = $arr[0];
        $newss = $arr[1];
        $bollettini = $arr[2];
        $newsScroll = $arr[3];
        $parrocchie = $arr[4];
        $ambiti = $arr[5];
        $newsPrimoPiano = $arr[6];
        $parrocchieSlide = $arr[7];
        $utenteAutorizzatoPubblicazioneBollettini = $arr[8];

        return View::make($view, compact('newss', 'bollettini', 'newsScroll', 'parrocchie', 'ambiti', 'newsPrimoPiano', 'parrocchieSlide', 'utenteAutorizzatoPubblicazioneBollettini'));
    }

    public function up1() {

        $arr = $this->visualizzaMain("UP1");

        $view = $arr[0];
        $newss = $arr[1];
        $bollettini = $arr[2];
        $newsScroll = $arr[3];
        $parrocchie = $arr[4];
        $ambiti = $arr[5];
        $newsPrimoPiano = $arr[6];
        $parrocchieSlide = $arr[7];
        $utenteAutorizzatoPubblicazioneBollettini = $arr[8];

        return View::make($view, compact('newss', 'bollettini', 'newsScroll', 'parrocchie', 'ambiti', 'newsPrimoPiano', 'parrocchieSlide', 'utenteAutorizzatoPubblicazioneBollettini'));
    }

    public function up2() {

        $arr = $this->visualizzaMain("UP2");

        $view = $arr[0];
        $newss = $arr[1];
        $bollettini = $arr[2];
        $newsScroll = $arr[3];
        $parrocchie = $arr[4];
        $ambiti = $arr[5];
        $newsPrimoPiano = $arr[6];
        $parrocchieSlide = $arr[7];
        $utenteAutorizzatoPubblicazioneBollettini = $arr[8];

        return View::make($view, compact('newss', 'bollettini', 'newsScroll', 'parrocchie', 'ambiti', 'newsPrimoPiano', 'parrocchieSlide', 'utenteAutorizzatoPubblicazioneBollettini'));
    }

    public function up3() {

        $arr = $this->visualizzaMain("UP3");

        $view = $arr[0];
        $newss = $arr[1];
        $bollettini = $arr[2];
        $newsScroll = $arr[3];
        $parrocchie = $arr[4];
        $ambiti = $arr[5];
        $newsPrimoPiano = $arr[6];
        $parrocchieSlide = $arr[7];
        $utenteAutorizzatoPubblicazioneBollettini = $arr[8];

        return View::make($view, compact('newss', 'bollettini', 'newsScroll', 'parrocchie', 'ambiti', 'newsPrimoPiano', 'parrocchieSlide', 'utenteAutorizzatoPubblicazioneBollettini'));
    }

    private function visualizzaMain($tipoVicariatoUP) {
        $parrocchiaSel = DB::table('parrocchie')
                ->where('tipologia', $tipoVicariatoUP)
                ->first();

        Session::put('parrocchiaSelezionata', $parrocchiaSel);

        $dipendenze = DB::table('parrocchie_dipendenze')
                ->select("parrocchie_dipendenze.id_dipendenza")
                ->join('parrocchie', 'parrocchie_dipendenze.id_parrocchia', '=', 'parrocchie.id')
                ->where('parrocchie.tipologia', '=', $tipoVicariatoUP)
                ->lists('id_dipendenza');

        Session::put('dipendenze', $dipendenze);


        if (is_null(Session::get('initEffettuata'))) {
            $this->inizializzazioni();
        }

//Session::put('sezioneSelezionata', $tipoVicariatoUP);
//Session::put('LINK_ADDRESS_BAR', env('LINK_ADDRESS_BAR'));
        Session::put('tipoVicariatoUP', $tipoVicariatoUP);

        $str = Session::get('stringaRicercaNews');

        $newss = DB::table('news')
                ->leftJoin('users', 'news.id_user', '=', 'users.id')
                ->leftJoin('parrocchie', function($join) use ($dipendenze) {
                    $join->on('parrocchie.id', 'in', DB::raw('(' . implode(',', $dipendenze) . ')'));
                    $join->on('parrocchie.id', '=', 'news.id_parrocchia');
                })
                ->leftJoin('ambiti', 'news.id_ambito', '=', 'ambiti.id')
                ->select(
                        'news.id as id_task', //
                        'news.title', //
                        'news.created_at', //
                        'news.data_evento_da', //
                        'news.count', //
                        'news.id_user', //
                        'ambiti.nome as nome_ambito', //
                        'parrocchie.nome as nome_parrocchia', //
                        'users.nome as nome_user'//
                )
                ->where(function($query) use ($str) {
                    if (isset($str) and strlen($str) > 0) {
                        $query->where(DB::raw('upper(news.title)'), 'like', strtoupper('%' . $str . '%'));
                        $query->orWhere(DB::raw('upper(news.body)'), 'like', strtoupper('%' . $str . '%'));
                    } else {
                        $query->where('news.id_contenitore', null);
                    }
                })
                ->where(function($query) use ($tipoVicariatoUP, $dipendenze) {
                    if ($tipoVicariatoUP == 'V') {
                        $query->where('news.pubblica_vicariato', 1);
                        $query->where('news.posizione_primo_piano', 0);
                    } else {
                        $query->whereIn('parrocchie.id', $dipendenze);
                        $query->where('news.posizione_primo_piano_parrocchia_gruppo', 0);
                    }
                })
                ->where('news.solo_calendario', 0)
                ->orderBy('news.created_at', 'desc')
                ->paginate(15);

        $newsPrimoPiano = DB::table('news')
                ->leftJoin('users', 'news.id_user', '=', 'users.id')
                ->leftJoin('parrocchie', function($join) use ($dipendenze) {
                    $join->on('parrocchie.id', 'in', DB::raw('(' . implode(',', $dipendenze) . ')'));
                    $join->on('parrocchie.id', '=', 'news.id_parrocchia');
                })
                ->leftJoin('ambiti', 'news.id_ambito', '=', 'ambiti.id')
                ->select(
                        'news.id as id_task', //
                        'news.title', //
                        'news.created_at', //
                        'news.data_evento_da', //
                        'news.count', //
                        'news.id_user', //
                        'ambiti.nome as nome_ambito', //
                        'parrocchie.nome as nome_parrocchia', //
                        'users.nome as nome_user'//
                )
                ->where(function($query) use ($tipoVicariatoUP, $dipendenze) {
                    if ($tipoVicariatoUP == 'V') {
                        $query->where('news.pubblica_vicariato', 1);
                        $query->where('news.posizione_primo_piano', '>', 0);
                    } else {
                        $query->whereIn('parrocchie.id', $dipendenze);
                        $query->where('news.posizione_primo_piano_parrocchia_gruppo', '>', 0);
                    }
                })
                ->where('news.solo_calendario', 0)
                ->orderBy('news.created_at', 'asc')
                ->get();

//echo serialize($newsPrimoPiano);

        $dataDa = date('Y-m-d');
        $dataA = date('Y-m-d', strtotime('+15 days'));
//echo $dataDa;
//echo $dataA;
        $newsScroll = DB::table('news')
                ->leftJoin('parrocchie', 'news.id_parrocchia', '=', 'parrocchie.id')
                ->select(
                        'news.id as id_task', //
                        'news.title', //
                        'news.data_evento_da' //
                )
                ->where('news.id_contenitore', null)
                ->whereBetween('news.data_evento_da', [$dataDa, $dataA])
                ->where(function($query) use ($tipoVicariatoUP, $dipendenze) {
                    if ($tipoVicariatoUP == 'V') {
                        $query->where('news.pubblica_vicariato', 1);
                    } else {
                        $query->whereIn('parrocchie.id', $dipendenze);
                    }
                })
                ->orderBy('news.data_evento_da', 'asc')
                ->get();

        $bollettini = DB::table('bollettini')
                ->leftJoin('parrocchie', 'bollettini.id_parrocchia', '=', 'parrocchie.id')
                ->select(
                        'bollettini.id', //
                        'bollettini.data_bollettino', //
                        'bollettini.count', //
                        'parrocchie.nome as nome_parrocchia', //
                        'bollettini.created_at', //
                        'bollettini.title' //
                )
                ->whereIn('parrocchie.id', $dipendenze)
                ->orderBy('bollettini.created_at', 'desc')
                ->simplePaginate(8);

        $parrocchie = DB::table('parrocchie')
                ->select('nome', 'id', 'nome_file_immagine')//
                ->whereIn('parrocchie.id', $dipendenze)
                ->where('tipologia', '!=', 'V')
                ->orderBy('nome', 'asc')//
                ->get();

        $parrocchieSlide = DB::table('parrocchie')
                ->select('nome', 'id', 'nome_file_immagine')//
                ->where('tipologia', '=', 'P')
                ->whereIn('parrocchie.id', $dipendenze)
                ->orderBy('nome', 'asc')//
                ->get();

        $ambiti = DB::table('ambiti')->orderBy('ambiti.nome', 'asc')//
                ->leftJoin('parrocchie', 'ambiti.id_parrocchia', '=', 'parrocchie.id')
                ->select('ambiti.nome', 'ambiti.id')//
                ->where(function($query) use ($tipoVicariatoUP) {
                    if ($tipoVicariatoUP == 'V') {
                        $query->where('ambiti.pubblica_prima_pagina', 1);
                    }
                })
                ->whereIn('parrocchie.id', $dipendenze)
                ->get();

        $parrocchieCombo = DB::table('parrocchie')
                ->whereIn('parrocchie.id', $dipendenze)
                ->orderBy('nome', 'asc')
                ->lists('nome', 'id');
        Session::put('parrocchieCombo', $parrocchieCombo);


        $utenteAutorizzatoPubblicazioneBollettini = false;
        if (Session::get('utenteAutenticato')) {
            $parrocchieUsers = DB::table('parrocchie_users')
                    ->where('parrocchie_users.id_parrocchia', $parrocchiaSel->id)
                    ->where('parrocchie_users.id_user', Session::get('user')->id)
                    ->first();

            if (isset($parrocchieUsers) and $parrocchieUsers->pubblica_bollettini) {
                $utenteAutorizzatoPubblicazioneBollettini = true;
            }
        }

        return array(
            'home.home',
            $newss,
            $bollettini,
            $newsScroll,
            $parrocchie,
            $ambiti,
            $newsPrimoPiano,
            $parrocchieSlide,
            $utenteAutorizzatoPubblicazioneBollettini
        );
    }

    public function inizializzazioni() {
        $datiGenerali = DB::table('dati_generali')
                ->select(
                        'dati_generali.titolo_generale', //
                        'dati_generali.sottotitolo'
                )
                ->first();

        Session::put('titolo_generale', $datiGenerali->titolo_generale);
        Session::put('sottotitolo', $datiGenerali->sottotitolo);

//ricavo ID della parrocchia che assume il valore di Vicariato
        $parrocchiaVicariato = DB::table('parrocchie')
                ->select('parrocchie.id')
                ->where('parrocchie.tipologia', 'V')
                ->first();
//Session::put('parrocchiaSelezionata', $parrocchiaVicariato);
//$arrayNewsGiaConsultate = Session::get('arrayNewsGiaConsultate');
//if (!isset($arrayNewsGiaConsultate)) {
        $array = array();
        Session::put('arrayNewsGiaConsultate', $array);
//}
    }

    public function cerca() {
        Session::put('stringaRicercaNews', Input::get('stringaRicerca'));
        return $this->home();
    }

    public function createNews() {
        $ambitiCombo = DB::table('ambiti')
                ->select('ambiti.id', 'ambiti.nome')
                ->join('ambiti_users', 'ambiti.id', '=', 'ambiti_users.id_ambito')
                ->join('users', 'ambiti_users.id_user', '=', 'users.id')
                ->join('parrocchie', 'ambiti.id_parrocchia', '=', 'parrocchie.id')
                ->where('ambiti_users.id_user', '=', Session::get('user')->id)
                ->orderBy('ambiti.nome', 'asc')
                ->lists('nome', 'id');

        $ambitoSelezionato = 0;
        if (count($ambitiCombo) == 1) {
            $ambitoSelezionato = key($ambitiCombo);
        }

        $contenitoriUsers = DB::table('contenitori_users')
                ->select(
                        'contenitori.id', //
                        'contenitori.nome' //
                )
                ->join('contenitori', 'contenitori_users.id_contenitore', '=', 'contenitori.id')
                ->where('contenitori_users.id_user', '=', Session::get('user')->id)
                ->lists('nome', 'id');

        $ore = $this->ore();
        $minuti = $this->minuti();

        return View::make('news.createNews', compact('ambitiCombo', 'ambitoSelezionato', 'contenitoriUsers', 'ore', 'minuti'));
    }

    public function saveCreateNews() {

        $data = Input::all();
        $rules = array(
            'title' => 'required'
        );

        $messages = array(
            'title.required' => 'Titolo News non valorizzato'
        );

        $validator = Validator::make($data, $rules, $messages);

        $parrocchiaSelezionata = Session::get('parrocchiaSelezionata');

        if ($validator->passes()) {
            $task = new Task;
            $task->title = Input::get('title');
            $task->body = Input::get('body');
            $task->id_ambito = Input::get('id_ambito');
            $task->id_parrocchia = Input::get('id_parrocchia');
            if (Input::get('id_contenitore') == 'default') {
                $task->id_contenitore = null;
            } else {
                $task->id_contenitore = Input::get('id_contenitore');
            }
            $task->id_user = Session::get('user')->id;
            $anno = substr(Input::get('data_evento_da'), 6, 4);
            $mese = substr(Input::get('data_evento_da'), 3, 2);
            $giorno = substr(Input::get('data_evento_da'), 0, 2);

            $task->data_evento_da = $anno . '-' . $mese . '-' . $giorno;
            $task->luogo = Input::get('luogo');

            $task->ora_inizio = Input::get('ora_inizio');
            $task->ora_fine = Input::get('ora_fine');
            $task->minuti_inizio = Input::get('minuti_inizio');
            $task->minuti_fine = Input::get('minuti_fine');

            $task->count = 0;

            $pubVic = Input::get('pubblica_vicariato');
            if ($pubVic == null) {
                $task->pubblica_vicariato = 0;
            } else {
                $task->pubblica_vicariato = 1;
            }
            $task->posizione_primo_piano = 0;
            $task->posizione_primo_piano_parrocchia_gruppo = 0;

            $soloCalendario = Input::get('solo_calendario');
            if ($soloCalendario == null) {
                $task->solo_calendario = 0;
            } else {
                $task->solo_calendario = 1;
            }
            $task->save();

            $flysystem = Flysystem::connection('localNews');
            $id_file = 0;
            $lunghezzaRiferimento = 3000;
            foreach (Input::file('allegati') as $file) {
                if (isset($file)) {
                    $id_file++;

                    $id_attachment = DB::table('attachments')->max('id');
                    $id_attachment++;

                    $dirfile = $task->id . '/' . $file->getClientOriginalName();
                    $flysystem->createDir($task->id);
                    if ($flysystem->has($dirfile)) {
                        $flysystem->delete($dirfile);
                    }
                    $flysystem->writeStream($dirfile, fopen($file, 'r'));
                    
//                    $a = array('JPG', 'JPEG', 'GIF', 'PNG');
//                    $ext = strtoupper(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
//
//                    if (in_array($ext, $a)) {
//                        list($width, $height) = getimagesize(storage_path('news') . '/' . $dirfile);
//                        if ($width > $lunghezzaRiferimento) {
//                            $image = Image::make($file)->resize($lunghezzaRiferimento, null, function ($constraint) {
//                                $constraint->aspectRatio();
//                            });
//                            $image->save(storage_path('news') . '/' . $dirfile);
//                        }
//                    }

                    $attachment = new Attachment;
                    $attachment->id = $id_attachment;
                    $attachment->id_task = $task->id;
                    $attachment->id_file = $id_file;
                    $attachment->nome = $file->getClientOriginalName();
                    $attachment->save();
                }
            }

            if (Session::get('tipoVicariatoUP') == 'V') {
                return Redirect::action('NeController@home');
            } else if (Session::get('tipoVicariatoUP') == 'UP1') {
                return Redirect::action('NeController@up1');
            } else if (Session::get('tipoVicariatoUP') == 'UP2') {
                return Redirect::action('NeController@up2');
            } else if (Session::get('tipoVicariatoUP') == 'UP3') {
                return Redirect::action('NeController@up3');
            }
        }
        return Redirect::action('NeController@createNews')->withInput()->withErrors($validator);
    }

    public function dettaglioNews($id) {//
        if (Session::get('utenteAutenticato')) {
            $news = Task::find($id);

            $dipendenze = DB::table('parrocchie_dipendenze')
                    ->select("parrocchie_dipendenze.id_dipendenza")
                    ->join('parrocchie', 'parrocchie_dipendenze.id_parrocchia', '=', 'parrocchie.id')
                    ->where('parrocchie.tipologia', '=', Session::get('tipoVicariatoUP'))
                    ->lists('id_dipendenza');

            $ambitiUsers = DB::table('ambiti_users')
                    ->select('ambiti_users.id')
                    ->where('ambiti_users.id_user', Session::get('user')->id)
                    ->where('ambiti_users.id_ambito', $news->id_ambito)
                    ->first();

            $parrocchieUsers = DB::table('parrocchie_users')
                    ->select('parrocchie_users.id')
                    ->where('parrocchie_users.id_user', Session::get('user')->id)
                    ->whereIn('parrocchie_users.id_parrocchia', $dipendenze)
                    ->first();

            $utentePrimoPiano = false;
            if (!empty($ambitiUsers) or ! empty($parrocchieUsers)) {
                $utentePrimoPiano = true;
            }

            if (Session::get('user')->id == $news->id_user //
                    or Session::get('user')->admin == 1 //
                    or $utentePrimoPiano) {
                return $this->dettaglioNewsModifica($id);
            } else {
                return $this->dettaglioNewsLettura($id);
            }
        } else {
            return $this->dettaglioNewsLettura($id);
        }
    }

    private function dettaglioNewsLettura($id) {//
        $tasks = DB::table('news')
                ->select(
                        'news.id', //
                        'news.title'
                )
                ->paginate(2);

        $ne = DB::table('news')
                ->join('users', 'news.id_user', '=', 'users.id')
                ->leftJoin('parrocchie', 'news.id_parrocchia', '=', 'parrocchie.id')
                ->leftJoin('ambiti', 'news.id_ambito', '=', 'ambiti.id')
                ->select('news.id as id_task', //
                        'news.title', //
                        'news.body', //
                        'news.created_at', //
                        'news.id_user', //
                        'data_evento_da', //
                        'ora_inizio', //
                        'ora_fine', //
                        'minuti_inizio', //
                        'minuti_fine', //
                        'news.count', //
                        'news.luogo', //
                        'news.pubblica_vicariato', //
                        'news.posizione_primo_piano', //
                        'ambiti.nome as nome_ambito', //
                        'ambiti.id as id_ambito', //
                        'parrocchie.nome as nome_parrocchia', //
                        'parrocchie.id as id_parrocchia,', //
                        'users.nome as nome_user')
                ->where('news.id', $id)
                ->first();

        $arr = Session::get('arrayNewsGiaConsultate');
        if (isset($arr) and ! in_array($id, $arr)) {
            DB::table('news')
                    ->where('id', $id)
                    ->update(array('count' => $ne->count + 1));
            array_push($arr, $id);
            Session::put('arrayNewsGiaConsultate', $arr);
        }

        $attachments = DB::table('attachments')
                ->where('id_task', '=', $id)
                ->get();

        $a = array('JPG', 'JPEG', 'GIF', 'PNG');

        foreach ($attachments as $attachment) {
            $info = new SplFileInfo($attachment->nome);
            $estensione = strtoupper($info->getExtension());
            $flysystem = Flysystem::connection('localNews');
            $nomeDir = $attachment->id_task . '/' . $attachment->nome;
            $imdata = base64_encode($flysystem->read($nomeDir));

            $attachment->src = "data:image/" . $estensione . ";base64," . $imdata;
            if (in_array($estensione, $a)) {
                $attachment->immagine = true;
            } else {
                $attachment->immagine = false;
            }
            $attachment->nomefile = $attachment->nome;
        }

        return View::make('news.dettaglioNewsLettura', compact('ne', 'tasks', 'attachments', 'dir'));
    }

    private function dettaglioNewsModifica($id) {

        $news = Task::find($id);
        $attachments = DB::table('attachments')->where('id_task', '=', $id)->get();

        $ambitiCombo = DB::table('ambiti')
                ->select('ambiti.id', 'ambiti.nome')
                ->join('ambiti_users', 'ambiti.id', '=', 'ambiti_users.id_ambito')
                ->join('users', 'ambiti_users.id_user', '=', 'users.id')
                ->join('parrocchie', 'ambiti.id_parrocchia', '=', 'parrocchie.id')
                ->where('ambiti_users.id_user', '=', Session::get('user')->id)
                ->orderBy('ambiti.nome', 'asc')
                ->lists('nome', 'id');



        $gestisciPrimoPiano = false;
        $gestisciPrimoPianoParrocchiaGruppo = false;
        if (Session::get('utenteAutenticato')) {
            if (Session::get('user')->admin == 1) {
                $gestisciPrimoPiano = true;
                $gestisciPrimoPianoParrocchiaGruppo = true;
            } else {
                $dipendenze = DB::table('parrocchie_dipendenze')
                        ->select("parrocchie_dipendenze.id_dipendenza")
                        ->join('parrocchie', 'parrocchie_dipendenze.id_parrocchia', '=', 'parrocchie.id')
                        ->where('parrocchie.tipologia', '=', Session::get('tipoVicariatoUP'))
                        ->lists('id_dipendenza');

                $parrocchieUsers = DB::table('parrocchie_users')
                        ->select('parrocchie_users.gestisci_primo_piano')
                        ->where('parrocchie_users.id_user', '=', $news->id_user)
                        ->whereIn('parrocchie_users.id_parrocchia', $dipendenze)
                        ->first();

                $ambitiUsers = DB::table('ambiti_users')
                        ->select('ambiti_users.gestisci_primo_piano')
                        ->where('ambiti_users.id_user', '=', $news->id_user)
                        ->where('ambiti_users.id_ambito', '=', $news->id_ambito)
                        ->first();
                if (!is_null($parrocchieUsers) or ! is_null($ambitiUsers)) {
                    $gestisciPrimoPianoParrocchiaGruppo = true;
                }
            }
        }

        $contenitoriUsers = DB::table('contenitori_users')
                ->select(
                        'contenitori.id', //
                        'contenitori.nome' //
                )
                ->join('contenitori', 'contenitori_users.id_contenitore', '=', 'contenitori.id')
                ->where('contenitori_users.id_user', '=', Session::get('user')->id)
                ->lists('nome', 'id');

        $a = array('JPG', 'JPEG', 'GIF', 'PNG');
        foreach ($attachments as $attachment) {
            $info = new SplFileInfo($attachment->nome);
            $estensione = strtoupper($info->getExtension());
            $flysystem = Flysystem::connection('localNews');
            $nomeDir = $attachment->id_task . '/' . $attachment->nome;
            $imdata = base64_encode($flysystem->read($nomeDir));
            $attachment->src = "data:image/" . $estensione . ";base64," . $imdata;
            if (in_array($estensione, $a)) {
                $attachment->immagine = true;
            } else {
                $attachment->immagine = false;
            }
            $attachment->nomefile = $attachment->nome;
        }

        $ore = $this->ore();
        $minuti = $this->minuti();


        return View::make('news.dettaglioNewsModifica', compact('news', 'attachments', 'ambitiCombo', 'contenitoriUsers', 'gestisciPrimoPiano', 'gestisciPrimoPianoParrocchiaGruppo', 'ore', 'minuti'));
    }

    public function cancellaAllegato($id) {
        $attachment = Attachment::find($id);
        File::delete('upload/' . $attachment->id_task . '/' . $attachment->nome);

        $saveIdTask = $attachment->id_task; //Prima di cancellarlo salvo id_task che passo a dettaglioNewsModifica per ritornare alla maschera di dettaglio news
        $attachment->delete();


        return $this->dettaglioNewsModifica($saveIdTask);
    }

    public function editNews() {
        $data = Input::all();
        $rules = array(
            'title' => 'required'
        );

        $messages = array(
            'title.required' => 'Titolo News non valorizzato'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {

            $task = Task::findOrFail(Input::get('id'));
            $task->title = Input::get('title');
            $task->body = Input::get('body');
            $task->id_ambito = Input::get('id_ambito');
            $task->id_parrocchia = Input::get('id_parrocchia');
            if (Input::get('id_contenitore') == 'default') {
                $task->id_contenitore = null;
            } else {
                $task->id_contenitore = Input::get('id_contenitore');
            }
            $anno = substr(Input::get('data_evento_da'), 6, 4);
            $mese = substr(Input::get('data_evento_da'), 3, 2);
            $giorno = substr(Input::get('data_evento_da'), 0, 2);
            $task->data_evento_da = $anno . '-' . $mese . '-' . $giorno;
            $task->luogo = Input::get('luogo');
            $task->ora_inizio = Input::get('ora_inizio');
            $task->ora_fine = Input::get('ora_fine');
            $task->minuti_inizio = Input::get('minuti_inizio');
            $task->minuti_fine = Input::get('minuti_fine');
            $pubVic = Input::get('pubblica_vicariato');
            if ($pubVic == null) {
                $task->pubblica_vicariato = 0;
            } else {
                $task->pubblica_vicariato = 1;
            }

            $soloCalendario = Input::get('solo_calendario');
            if ($soloCalendario == null) {
                $task->solo_calendario = 0;
            } else {
                $task->solo_calendario = 1;
            }


            if (!is_null(Input::get('posizione_primo_piano'))) {
                $task->posizione_primo_piano = Input::get('posizione_primo_piano');
            }
            if (!is_null(Input::get('posizione_primo_piano_parrocchia_gruppo'))) {
                $task->posizione_primo_piano_parrocchia_gruppo = Input::get('posizione_primo_piano_parrocchia_gruppo');
            }

            $task->save();

            $flysystem = Flysystem::connection('localNews');
            $id_file = 0;
            foreach (Input::file('allegati') as $file) {
                if (isset($file)) {
                    $id_file++;

                    $id_attachment = DB::table('attachments')->max('id');
                    $id_attachment++;

                    $dirfile = $task->id . '/' . $file->getClientOriginalName();
                    $flysystem->createDir($task->id);
                    if ($flysystem->has($dirfile)) {
                        $flysystem->delete($dirfile);
                    }
                    $flysystem->writeStream($dirfile, fopen($file, 'r'));

                    $attachment = new Attachment;
                    $attachment->id = $id_attachment;
                    $attachment->id_task = $task->id;
                    $attachment->id_file = $id_file;
                    $attachment->nome = $file->getClientOriginalName();
                    $attachment->save();
                }
            }

            if (Session::get('tipoVicariatoUP') == 'V') {
                return Redirect::action('NeController@home');
            } else if (Session::get('tipoVicariatoUP') == 'UP1') {
                return Redirect::action('NeController@up1');
            } else if (Session::get('tipoVicariatoUP') == 'UP2') {
                return Redirect::action('NeController@up2');
            } else if (Session::get('tipoVicariatoUP') == 'UP3') {
                return Redirect::action('NeController@up3');
            }
        }
        return Redirect::action('NeController@createNews', Input::get('id'))->withInput()->withErrors($validator);
    }

    public function domandaDeleteNews($id) {
        $news = Task::find($id);
        return View::make('news.deleteNews', compact('news'));
    }

    public function deleteNews() {
        $task = Task::findOrFail(Input::get('id'));
        $task->delete();
        if (Session::get('tipoVicariatoUP') == 'V') {
            return Redirect::action('NeController@home');
        } else if (Session::get('tipoVicariatoUP') == 'UP1') {
            return Redirect::action('NeController@up1');
        } else if (Session::get('tipoVicariatoUP') == 'UP2') {
            return Redirect::action('NeController@up2');
        } else if (Session::get('tipoVicariatoUP') == 'UP3') {
            return Redirect::action('NeController@up3');
        }
    }

    public function ore() {
        return array(
            "  " => "  ", //
            "20" => "20",
            "21" => "21",
            "01" => "01",
            "02" => "02",
            "03" => "03",
            "04" => "04",
            "05" => "05",
            "06" => "06",
            "07" => "07",
            "08" => "08",
            "09" => "09",
            "10" => "11",
            "12" => "12",
            "13" => "13",
            "13" => "14",
            "15" => "15",
            "16" => "16",
            "17" => "17",
            "18" => "18",
            "19" => "19",
            "20" => "20",
            "21" => "21",
            "22" => "22",
            "23" => "23"
        );
    }

    public function minuti() {
        return array(
            "  " => "  ", //
            "00" => "00",
            "05" => "05",
            "10" => "10",
            "15" => "15",
            "20" => "20",
            "25" => "25",
            "30" => "30",
            "35" => "35",
            "40" => "40",
            "45" => "45",
            "50" => "50",
            "55" => "55"
        );
    }

}
