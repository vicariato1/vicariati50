@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')
<section class="header section-padding">
    <div class="background">&nbsp;</div>
    <div class="container">
        <div class="header-text">
            <h1>Registrazione</h1>
            <p>
                Effettua Registrazione
            </p>
        </div>
    </div>
</section>

<div class="container">
    <section class="section-padding">
        <div class="jumbotron text-center">
            <h1>Login</h1>

            {!! Form::open(['url'=> '/register', 'class' => 'form']) !!}
            <div>
                {!! Form::label('email', 'E-Mail:') !!}
                {!! Form::text('email', null, ['class'=>'form-control']) !!}
            </div>

             <div class="form-group">
                {!! Form::submit('Effettua Registrazione', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}

        </div>
    </section>
</div>
@stop