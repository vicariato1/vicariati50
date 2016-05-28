@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="col-md-12">

    <a href="{!! URL::to('visualizzaMascheraInserimentoParrocchia') !!}">Inserisci Parrocchia</a>

    @if ($parrocchie->isEmpty())
    <p> Nessuna Parrocchia presente!</p>
    @else
    <table class="table table-striped  table-condensed">
        <thead>
            <tr>
                <th class="col-md-3 text-center"><small>Nome</small></th> 
                <th class="col-md-3 text-center"><small>Dipendenze</small></th> 
                <th class="col-md-3 text-center"></th> 
                <th class="col-md-3 text-center"></th> 
            </tr>
        </thead>
        <tbody>
            @foreach($parrocchie as $parrocchia)
            <tr>
                <td>
                    <a href="{!! URL::to('visualizzaMascheraModificaParrocchia', $parrocchia->id) !!}">
                        {!! $parrocchia->nome !!}</a>
                </td>
                <td>{!! $parrocchia->dipendenze !!}</td>
                <td><a href="{!! URL::to('domandaDeleteParrocchia', $parrocchia->id) !!}">{!! HTML::image("img/trash.gif") !!}</a></td>
                <td><a href="{!! URL::to('inserisciDipendenza', $parrocchia->id) !!}">Inserisci Dipendenza</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</div>


@stop


