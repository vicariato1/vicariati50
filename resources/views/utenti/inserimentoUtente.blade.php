@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
<div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'saveCreateUsers', 'class' => 'form-horizontal', 'id' => 'myForm']) !!}

        <div class="form-group">
            {!! Form::label(null, 'Nome:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('nome', Input::old('nome'), ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label(null, 'E-Mail:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('email', Input::old('email'), ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Utente Amministratore:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::checkbox('admin', true, false) !!} 
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Utente Registrato:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::checkbox('registrato', true, false) !!} 
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







