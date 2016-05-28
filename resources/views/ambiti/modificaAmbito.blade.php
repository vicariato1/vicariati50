@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
<div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'saveCreateAmbito', 'class' => 'form-horizontal', 'id' => 'myForm']) !!}
        {!! Form::hidden('id', $ambiti->id)!!}

        <div class="form-group">
            {!! Form::label(null, 'Nome:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('nome', $ambiti->nome, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Parrocchia:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select('id_parrocchia', Session::get('parrocchieCombo'), $ambiti->id_parrocchia, array('id'=>'selezioneParrocchia') ) !!}  
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Pubblica Prima Pagina:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::checkbox('pubblica_prima_pagina', true, $ambiti->pubblica_prima_pagina) !!} 
            </div>
        </div>

        <div class="form-group">
            {!! Form::label(null, ' (Opzionale) Link:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="form-inline col-md-10">
                {!! Form::text('link_diretto_1', $ambiti->link_diretto_1, ['class'=>'col-md-5']) !!}
                {!! Form::label(null, ' Testo:', ['class'=>'col-md-1 control-label']) !!}
                {!! Form::text('label_link_diretto_1', $ambiti->label_link_diretto_1, ['class'=>'col-md-6']) !!}
            </div>
        </div>


        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::submit('Salva', ['class'=>'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

    @stop











