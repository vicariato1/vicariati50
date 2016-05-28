@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
<div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'saveCreateContenitore', 'class' => 'form-horizontal', 'id' => 'myForm']) !!}

        <div class="form-group">
            {!! Form::label(null, 'Nome:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('nome', Input::old('nome'), ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Parrocchia:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select('id_parrocchia', array('default' => 'Seleziona...')+Session::get('parrocchieCombo')) !!}  
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Ambito:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                 {!! Form::select('id_ambito', array('default' => 'Seleziona...')+Session::get('ambitiComboTotali')) !!}  
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







