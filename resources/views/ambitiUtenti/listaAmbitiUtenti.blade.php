@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="col-md-12">

    <a href="{!! URL::to('visualizzaMascheraInserimentoUtenteAmbito') !!}">Inserisci Associazione Utente/Ambito</a>

    @if ($ambitiUtenti->isEmpty())
    <p> Nessuna Associazione Persona/Ambito presente!</p>
    @else
    <table class="table table-striped  table-condensed">
        <thead>
            <tr>
                <th class="col-md-4 text-center"><small>User</small></th> 
                <th class="col-md-4 text-center"><small>Ambito</small></th> 
                <th class="col-md-2 text-center"><small>Parrocchia</small></th> 
                <th class="col-md-1 text-center"><small>Primo Piano</small></th> 
                <th class="col-md-1 text-center"><small></small></th> 
            </tr>
        </thead>
        <tbody>
            @foreach($ambitiUtenti as $ambito)
            <tr>
                <td>
                    <a href="{!! URL::to('visualizzaMascheraModificaUtenteAmbito', $ambito->id) !!}">{!! $ambito->nome_user !!}</a>
                </td>
                <td>
                    <a href="{!! URL::to('visualizzaMascheraModificaUtenteAmbito', $ambito->id) !!}">{!! $ambito->nome !!}</a>
                </td>
                <td class="text-left">{!! $ambito->nome_parrocchia !!}</td>
                @if ($ambito->gestisci_primo_piano)
                <td class="text-center">✔</td>
                @else
                <td></td>
                @endif
                <td><a href="{!! URL::to('deleteUtenteAmbito', $ambito->id) !!}">{!! HTML::image("/img/trash.gif") !!}</a></td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="divPaginazione" class="text-center">
        {!! str_replace('/?', '?', $ambitiUtenti->render()) !!}
    </div>
    @endif

</div>

@stop


