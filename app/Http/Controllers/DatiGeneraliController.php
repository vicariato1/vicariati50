<?php namespace App\Http\Controllers; 
use App\Http\Controllers\Controller; 
//use Session;
use DB;
//use DateTime;
use View;
use Input;
//use Validator;
//use Illuminate\Support\MessageBag;
use Redirect;

use App\Models\DatiGenerali;

class DatiGeneraliController extends Controller {

    public function visualizzaDatiGenerali() {
        $datiGenerali = DB::table('dati_generali')
                ->select(
                        'dati_generali.id', 'dati_generali.titolo_generale', 'dati_generali.sottotitolo'
                )
                ->first();

        return View::make('datiGenerali.modificaDatiGenerali', compact('datiGenerali'));
    }

    public function saveDatiGenerali() {
        $datiGenerali = DatiGenerali::findOrFail(Input::get('id'));
        $datiGenerali->titolo_generale = Input::get('titolo_generale');
        $datiGenerali->sottotitolo = Input::get('sottotitolo');
        $datiGenerali->save();
        return Redirect::action('NeController@home');
    }

}
