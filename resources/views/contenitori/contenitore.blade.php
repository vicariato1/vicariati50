@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="col-md-9" style="margin-top:-20px;">
    <h1>{!! Form::label(null, $ambito->nome) !!}</h1>
</div>

<div class="col-md-4">
    {!! Form::label(null, $rigaResponsabili) !!}
</div>

<div class="col-md-8">
    <a href="{!! URL::to('contattaAmbito') !!}">Invia un messaggio</a>
</div>

<div class="col-md-12" style="margin-top:-20px;">
    <h3><h3>{!! HTML::link($ambito->link_diretto_1, $ambito->label_link_diretto_1) !!}</h3></h3>
</div>

@if (Session::get('utenteAutenticato'))
<div class="col-md-12">
    {!! Form::open(['url'=> 'saveCorpoAmbito', 'class' => 'form-horizontal']) !!}
    {!! Form::textarea('body', $ambito->body, array('id'=>'body','class'=>'jqte-body')) !!}
    {!! Form::submit('Salva', ['class' => 'btn btn-primary']) !!}
</div>
@else
<div class="col-md-12">
    {!! Form::textarea('body', $ambito->body, array('id'=>'body','class'=>'jqte-body-lettura','readonly'=>'true')) !!}
</div>
@endif

@include('home.incListaNews')
<script>
    $('.jqte-body').jqte({
        sub: false,
        sup: false,
        strike: false,
        remove: false,
        source: false
    });
    $('.jqte-body-lettura').jqte({
        b: false,
        i: false,
        indent: false,
        link: false,
        left: false,
        ol: false,
        fsize: false,
        format: false,
        color: false,
        sub: false,
        outdent: false,
        center: false,
        remove: false,
        right: false,
        rule: false,
        u: false,
        ul: false,
        unlink: false,
        sup: false,
        strike: false,
        source: false
    });

    $('.jqte-body-lettura').parents(".jqte").find(".jqte_toolbar").hide();
    $('.jqte-body-lettura').parents(".jqte").css('max-height', '200px');
    $('.jqte-body-lettura').parents(".jqte").css('overflow-y', 'auto');

</script>

@stop
