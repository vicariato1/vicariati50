@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
<div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'saveDatiGenerali', 'class' => 'form-horizontal', 'id' => 'myForm']) !!}
        {!! Form::hidden('id', $datiGenerali->id)!!}

        <div class="form-group">
            {!! Form::label(null, 'Titolo Generale:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('titolo_generale', $datiGenerali->titolo_generale, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label(null, 'Sottotitolo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('sottotitolo', $datiGenerali->sottotitolo, ['class'=>'form-control']) !!}
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











