<?php

namespace App\Http\Controllers;

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
use Response;
use App\Models\Bollettini;

class BollettiniController extends Controller {

    public function insertBollettino() {
        return View::make('bollettini.createBollettino');
    }

    public function saveBollettino() {

        $data = Input::all();
        $rules = array(
            'title' => 'required',
            'bollettino' => 'required'
        );

        $messages = array(
            'title.required' => 'Valorizzare Titolo Bollettino',
            'bollettino.required' => 'Valorizzare File Bollettino'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {

            $file = Input::file('bollettino');

            //$file->move("bollettini/" . Session::get('parrocchiaSelezionata')->id, $file->getClientOriginalName());

            $bollettini = new Bollettini;
            $bollettini->id_parrocchia = Session::get('parrocchiaSelezionata')->id;
            $bollettini->id_user = Session::get('user')->id;
            $bollettini->title = Input::get('title');
            $bollettini->count = 0; //15/12/2015
            $bollettini->nome_file = $file->getClientOriginalName($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $bollettini->save();

            $flysystem = Flysystem::connection('localBollettini');
            $dirfile = Session::get('parrocchiaSelezionata')->id . '/' . $file->getClientOriginalName($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $flysystem->createDir(Session::get('parrocchiaSelezionata')->id);
            if ($flysystem->has($dirfile)) {
                $flysystem->delete($dirfile);
            }
            $flysystem->writeStream($dirfile, fopen($file, 'r'));
        }
        return Redirect::action('ParrocchieController@mostraParrocchia', Session::get('parrocchiaSelezionata')->id);
    }

    public function deleteBollettino() {
        $bollettino = Bollettini::findOrFail(Input::get('id'));
        $bollettino->delete();
        //return Redirect::action('NeController@home');
        return Redirect::action('ParrocchieController@mostraParrocchia', Session::get('parrocchiaSelezionata')->id);
    }

    public function domandaDeleteBollettino($id) {
        $bollettino = Bollettini::find($id);
        return View::make('bollettini.deleteBollettino', compact('bollettino'));
    }

}
