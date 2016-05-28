@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="col-md-12">

    <a href="{!! URL::to('visualizzaMascheraInserimentoUtenteParrocchia') !!}">Inserisci Associazione Utente/Parrocchia</a>

    @if ($parrocchieUtenti->isEmpty())
    <p> Nessuna Associazione Parrocchie/Ambito presente!</p>
    @else
    <table class="table table-striped  table-condensed">
        <thead>
            <tr>
                <th class="col-md-4 text-center"><small>User</small></th> 
                <th class="col-md-3 text-center"><small>Parrocchia</small></th> 
                <th class="col-md-1 text-center"><small>Pubblica Bollettini</small></th> 
                <th class="col-md-1 text-center"><small>Pubblica News</small></th> 
                <th class="col-md-2 text-center"><small>Gestione Primo Piano</small></th> 
                <th class="col-md-1 text-center"><small></small></th> 
            </tr>
        </thead>
        <tbody>
            @foreach($parrocchieUtenti as $parrocchiaUtente)
            <tr>
                <td>
                    <a href="{!! URL::to('visualizzaMascheraModificaParrocchiaUser', $parrocchiaUtente->id) !!}">{!! $parrocchiaUtente->nome_user !!}</a>
                </td>
                <td class="text-left">{!! $parrocchiaUtente->nome_parrocchia !!}</td>
                @if ($parrocchiaUtente->pubblica_bollettini)
                <td class="text-center">✔</td>
                @else
                <td></td>
                @endif
                @if ($parrocchiaUtente->pubblica_news)
                <td class="text-center">✔</td>
                @else
                <td></td>
                @endif
                @if ($parrocchiaUtente->gestisci_primo_piano)
                <td class="text-center">✔</td>
                @else
                <td></td>
                @endif
                <td><a href="{!! URL::to('deleteUtenteParrocchia', $parrocchiaUtente->id) !!}">{!! HTML::image("/img/trash.gif") !!}</a></td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="divPaginazione" class="text-center">
        {!! str_replace('/?', '?', $parrocchieUtenti->render()) !!}
    </div>
    @endif

</div>

@stop


