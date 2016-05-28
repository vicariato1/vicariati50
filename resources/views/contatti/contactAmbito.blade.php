@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')


<div class="col-md-12">
    <h1>{!! $nomeVicariatoParrocchiaAmbito !!}</h1>
    <p>Contatta i responsabili inserendo un testo nel riquadro sottostante:</p>

    {!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
    {!! Form::open(['url'=> 'invioMessaggioContattaAmbito', 'class' => 'form-horizontal']) !!}


    <div class="form-group">
        {!! Form::label('title', 'E-Mail:', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::text('subject', null, ['class'=>'form-control']) !!}
        </div>
    </div>

    <br />
    <br />

    <div class="form-group">
        {!! Form::label('title', 'Testo:', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-md-10">
            {!! Form::textarea('message', null, ['class'=>'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('title', 'Immagine CAPTCHA:', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-md-10">
            {!! HTML::image(SimpleCaptcha::img(), 'Captcha image') !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('title', 'Codice CAPTCHA:', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-md-10">
        </div>
    </div>

    <br />
    {!! Form::submit() !!}
    {!! Form::close() !!}
</div>




@stop