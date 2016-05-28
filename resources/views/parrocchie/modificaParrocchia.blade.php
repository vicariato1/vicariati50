@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
<div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'saveCreateParrocchia', 'class' => 'form-horizontal', 'id' => 'myForm','files'=>true]) !!}
        {!! Form::hidden('id', $parrocchie->id)!!}

        <div class="form-group">
            {!! Form::label(null, 'Nome:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('nome', $parrocchie->nome, ['class'=>'col-md-12']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label(null, ' (Opzionale) Link:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="form-inline col-md-10">
                {!! Form::text('link_diretto_1', $parrocchie->link_diretto_1, ['class'=>'col-md-5']) !!}
                {!! Form::label(null, ' Testo:', ['class'=>'col-md-1 control-label']) !!}
                {!! Form::text('label_link_diretto_1', $parrocchie->label_link_diretto_1, ['class'=>'col-md-6']) !!}
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('aaaa', 'Visualizza Bollettini:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::checkbox('visualizza_bollettini', true, $parrocchie->visualizza_bollettini) !!} 
            </div>
        </div>

        {!! HTML::image( 'chiese/' . $parrocchie->nome_file_immagine, null , null) !!}

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Sostituisci immagine', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::file('immagineParrocchia') !!}
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
</div>

@stop











