@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="col-md-12">

    <a href="{!! URL::to('visualizzaMascheraInserimentoUtenteContenitore') !!}">Inserisci Associazione Utente/Contenitore</a>

    @if ($contenitoriUtenti->isEmpty())
    <p> Nessuna Associazione Persona/Contenitore presente!</p>
    @else
    <table class="table table-striped  table-condensed">
        <thead>
            <tr>
                <th class="col-md-2 text-center"><small>User</small></th> 
                <th class="col-md-3 text-center"><small>Parrocchia</small></th> 
                <th class="col-md-3 text-center"><small>Ambito</small></th> 
                <th class="col-md-3 text-center"><small>Parrocchia Ambito</small></th> 
                <th class="col-md-1 text-center"><small></small></th> 
            </tr>
        </thead>
        <tbody>
            @foreach($contenitoriUtenti as $contenitoreUtenti)
            <tr>
                <td class="text-left">{!! $contenitoreUtenti->nome_user !!}</td>
                <td class="text-left">{!! $contenitoreUtenti->nome_parrocchia !!}</td>
                <td class="text-left">{!! $contenitoreUtenti->nome_ambito !!}</td>
                <td class="text-left">{!! $contenitoreUtenti->nome_parrocchia_ambito !!}</td>
                <td><a href="{!! URL::to('deleteUtenteContenitore', $contenitoreUtenti->id) !!}">{!! HTML::image("/img/trash.gif") !!}</a></td>

            </tr>
            @endforeach
        </tbody>
    </table>
    {!! $contenitoriUtenti->render() !!}
    @endif

</div>

@stop


