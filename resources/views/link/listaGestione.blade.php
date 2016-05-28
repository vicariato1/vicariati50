@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="col-md-12">

    <a href="{!! URL::to('visualizzaMascheraInserimentoLink') !!}">Inserisci Link</a>

    <table class="table table-striped  table-condensed">
        <thead>
            <tr>
                <th class="col-md-5 text-center"><small>Testo</small></th> 
                <th class="col-md-5 text-center"><small>Link</small></th> 
                <th class="col-md-2 text-center"></th> 
            </tr>
        </thead>
        <tbody>
            @foreach($links as $link)
            <tr>
                <td>
                    <a href="{!! URL::to('visualizzaMascheraModificaLink', $link->id) !!}">{!! $link->titolo_link !!}</a>
                </td>
                <td class="text-left">{!! $link->titolo_link !!}</td>
                <td class="text-left">{!! $link->link !!}</td>
                <td>
                    <a href="{!! URL::to('domandaDeleteLink', $link->id) !!}">{!! HTML::image("/img/trash.gif") !!}</a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop


