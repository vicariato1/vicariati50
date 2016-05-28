@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')
<section class="header section-padding">
    <div class="background">&nbsp;</div>
    <div class="container">
        <div class="header-text">
             <p>
                Cancellazione Contenitore
            </p>
        </div>
    </div>
</section>

<div class="container">
    <section class="section-padding">
        <div class="jumbotron text-center">
            <h3>Si desidera cancellare il contenitore <br> {!! $contenitore->nome !!}? </h3>

            {!! Form::open(['url'=> 'deleteContenitore', 'class'=>'form']) !!}
            {!! Form::hidden('id', $contenitore->id)!!}

            <div class="form-group">
                {!! Form::submit('Cancella', ['class' => 'btn btn-primary']) !!}
                <a href="{!! URL::to('listaContenitori') !!}"
                   class="btn btn-danger"> No </a>
            </div>

            {!! Form::close() !!}

        </div>
    </section>
</div>
@stop