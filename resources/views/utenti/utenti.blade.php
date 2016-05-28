@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="col-md-12">

    <a href="{!! URL::to('visualizzaMascheraInserimentoPersona') !!}">Inserisci Persona</a>

    @if ($utenti->isEmpty())
    <p> Nessun Utente presente!</p>
    @else
    <table class="table table-striped  table-condensed">
        <thead>
            <tr>
                <th class="col-md-4 text-center"><small>Nome</small></th> 
                <th class="col-md-4 text-center"><small>E-Mail</small></th> 
                <th class="col-md-3 text-center"><small>Amministratore</small></th> 
                <th class="col-md-1 text-center"></th> 
            </tr>
        </thead>
        <tbody>
            @foreach($utenti as $utente)
            <tr>
                <td>
                    <a href="{!! URL::to('visualizzaMascheraModificaPersona', $utente->id) !!}">{!! $utente->nome !!}</a>
                </td>
                <td class="text-left">{!! $utente->email !!}</td>
                @if ($utente->admin == 1)
                <td class="text-center">Sì</td>
                @else
                <td class="text-center">No</td>
                @endif
                <td><a href="{!! URL::to('domandaDeleteUtente', $utente->id) !!}">{!! HTML::image("/img/trash.gif") !!}</a></td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="divPaginazione" class="text-center">
        {!! str_replace('/?', '?', $utenti->render()) !!}
    </div>
    
    @endif

</div>

@stop


