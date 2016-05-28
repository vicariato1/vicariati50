@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop


@section('content')

<div class="col-md-12">

    <a href="{!! URL::to('visualizzaMascheraInserimentoAmbito') !!}">Inserisci Gruppo/Iniziativa</a>

    @if ($ambiti->isEmpty())
    <p> Nessun Ambito presente!</p>
    @else
    <table class="table table-striped  table-condensed">
        <thead>
            <tr>
                <th class="col-md-5 text-center"><small>Nome</small></th> 
                <th class="col-md-4 text-center"><small>Parrocchia</small></th> 
                <th class="col-md-2 text-center"><small>Pubb. Prima Pagina</small></th> 
                <th class="col-md-1 text-center"></th> 
            </tr>
        </thead>
        <tbody>
            @foreach($ambiti as $ambito)
            <tr>
                <td>
                    <a href="{!! URL::to('visualizzaMascheraModificaAmbito', $ambito->id) !!}">{!! $ambito->nome !!}</a>
                </td>
                <td class="text-left">{!! $ambito->nome_parrocchia !!}</td>
                @if ($ambito->pubblica_prima_pagina)
                <td class="text-center">✔</td>
                @else
                <td></td>
                @endif
                <td><a href="{!! URL::to('domandaDeleteAmbito', $ambito->id) !!}">{!! HTML::image("/img/trash.gif") !!}</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</div>

@stop


