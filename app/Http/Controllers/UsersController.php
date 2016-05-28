<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\DB;
use DateTime;
use View;
use Input;
use Validator;
use Illuminate\Support\MessageBag;
use Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Crypt;

class UsersController extends Controller {

    public function login() {
        $user = new User;
        $user->primoIngresso = false;
        $user->primoIngressoPasswordErrata = false;
        $user->passwordNonCoincidenti = false;
        return View::make('login.login', compact('user'));
    }

    public function controlloLogin() {
        $data = Input::all();
        $rules = array(
            'email' => 'required | email',
            'password' => 'required | min:8',
        );
        

        $pswPrimoIngressoCriptata = env('PSW_FIRST_ACCESS');

        $messages = array();

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('login')->withInput()->withErrors($validator);

        } else {
            $email = Input::get('email');
            $password = Input::get('password');

            $pswCriptata = Crypt::encrypt($password);

            $user = DB::table('users') //
                            ->where('email', $email)->first();
            


            $msg = new MessageBag;
            if (empty($user)) {
                $msg->add('email', 'Utente mon registrato');
                return Redirect::to('login')->withInput()->withErrors($msg->all());
            } else {
                $user->primoIngresso = false;
                $user->primoIngressoPasswordErrata = false;

                if ($user->registrato) {
                    if (Input::get('primoIngresso')) {
                        $password2 = Input::get('password2');
                        if ($password == $password2) {
                            //return 'dentro 1';
                            $userDB = User::find($user->id);
                            $userDB->registrato = 0;
                            $userDB->password = $pswCriptata;
                            $userDB->save();
                            $this->operazioniUtenteAutenticato($user);
                            return Redirect::to('home');
                        } else {
                            $msg->add('password', 'Le due password non sono uguali');
                            $user->primoIngresso = true;
                            $user->passwordNonCoincidenti = true;
                            return View::make('login.login', compact('user'));
                        }
                    } else {
                        if (Crypt::decrypt($pswPrimoIngressoCriptata) == Crypt::decrypt($pswCriptata)) {
                            //return 'dentro 2';
                            $user->primoIngresso = true;
                            $user->primoIngressoPasswordErrata = false;
                            $user->passwordNonCoincidenti = false;
                        } else {
                            //return 'dentro 3';
                            $user->primoIngresso = false;
                            $user->primoIngressoPasswordErrata = true;
                            $user->passwordNonCoincidenti = false;
                        }
                        return View::make('login.login', compact('user'));
                    }
                } else {

                    if (Crypt::decrypt($user->password) == Crypt::decrypt($pswCriptata)) {
                        $this->operazioniUtenteAutenticato($user);
                        if (Session::get('tipoVicariatoUP') == 'UP1')
                        {
                            return Redirect::to('up1');
                        }
                        elseif (Session::get('tipoVicariatoUP') == 'UP2')
                        {
                            return Redirect::to('up2');
                        }
                        elseif (Session::get('tipoVicariatoUP') == 'UP3')
                        {
                            return Redirect::to('up3');
                        }
                        else
                        {
                            return Redirect::to('home');
                        }
                    } else {
                        //return 'dentro 5';
                        $msg->add('password', 'Password errata');
                        return Redirect::to('login')->withInput()->withErrors($msg->all());
                    }
                }
            }
        }
    }

    public function register() {
        return View::make('register');
    }

    public function doRegister() {
        $data = Input::all();
        $rules = array(
            'email' => 'required');

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {

            $email = Input::get('email');

            $emailRet = DB::table('users')->where('email', $email)->first();

            if (is_null($emailRet)) {
                DB::table('users')->insert(
                        array(
                            'email' => $email,
                            'confirmed' => 0,
                            'created_at' => new DateTime
                        )
                );
            } else {
                return 'presente ';
            }


            $better_token = md5(uniqid(rand(), 1));

//echo $better_token;

            $emailcontent = array(
                'confermaRegistrazione' => Request::url() . '/verify/' . $better_token
            );

            DB::table('users')->where('email', $email)
                    ->update(array('confirmation_code' => $better_token));

            Mail::send('emails.registeremail', $emailcontent, function($message) {
                $message->to('albertogabriellacarraro@gmail.com', 'Messaggio di registrazione')->subject('registrati 22');
            });
        }
    }

    public function confirmation($confirmation_code) {
        DB::table('users')->where('confirmation_code', $confirmation_code)
                ->update(array(
                    'confirmed' => 1,
                    'updated_at' => new DateTime
        ));
        return 'registrato';
    }

    public function uscita() {

        Session::forget('utenteAutenticato');
        Session::flush();
        return Redirect::to('home');
    }

    public function listaUtenti() {
        $utenti = DB::table('users')
                ->select('users.nome', //
                        'users.email', //
                        'users.admin', //
                        'users.id'
                )
                ->orderBy('users.nome', 'asc')
                ->paginate(10);
        return View::make('utenti.utenti', compact('utenti'));
    }

    public function visualizzaMascheraInserimentoPersona() {
        Session::put('inserimemtoPersona', true);
        return View::make('utenti.inserimentoUtente');
    }

    public function visualizzaMascheraModificaPersona($id) {
        $user = User::find($id);
        Session::put('inserimemtoPersona', false);
        return View::make('utenti.modificaUtente', compact('user'));
    }

    public function saveCreateUsers() {

        $data = Input::all();
        $rules = array(
            'nome' => 'required',
            'email' => 'required'
        );

        $messages = array(
            'nome.required' => 'Valorizzare Nome',
            'email.required' => 'Valorizzare E-Mail'
        );

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {
            if (Session::get('inserimemtoPersona')) {
                $user = new User;
                $user->registrato = 1;
            } else {
                $user = User::find(Input::get('id'));
            }

            $admin = Input::get('admin');
            if ($admin == null) {
                $user->admin = 0;
            } else {
                $user->admin = 1;
            }

            $registrato = Input::get('registrato');
            if ($registrato == null) {
                $user->registrato = 0;
            } else {
                $user->registrato = 1;
            }

            $user->nome = Input::get('nome');
            $user->email = Input::get('email');
            $user->save();
            return Redirect::to('listaUtenti');
        } else {
            return Redirect::to('visualizzaMascheraInserimentoPersona')->withInput()->withErrors($validator);
        }
    }

    private function operazioniUtenteAutenticato($user) {
        $parrocchieCombo = DB::table('parrocchie')
                ->select('parrocchie.nome', //
                        'parrocchie.id')
                ->lists('nome', 'id');
        Session::put('parrocchieCombo', $parrocchieCombo);
        Session::put('utenteAutenticato', true);
        Session::put('user', $user);


//        $parrocchieCombo1 = DB::table('parrocchie_dipendenze')
//                ->select(DB::raw("parrocchie_dipendenze.id_dipendenza as id, 
//                                 (select parrocchie.nome 
//                                    from parrocchie 
//                                   where parrocchie.id = parrocchie_dipendenze.id_dipendenza) as nome"))
//                ->join('parrocchie', 'parrocchie_dipendenze.id_parrocchia', '=', 'parrocchie.id')
//                ->join('parrocchie_users', 'parrocchie.id', '=', 'parrocchie_users.id_parrocchia')
//                ->where('parrocchie_users.id_user', '=', Session::get('user')->id);
//
//        $parrocchieCombo2 = DB::table('parrocchie_dipendenze')
//                ->select(DB::raw("parrocchie_dipendenze.id_dipendenza as id, 
//                                 (select parrocchie.nome 
//                                    from parrocchie 
//                                   where parrocchie.id = parrocchie_dipendenze.id_dipendenza) as nome"))
//                ->join('parrocchie', 'parrocchie_dipendenze.id_parrocchia', '=', 'parrocchie.id')
//                ->join('ambiti_users', 'ambiti.id', '=', 'ambiti_users.id_ambito')
//                ->join('users', 'ambiti_users.id_user', '=', 'users.id')
//                ->join('ambiti', 'parrocchie.id', '=', 'ambiti.id_parrocchia')
//                ->union($parrocchieCombo1)
//                ->where('ambiti_users.id_user', '=', Session::get('user')->id)
//                ->lists('nome', 'id');
//
//        $parrSelezionata = 0;
//                    echo $parrocchieCombo2;
//
//        if (count($parrocchieCombo) == 1) {
//            $parrSelezionata = key($parrocchieCombo2);
//        }
        Session::put('parrocchiaSelezionata', null);
    }

    public function domandaDeleteUtente($id) {
        $user = User::find($id);

//        $news = DB::table('news')
//                ->select('news.id')
//                ->where('news.id_user', $user->id)
//                ->get();

        return View::make('utenti.deleteUtente', compact('user'));
    }

    public function deleteUtente() {
        $user = User::findOrFail(Input::get('id'));
        $user->delete();
        return Redirect::to('listaUtenti');
    }

}
