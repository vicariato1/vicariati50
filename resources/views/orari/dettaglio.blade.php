@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<br>
<br>
@if ( $errors->count() > 0 )
<p>Sono stati rilevati i seguenti errori:</p>

<ul>
    @foreach( $errors->all() as $message )
    <li>{!! $message !!}</li>
    @endforeach
</ul>
@endif
<div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'orari_salva', 'class' => 'form-horizontal', 'files'=>true]) !!}
        {!! Form::hidden('id', $parrocchia->id)!!}


       <div class="form-group">
            {!! Form::label(null, 'Orario Festivo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('orario_festivo',$parrocchia->orario_festivo,  ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label(null, 'Orario Prefestivo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('orario_prefestivo',$parrocchia->orario_prefestivo,  ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label(null, 'Feriale:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('orario_feriale',$parrocchia->orario_feriale,  ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::submit('Salva', ['class' => 'btn btn-primary']) !!}
        </div>


        {!! Form::close() !!}

    </div>

    @stop







