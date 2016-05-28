<?php

//News
Route::get('', 'NeController@home');
Route::get('home', 'NeController@home');
Route::get('up1', 'NeController@up1');
Route::get('up2', 'NeController@up2');
Route::get('up3', 'NeController@up3');
Route::get('vicariato', 'NeController@homeVicariato');
Route::post('cerca', 'NeController@cerca');
Route::get('home2', 'NeController@home2');
Route::get('dropbox', 'UtilityController@dropbox');

Route::get('download/{id}', 'UtilityController@getDownload');
Route::get('downloadBol/{id}', 'UtilityController@getDownloadBol');
Route::get('downloadDoc', 'UtilityController@getDownloadDoc');
Route::get('getImmagine/{nomeFile}', 'UtilityController@getImmagine');

Route::get('createNews', 'NeController@createNews');
Route::post('saveCreateNews', 'NeController@saveCreateNews');

Route::get('dettaglioNews/{id}', 'NeController@dettaglioNews'); //17/11/2015
//Route::get('dettaglioNewsLettura/{id}', 'NeController@dettaglioNewsLettura');
//Route::get('dettaglioNewsModifica/{id}', 'NeController@dettaglioNewsModifica');
Route::get('domandaDeleteNews/{id}', 'NeController@domandaDeleteNews');

Route::post('editNews', 'NeController@editNews');
Route::post('deleteNews', 'NeController@deleteNews');

Route::get('cancellaAllegato/{id}', 'NeController@cancellaAllegato');

//Bollettini
Route::get('insertBollettino', 'BollettiniController@insertBollettino');
Route::post('saveBollettino', 'BollettiniController@saveBollettino');
Route::post('deleteBollettino', 'BollettiniController@deleteBollettino');
Route::get('visualizzaBollettino/{id}', 'BollettiniController@visualizzaBollettino');
Route::get('domandaDeleteBollettino/{id}', 'BollettiniController@domandaDeleteBollettino');

//Orari
Route::get('orari_lista', 'OrariController@orari_lista');
Route::get('orari_dettaglio/{id}', 'OrariController@orari_dettaglio');
Route::post('orari_salva', 'OrariController@orari_salva');

//Calendario
Route::get('calendarioGeneraleLista', 'CalendarioController@calendarioGeneraleLista');
Route::get('avantiMeseCalendario', 'CalendarioController@avantiMeseCalendario');
Route::get('indietroMeseCalendario', 'CalendarioController@indietroMeseCalendario');

//Utenti
Route::get('listaUtenti', 'UsersController@listaUtenti');
Route::get('visualizzaMascheraInserimentoPersona', 'UsersController@visualizzaMascheraInserimentoPersona');
Route::post('saveCreateUsers', 'UsersController@saveCreateUsers');
Route::get('visualizzaMascheraModificaPersona/{id}', 'UsersController@visualizzaMascheraModificaPersona');
Route::get('domandaDeleteUtente/{id}', 'UsersController@domandaDeleteUtente');
Route::post('deleteUtente', 'UsersController@deleteutente');

//Contact
Route::get('contattaMain', 'ContactController@contattaMain');
Route::get('contattaAmbito', 'ContactController@contattaAmbito');
Route::get('contattaParrocchia', 'ContactController@contattaParrocchia');
Route::post('invioMessaggioContattaMain', 'ContactController@invioMessaggioContattaMain');
Route::post('invioMessaggioContattaAmbito', 'ContactController@invioMessaggioContattaAmbito');
Route::post('invioMessaggioContattaParrocchia', 'ContactController@invioMessaggioContattaParrocchia');

//Ambito
Route::get('mostraAmbito/{id}', 'AmbitiController@mostraAmbito');
Route::post('saveCorpoAmbito', 'AmbitiController@saveCorpoAmbito');
Route::get('listaAmbiti', 'AmbitiController@listaAmbiti');
Route::get('visualizzaMascheraInserimentoAmbito', 'AmbitiController@visualizzaMascheraInserimentoAmbito');
Route::post('saveCreateAmbito', 'AmbitiController@saveCreateAmbito');
Route::get('visualizzaMascheraModificaAmbito/{id}', 'AmbitiController@visualizzaMascheraModificaAmbito');
Route::get('domandaDeleteAmbito/{id}', 'AmbitiController@domandaDeleteAmbito');
Route::post('deleteAmbito', 'AmbitiController@deleteAmbito');
Route::get('visualizzaContenitoreAmbito/{id}', 'AmbitiController@visualizzaContenitoreAmbito');


//Ambiti/Utenti
Route::get('listaAmbitiUtenti', 'AmbitiUtentiController@listaAmbitiUtenti');
Route::get('visualizzaMascheraInserimentoUtenteAmbito', 'AmbitiUtentiController@visualizzaMascheraInserimentoUtenteAmbito');
Route::post('saveCreateUtenteAmbito', 'AmbitiUtentiController@saveCreateUtenteAmbito');
Route::get('deleteUtenteAmbito/{id}', 'AmbitiUtentiController@deleteUtenteAmbito');
Route::get('visualizzaMascheraModificaUtenteAmbito/{id}', 'AmbitiUtentiController@visualizzaMascheraModificaUtenteAmbito');
Route::post('saveModificaUtenteAmbito', 'AmbitiUtentiController@saveModificaUtenteAmbito');


//Parrocchia
Route::get('mostraParrocchia/{id}', 'ParrocchieController@mostraParrocchia');
//Route::get('selezioneParrocchia', 'ParrocchieController@selezioneParrocchia'); //Per combo luoghi
Route::post('saveCorpoParrocchia', 'ParrocchieController@saveCorpoParrocchia');
Route::get('listaParrocchie', 'ParrocchieController@listaParrocchie');
Route::get('visualizzaMascheraInserimentoParrocchia', 'ParrocchieController@visualizzaMascheraInserimentoParrocchia');
Route::post('saveCreateParrocchia', 'ParrocchieController@saveCreateParrocchia');
Route::get('visualizzaMascheraModificaParrocchia/{id}', 'ParrocchieController@visualizzaMascheraModificaParrocchia');
Route::get('domandaDeleteParrocchia/{id}', 'ParrocchieController@domandaDeleteParrocchia');
Route::post('deleteParrocchia', 'ParrocchieController@deleteParrocchia');
Route::get('inserisciDipendenza/{id}', 'ParrocchieController@inserisciDipendenza');
Route::post('effettuaInserimentoDipendenza', 'ParrocchieController@effettuaInserimentoDipendenza');
Route::get('visualizzaContenitoreParrocchia/{id}', 'ParrocchieController@visualizzaContenitoreParrocchia');
Route::post('saveCorpoParrocchia', 'ParrocchieController@saveCorpoParrocchia');
Route::get('visualizzaInformazioniParrocchia/{id}', 'ParrocchieController@visualizzaInformazioniParrocchia');

//Login
Route::get('login', 'UsersController@login');
Route::get('uscita', 'UsersController@uscita');
Route::post('controlloLogin', 'UsersController@controlloLogin');

//Parrocchie/Utenti
Route::get('listaParrocchieUtenti', 'ParrocchieUtentiController@listaParrocchieUtenti');
Route::get('visualizzaMascheraInserimentoUtenteParrocchia', 'ParrocchieUtentiController@visualizzaMascheraInserimentoUtenteParrocchia');
Route::get('visualizzaMascheraModificaParrocchiaUser/{id}', 'ParrocchieUtentiController@visualizzaMascheraModificaParrocchiaUser');
Route::post('saveCreateUtenteParrocchia', 'ParrocchieUtentiController@saveCreateUtenteParrocchia');
Route::get('deleteUtenteParrocchia/{id}', 'ParrocchieUtentiController@deleteUtenteParrocchia');

//Dati Generali
Route::post('saveDatiGenerali', 'DatiGeneraliController@saveDatiGenerali');
Route::get('visualizzaDatiGenerali', 'DatiGeneraliController@visualizzaDatiGenerali');

//Contenitori
Route::get('listaContenitori', 'ContenitoriController@listaContenitori');
Route::get('visualizzaMascheraInserimentoContenitore', 'ContenitoriController@visualizzaMascheraInserimentoContenitore');
Route::post('saveCreateContenitore', 'ContenitoriController@saveCreateContenitore');
Route::get('visualizzaMascheraModificaContenitore/{id}', 'ContenitoriController@visualizzaMascheraModificaContenitore');
Route::get('domandaDeleteContenitore/{id}', 'ContenitoriController@domandaDeleteContenitore');
Route::post('deleteContenitore', 'ContenitoriController@deleteContenitore');

//Contenitori/Utenti
Route::get('listaContenitoriUtenti', 'ContenitoriUtentiController@listaContenitoriUtenti');
Route::get('visualizzaMascheraInserimentoUtenteContenitore', 'ContenitoriUtentiController@visualizzaMascheraInserimentoUtenteContenitore');
Route::post('saveCreateUtenteContenitore', 'ContenitoriUtentiController@saveCreateUtenteContenitore');
Route::get('deleteUtenteContenitore/{id}', 'ContenitoriUtentiController@deleteUtenteContenitore');

//Link
Route::get('listaLinkGestione/{id}', 'LinkController@listaLinkGestione');
Route::get('listaLink/{id}', 'LinkController@listaLink');
Route::get('visualizzaMascheraInserimentoLink', 'LinkController@visualizzaMascheraInserimentoLink');
Route::get('visualizzaMascheraModificaLink/{id}', 'LinkController@visualizzaMascheraModificaLink');
Route::get('domandaDeleteLink/{id}', 'LinkController@domandaDeleteLink');
Route::post('deleteCollegamento', 'LinkController@deleteCollegamento');
Route::post('saveCreateCollegamento', 'LinkController@saveCreateCollegamento');


//Extra
Route::get('daFare', 'UtilityController@daFare');