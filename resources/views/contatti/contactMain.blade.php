@extends('layout')

@section('contentHeader')
@include('layoutHeader')
@stop


@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
{!! Form::open(['url'=> 'invioMessaggioContattaMain', 'class' => 'form-horizontal', 'id' => 'myForm']) !!}

<div class="col-md-12">

    <b><p>Con questo modulo contatterai l'amministratore del sito</p></b>
    <b><p>Per contattare i responsabili dei vari ambiti accedi alle rispettive pagine</p></b>


    <div class="form-group">
        {!! Form::label('title', 'Scrivi la tua e-mail:', ['class'=>'col-sm-2 control-label']) !!}
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

    <!--
    <div class="form-group">
        {!! Form::label('title', 'Codice CAPTCHA:', ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-md-10">
             {!! app('captcha')->display(); !!} 
        </div>
    </div>
    -->

    <br />
    {!! Form::submit() !!}
    {!! Form::close() !!}
</div>


@stop