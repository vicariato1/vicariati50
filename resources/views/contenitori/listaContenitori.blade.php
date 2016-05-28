@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="col-md-12">

    <a href="{!! URL::to('visualizzaMascheraInserimentoContenitore') !!}">Inserisci Contenitore</a>

    @if ($contenitori->isEmpty())
    <p> Nessun Contenitore presente!</p>
    @else
    <table class="table table-striped  table-condensed">
        <thead>
            <tr>
                <th class="col-md-5 text-center"><small>Nome</small></th> 
                <th class="col-md-2 text-center"><small>Parrocchia</small></th> 
                <th class="col-md-2 text-center"><small>Ambito</small></th> 
                <th class="col-md-2 text-center"><small>Parrocchia Ambito</small></th> 
                <th class="col-md-1 text-center"></th> 
            </tr>
        </thead>
        <tbody>
            @foreach($contenitori as $contenitore)
            <tr>
                <td>
                    <a href="{!! URL::to('visualizzaMascheraModificaContenitore', $contenitore->id) !!}">{!! $contenitore->nome !!}</a>
                </td>
                <td>{!! $contenitore->nome_parrocchia !!}</td>
                <td>{!! $contenitore->nome_ambito !!}</td>
                <td>{!! $contenitore->nome_parrocchia_ambito !!}</td>
                <td><a href="{!! URL::to('domandaDeleteContenitore', $contenitore->id) !!}">{!! HTML::image("/img/trash.gif") !!}</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

</div>

@stop


