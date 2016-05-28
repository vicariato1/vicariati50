@extends('layout')


@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<table class="col-md-12" style="margin-top: -37px">
    <thead>
        <tr>
            <td class="col-md-02 text-right label label-primary"> </td> 
            <td class="col-md-03 label label-info"><a href="{!! URL::to('indietroMeseCalendario') !!}"><< Mese Precedente</a></td> 
            <td class="col-md-02 text-center label label-primary">{!! Form::label(null, $nomeCalendario ) !!}</td> 
            <td class="col-md-03 label label-info"><a href="{!! URL::to('avantiMeseCalendario') !!}">Mese Successivo >></a></td> 
            <td class="col-md-02 text-left label label-primary"> </td> 
        </tr>
    </thead>
</table>

@include('calendario.incListaCalendario')

@stop


