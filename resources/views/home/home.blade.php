@extends('layout')

@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')
<table class="col-md-12" style="margin-top: -37px">
    <thead>
        <tr>
            @if (Session::get('tipoVicariatoUP') == 'V')
            <th class="col-md-2 text-center label label-primary"><small>Parrocchie</small></th> 
            <th class="col-md-3 text-center label label-primary"><small>Gruppi Vicariali</small></th> 
            <th class="col-md-2 text-center label label-primary"><small>Bollettini</small></th> 
            <th class="col-md-3 text-center label label-primary"><small>Prossimamente</small></th> 
            <th class="col-md-2 text-center label label-primary"><small> </small></th> 
            @else
            <th class="col-md-4 text-center label label-primary"><small>Gruppi</small></th> 
            <th class="col-md-3 text-center label label-primary"><small>Bollettini</small></th> 
            <th class="col-md-3 text-center label label-primary"><small>Prossimamente<small></th> 
            <th class="col-md-2 text-center label label-primary"><small> </small></th> 
            @endif
        </tr>
    </thead>
    <tbody>
        <tr>
            @if (Session::get('tipoVicariatoUP') == 'V')
            <td id="tdSezioni">@include('home.incListaParrocchie')</td>
            <td id="tdSezioni">@include('home.incListaAmbiti')</td>
            <td id="tdSezioni">@include('home.incBollettini')</td>
            <td id="tdSezioni">@include('home.incRotatore')</td>
            <td id="tdSezioni">@include('home.incSlideParrocchie')</td>
            @else
            <td id="tdSezioni">@include('home.incListaAmbiti')</td>
            <td id="tdSezioni">@include('home.incBollettini')</td>
            <td id="tdSezioni">@include('home.incRotatore')</td>
            <td id="tdSezioni">@include('home.incSlideParrocchie')</td>
            @endif
        </tr>
    </tbody>
</table>
@include('home.incListaNewsPrimoPiano')
@include('home.incListaNews')
@include('home.bottom')
@stop
