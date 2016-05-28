@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="container">
    <div class="row">
        {!! Form::open(['url'=> '/saveBollettino', 'class' => 'form-horizontal', 'id' => 'myForm','files'=>true]) !!}

        <div class="form-group">
            {!! Form::label('title', 'Titolo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('title', Input::old('title'), ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Aggiungi Bollettino:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::file('bollettino') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('', '', ['class'=>'col-sm-1 control-label']) !!}
            <div class="col-md-11">
                {!! Form::submit('Salva', ['class'=>'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>


    @stop







