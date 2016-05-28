@extends('layout')

@section('contentHeader')
@include('layoutHeader')
@stop


@section('content')

<div class="col-md-12 label label-primary " style="margin-top:-30px;">
    <h3>{!! Form::label(null, $parrocchia->nomeDisplay) !!}</h3>
</div>

@if(Session::has('flash_message'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><h4> {!! session('flash_message') !!}</h4></div>
@endif

@if (!is_null($parrocchia->link_diretto_1))
<div class="col-md-12" style="margin-top: -20px;">
    <h3>{!! HTML::link($parrocchia->link_diretto_1, $parrocchia->label_link_diretto_1) !!}</h3>
</div>
@endif

@if (!$contenitori->isEmpty())
<div class="col-md-12" style="margin-top: 10px;margin-bottom: 20px;">
    {!! Form::label('aaaa', 'Visualizza Contenitori') !!}
    @foreach($contenitori as $contenitore)
    <h4><a href="{!! URL::to('visualizzaContenitoreParrocchia', $contenitore->id) !!}">{!! $contenitore->nome. str_repeat('&nbsp;', 2) !!}</a></h4>
    @endforeach
</div>
@endif

<table  style="margin-top: 10px;" class="col-md-12">
    <thead>
        <tr>
            <th class="col-md-3 text-center label label-primary">Gruppi</th> 
            <th class="col-md-3 text-center label label-primary">Bollettini</th> 
            @if (!empty($parrocchia->body))
            <th class="col-md-3 label label-primary">Informazioni</th>
            @endif
            <th class="col-md-3 text-center label label-primary">Orari Messe</th> 
         </tr>
    </thead>
    <tbody>
        <tr>
            <td class="td1">@include('parrocchie.incListaAmbiti')</td>
            <td class="td2">@include('parrocchie.incBollettini')</td>
            @if (!empty($parrocchia->body))
            <td class="td3">@include('parrocchie.incInformazioni')</td>
            @endif
            <td class="td4">@include('parrocchie.incOrariMesse')</td>
        </tr>
    </tbody>
</table>
<style>
    td.td1 {
        border: 1px solid silver;
        border-radius: 5px;
    }
    td.td2 {
        border: 1px solid silver;
        border-radius: 5px;
    }
    td.td3 {
        border: 1px solid silver;
        border-radius: 5px;
    }
    td.td4 {
        border: 1px solid silver;
        border-radius: 5px;
    }
   h4 {
        display: inline;
    }


</style>

@include('home.incListaNewsPrimoPiano')
@include('home.incListaNews')

@stop
