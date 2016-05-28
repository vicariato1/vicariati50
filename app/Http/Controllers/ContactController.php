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
use Mail;
use App\Models\User;

class ContactController extends Controller {

    public function contattaMain() {
        return View::make('contatti.contactMain');
    }

    public function contattaAmbito() {
        $nomeVicariatoParrocchiaAmbito = "Contatta " . Session::get('ambitoSelezionato')->nome;
        return View::make('contatti.contactAmbito', compact('nomeVicariatoParrocchiaAmbito'));
    }

    public function contattaParrocchia() {
        $nomeVicariatoParrocchiaAmbito = "Contatta ";

        $str = Session::get('utenteAutenticato');
        $utenteAppartenenteParrocchia = DB::table('parrocchie_users')
                ->select('id')
                ->where('parrocchie_users.id_parrocchia', Session::get('parrocchiaSelezionata')->id)
                ->where(function($query) use ($str) {
                    if ($str) {
                        $query->where('parrocchie_users.id_user', Session::get('user')->id);
                    }
                })
                ->first();

        if (isset($utenteAppartenenteParrocchia->id)) {
            $utenteAppartenenteParrocchia = true;
        } else {
            $utenteAppartenenteParrocchia = false;
        }

        $parrocchia = DB::table('parrocchie')
                ->where('parrocchie.id', Session::get('parrocchiaSelezionata')->id)
                ->first();

        return View::make('contatti.contactParrocchia', compact('nomeVicariatoParrocchiaAmbito', 'utenteAppartenenteParrocchia','parrocchia'));
    }

    public function invioMessaggioContattaAmbito() {

        $data = Input::all();
        $rules = array(
            'subject' => 'required',
            'message' => 'required',
            'captcha' => array('required', 'captcha')
        );
        $messages = array(
            'subject.required' => 'E-Mail richiesta',
            'message.required' => 'Messaggio richiesta',
            'captcha.required' => 'Codice capcha richiesto',
            'captcha.captcha' => 'Codice capcha non corretto');

        $validator = Validator::make($data, $rules, $messages);


        if ($validator->fails()) {
            return Redirect::action('ContactController@contattaMain')->withErrors($validator)->withInput();
        }

        $emailcontent = array(
            'subject' => $data['subject'],
            'emailmessage' => $data['message']
        );


        $ambito = Session::get('ambitoSelezionato')->id;

        $users1 = DB::table('ambiti_users')
                ->join('users', 'ambiti_users.id_user', '=', 'users.id')
                ->select('users.email as email')
                ->where('ambiti_users.id_ambito', $ambito)
                ->get();

        foreach ($users1 as $use) {
            $aaaaa = $use->email;
            Mail::send('emails.contactemail', $emailcontent, function($message) use ($aaaaa) {
                $message->to($aaaaa, null)->subject('Richiesta contatto dal sito vicariale');
            });
        }


        return 'messaggio inviato';
    }

    public function invioMessaggioContattaParrocchia() {

        $data = Input::all();
        $rules = array(
            'subject' => 'required',
            'message' => 'required',
            'captcha' => array('required', 'captcha')
        );
        $messages = array(
            'subject.required' => 'E-Mail richiesta',
            'message.required' => 'Messaggio richiesta',
            'captcha.required' => 'Codice capcha richiesto',
            'captcha.captcha' => 'Codice capcha non corretto');

        $validator = Validator::make($data, $rules, $messages);


        if ($validator->fails()) {
            return Redirect::to('contact')->withErrors($validator)->withInput();
        }

        $emailcontent = array(
            'subject' => $data['subject'],
            'emailmessage' => $data['message']
        );

        $ambito = Session::get('ambitoSelezionato')->id;
        //return $ambito;


        $users1 = DB::table('ambiti_users')
                ->join('users', 'ambiti_users.id_users', '=', 'users.id')
                ->select('users.email as email')
                ->where('ambiti_users.id_ambito', $ambito)
                ->get();

        foreach ($users1 as $use) {

            $user = User::findOrFail($use->id);
            Mail::send('emails.contactemail', $emailcontent, function($message) use ($user) {
                $message->to($user, 'Learning Laravel Support')->subject('Contact via Our Contact Form');
            });
        }

        return 'messaggio inviato';
    }

    public function invioMessaggioContattaMain() {


        $data = Input::all();
        $rules = array(
            'subject' => 'required',
            'message' => 'required'
            //,'g-recaptcha-response' => 'required|captcha'
        );

        $validator = Validator::make($data, $rules);
        

        if ($validator->fails()) {
            return Redirect::action('ContactController@contattaMain')->withErrors($validator)->withInput();
        }

        $emailcontent = array(
            'subject' => $data['subject'],
            'emailmessage' => $data['message']
        );

        $users1 = DB::table('users')
                ->select('users.id')
                ->where('users.admin', 1)
                ->get();

        foreach ($users1 as $use) {
            $user = User::findOrFail($use->id);

           Mail::send('emails.contactemail', $emailcontent, function($message) use ($user) {
                $message->to($user->email, $user->nome)->subject('Richiesta contatto amministratore');
            });
            
        }

        return 'messaggio inviato';
    }

}
