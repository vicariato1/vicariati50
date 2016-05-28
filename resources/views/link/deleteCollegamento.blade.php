@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}

<section class="header section-padding">
    <div class="background">&nbsp;</div>
    <div class="container">
        <div class="header-text">
             <p>
                Cancellazione Link
            </p>
        </div>
    </div>
</section>

<div class="container">
    <section class="section-padding">
        <div class="jumbotron text-center">
            <h3>Si desidera cancellare il link <br> {!! $collegamento->titolo_link !!}? </h3>

            {!! Form::open(['url'=> 'deleteCollegamento', 'class'=>'form']) !!}
            {!! Form::hidden('id', $collegamento->id)!!}

            <div class="form-group">
                {!! Form::submit('Cancella', ['class' => 'btn btn-primary']) !!}
                <a href="{!! URL::to('listaLink') !!}"
                   class="btn btn-danger"> No </a>
            </div>

            {!! Form::close() !!}

        </div>
    </section>
</div>
@stop