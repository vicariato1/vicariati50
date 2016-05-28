@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
<div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'saveCreateUtenteParrocchia', 'class' => 'form-horizontal', 'id' => 'myForm']) !!}
        {!! Form::hidden('id', $parrocchieUsers->id)!!}

        <div class="form-group">
            {!! Form::label('aaaa', 'User:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select('id_user', array('default' => 'Seleziona...')+$usersCombo, $parrocchieUsers->id_user ) !!}  
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Parrocchia:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select('id_parrocchia', array('default' => 'Seleziona...')+Session::get('parrocchieCombo'), $parrocchieUsers->id_parrocchia ) !!}  
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Pubblica Bollettini:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::checkbox('pubblica_bollettini', true, $parrocchieUsers->pubblica_bollettini) !!} 
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Pubblica News:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::checkbox('pubblica_news', true, $parrocchieUsers->pubblica_news) !!} 
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Gestione Primo Piano:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::checkbox('gestisci_primo_piano', true, $parrocchieUsers->gestisci_primo_piano) !!} 
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







