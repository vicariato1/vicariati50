@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<br>
<br>



<div class="container">

    <section class="section-padding">

        @if($errors->has())
        <div class="row" >
            <div class="col-md-2">
            </div>
            <div class="col-md-10">
                Sono stati riscontrati i seguenti errori:
                <ul>
                </ul>
                <ul>
                    @foreach($errors->all() as $message)
                    <li>{!! $message !!}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <h1 class="text-center">Login</h1>

        <div class="row">

            {!! Form::open(['url'=> 'controlloLogin', 'class' => 'form']) !!}
            {!! Form::hidden('primoIngresso', $user->primoIngresso)!!}

            <div class="col-md-2 text-right">
                {!! Form::label('email', 'E-Mail:') !!}
            </div>
            <div class="col-md-10">
                {!! Form::text('email', $user->email, array('placeholder' => 'Email', 'class' => 'form-control')) !!}
            </div>

            <br>
            <br>
            @if ($user->primoIngresso)
            <div class="col-md-12">
                {!! Form::label(null, 'Attenzione: la password che ora inserirai sarà memorizzata ') !!}
            </div>
            @endif

            @if ($user->primoIngressoPasswordErrata)
            <div class="col-md-12">
                {!! Form::label(null, 'Attenzione: password primo ingresso errata ') !!}
            </div>
            @endif

            @if ($user->passwordNonCoincidenti)
            <div class="col-md-12">
                {!! Form::label(null, 'Attenzione: password non coincidenti ') !!}
            </div>
            @endif


            <div class="col-md-2 text-right">
                {!! Form::label('password', 'Password:') !!}
            </div>
            <div class="col-md-10">
                {!! Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control'))  !!}
            </div>

            @if ($user->primoIngresso)
            <div class="col-md-2 text-right">
                {!! Form::label('password', 'Ripeti Password:') !!}
            </div>

            <br>
            <br>

            <div class="col-md-10">
                {!! Form::password('password2', array('placeholder' => 'Password', 'class' => 'form-control'))  !!}
            </div>
            @endif




            <br>
            <br>

            <div class="text-center">
                {!! Form::submit('Effettua Login', ['class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}

            <!--
            <div class="text-center">
                <a class="text-center" href="{!! URL::to('register') !!}">Registrati</a>
            </div>
            -->


        </div>
    </section>
</div>

@stop