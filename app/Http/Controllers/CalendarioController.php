<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Session;
use DB;
use DateTime;
use View;
use Input;
use Validator;
use Illuminate\Support\MessageBag;
use Redirect;

class CalendarioController extends Controller {

    public function calendarioGeneraleLista() {

        $dataOggi = new DateTime('today');
        $dataOggiPrimoGiornoDelMese = $dataOggi->format('Y-m-1');

        $array = $this->visualizzaCalendario($dataOggiPrimoGiornoDelMese);
        $newss = $array[0];
        $nomeCalendario = $array[1] . ' ' . $dataOggi->format('Y');
        return View::make('calendario.lista', compact('newss', 'nomeCalendario'));
    }

    public function indietroMeseCalendario() {

        $data1 = Session::get('dataSelezionata');
        $date = DateTime::createFromFormat('Y-m-d', $data1);
        $date->modify('previous month');

        $array = $this->visualizzaCalendario($date->format('Y-m-1'));
        $newss = $array[0];
        $nomeCalendario = $array[1] . ' ' . $date->format('Y');
        return View::make('calendario.lista', compact('newss', 'nomeCalendario'));
    }

    public function avantiMeseCalendario() {

        $data1 = Session::get('dataSelezionata');
        $date = DateTime::createFromFormat('Y-m-d', $data1);
        $date->modify('next month');

        $array = $this->visualizzaCalendario($date->format('Y-m-1'));
        $newss = $array[0];
        $nomeCalendario = $array[1] . ' ' . $date->format('Y');

        return View::make('calendario.lista', compact('newss', 'nomeCalendario'));
    }

    public function visualizzaCalendario($data) {

        $numeroGiorniNelMeseAttuale = date("t", strtotime($data));
        $meseAttuale = date("m", strtotime($data));
        $nomeCalendario = "Calendario " . nomeMese($meseAttuale - 1);
        $dt = date("Y-m-d", strtotime($data));
        Session::put('dataSelezionata', $dt);

        $s = "";
        $s.= "select query3.*,contatore from ";
        $s.= "( ";
        $s.= "select query1.*, count(data_calendario) as contatore from ";
        $s.= "( ";
        $s.="select selectdate.data_calendario, ";
        $s.="       selectdate.giorno_settimana, ";
        $s.="       selectnews.id, ";
        $s.="       selectnews.title, ";
        $s.="       selectnews.nome_parrocchia, ";
        $s.="       selectnews.id_parrocchia, ";
        $s.="       selectnews.luogo, ";
        $s.="       selectnews.colore, ";
        $s.="       selectnews.ora_inizio,  ";
        $s.="       selectnews.minuti_inizio,  ";
        $s.="       selectnews.ora_fine,  ";
        $s.="       selectnews.minuti_fine,  ";
        $s.="       selectnews.nome_user  ";
        $s.="  from ";
        $s.="     ( ";
        $s.="       select date('" . date("Y-m-01", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-01", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-02", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-02", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-03", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-03", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-04", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-04", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-05", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-05", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-06", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-06", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-07", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-07", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-08", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-08", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-09", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-09", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-10", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-10", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-11", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-11", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-12", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-12", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-13", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-13", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-14", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-14", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-15", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-15", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-16", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-16", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-17", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-17", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-18", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-18", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-19", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-19", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-20", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-20", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-21", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-21", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-22", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-22", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-23", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-23", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-24", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-24", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-25", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-25", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-26", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-26", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-27", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-27", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-28", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-28", strtotime($data)) . "')) as giorno_settimana ";
        if ($numeroGiorniNelMeseAttuale >= 29) {
            $s.="       union ";
            $s.="       select date('" . date("Y-m-29", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-29", strtotime($data)) . "')) as giorno_settimana ";
        }
        if ($numeroGiorniNelMeseAttuale >= 30) {
            $s.="       union ";
            $s.="       select date('" . date("Y-m-30", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-30", strtotime($data)) . "')) as giorno_settimana ";
        }
        if ($numeroGiorniNelMeseAttuale >= 31) {
            $s.="       union ";
            $s.="       select date('" . date("Y-m-31", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-31", strtotime($data)) . "')) as giorno_settimana ";
        }

        $s.=") selectdate       ";
        $s.="left join (select news.title, ";
        $s.="                  news.id, ";
        $s.="                  news.data_evento_da, ";
        $s.="                  parrocchie.nome as nome_parrocchia, ";
        $s.="                  parrocchie.id   as id_parrocchia, ";
        $s.="                  parrocchie.colore, ";
        $s.="                  news.luogo, ";
        $s.="                  news.ora_inizio,  ";
        $s.="                  news.minuti_inizio,  ";
        $s.="                  news.ora_fine,  ";
        $s.="                  news.minuti_fine,  ";
        $s.="                  users.nome as nome_user  ";
        $s.="             from news  ";
        $s.="                  left join parrocchie  ";
        $s.="                        on parrocchie.id = news.id_parrocchia ";
        $s.="                        and parrocchie.id in (" . implode(",", Session::get('dipendenze')) . ")";
        $s.="                  left join users  ";
        $s.="                        on users.id      = news.id_user ";
        $s.="                  where news.id_parrocchia in (" . implode(",", Session::get('dipendenze')) . ")";
        $s.="             ) selectnews ";
        $s.="on selectdate.data_calendario = data_evento_da ";
        $s.=") query1 ";
        $s.="group by query1.data_calendario ";
        $s.=") query2, ";
        $s.="( ";
        $s.="select selectdate.data_calendario, ";
        $s.="       selectdate.giorno_settimana, ";
        $s.="       selectnews.id, ";
        $s.="       selectnews.title, ";
        $s.="       selectnews.nome_parrocchia, ";
        $s.="       selectnews.id_parrocchia, ";
        $s.="       selectnews.luogo, ";
        $s.="       selectnews.colore, ";
        $s.="       selectnews.ora_inizio,  ";
        $s.="       selectnews.minuti_inizio,  ";
        $s.="       selectnews.ora_fine,  ";
        $s.="       selectnews.minuti_fine,  ";
        $s.="       selectnews.nome_user  ";
        $s.="  from ";
        $s.="     ( ";
        $s.="       select date('" . date("Y-m-01", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-01", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-02", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-02", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-03", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-03", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-04", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-04", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-05", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-05", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-06", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-06", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-07", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-07", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-08", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-08", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-09", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-09", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-10", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-10", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-11", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-11", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-12", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-12", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-13", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-13", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-14", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-14", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-15", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-15", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-16", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-16", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-17", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-17", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-18", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-18", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-19", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-19", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-20", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-20", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-21", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-21", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-22", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-22", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-23", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-23", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-24", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-24", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-25", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-25", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-26", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-26", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-27", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-27", strtotime($data)) . "')) as giorno_settimana ";
        $s.="       union ";
        $s.="       select date('" . date("Y-m-28", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-28", strtotime($data)) . "')) as giorno_settimana ";
        if ($numeroGiorniNelMeseAttuale >= 29) {
            $s.="       union ";
            $s.="       select date('" . date("Y-m-29", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-29", strtotime($data)) . "')) as giorno_settimana ";
        }
        if ($numeroGiorniNelMeseAttuale >= 30) {
            $s.="       union ";
            $s.="       select date('" . date("Y-m-30", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-30", strtotime($data)) . "')) as giorno_settimana ";
        }
        if ($numeroGiorniNelMeseAttuale >= 31) {
            $s.="       union ";
            $s.="       select date('" . date("Y-m-31", strtotime($data)) . "') as data_calendario, strftime('%w',date('" . date("Y-m-31", strtotime($data)) . "')) as giorno_settimana ";
        }

        $s.=") selectdate       ";
        $s.="left join (select news.title, ";
        $s.="                  news.data_evento_da, ";
        $s.="                  news.id, ";
        $s.="                  parrocchie.nome as nome_parrocchia, ";
        $s.="                  parrocchie.id   as id_parrocchia, ";
        $s.="                  parrocchie.colore, ";
        $s.="                  news.luogo, ";
        $s.="                  news.ora_inizio,  ";
        $s.="                  news.minuti_inizio,  ";
        $s.="                  news.ora_fine,  ";
        $s.="                  news.minuti_fine,  ";
        $s.="                  users.nome as nome_user  ";
        $s.="             from news  ";
        $s.="                  left join parrocchie  ";
        $s.="                        on parrocchie.id = news.id_parrocchia ";
        $s.="                  left join users  ";
        $s.="                        on users.id      = news.id_user ";
        $s.="                  where news.id_parrocchia in (" . implode(",", Session::get('dipendenze')) . ")";
        $s.="             ) selectnews ";
        $s.="on selectdate.data_calendario = data_evento_da ";
        $s.=") query3 ";
        $s.="where query2.data_calendario = query3.data_calendario ";

        //echo $s;

        $newss = DB::select($s);

        $cntPrec = 0;
        $giornoSettimanaPrec = -1;
        foreach ($newss as $news) {

            if ($news->giorno_settimana == 1 and $news->giorno_settimana != $giornoSettimanaPrec) {
                $news->scriviRigaInizioSettimana = true;
            } else {
                $news->scriviRigaInizioSettimana = false;
            }
            $giornoSettimanaPrec = $news->giorno_settimana;

            if ($news->contatore == 1) {
                $news->visualizzaData = true;
                $news->rowspan = 0;
            } else {
                if ($cntPrec == 1) {
                    $news->rowspan = $news->contatore;
                    $news->visualizzaData = true;
                    echo $news->contatore;
                } else {
                    $news->visualizzaData = false;
                }
            }
            $cntPrec = $news->contatore;

            if ($news->minuti_inizio == '0') {
                $news->minuti_inizio = '00';
            }
            if ($news->minuti_fine == '0') {
                $news->minuti_fine = '00';
            }

            $news->ora = "";
            if ($news->ora_inizio > 0) {
                $news->ora = $news->ora_inizio . ':' . $news->minuti_inizio;
                if ($news->ora_fine > 0) {
                    $news->ora .= ' - ' . $news->ora_fine . ':' . $news->minuti_fine;
                }
            }
        }

        return array($newss, $nomeCalendario);
    }

}

function nomeMese($month) {
    $mese = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno",
        "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre",);
    $nameMonth = $mese[$month];
    return $nameMonth;
}
