@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
   <div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'saveModificaUtenteAmbito', 'class' => 'form-horizontal', 'id' => 'myForm']) !!}
        {!! Form::hidden('id', $ambitiUsers->id)!!}

        <div class="form-group">
            {!! Form::label('aaaa', 'User:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::label('title', $ambitiUsers->user, ['class'=>'form-control']) !!}
            </div>
         </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Ambito:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::label('title', $ambitiUsers->ambito, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Gestione Primo Piano:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::checkbox('gestisci_primo_piano', true, $ambitiUsers->gestisci_primo_piano) !!} 
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
    
    
    
    
 







