@extends('layout')

@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')


<div class="col-md-12 label label-primary" style="margin-top:-37px;">
    <h3>{!! Form::label(null, $ambito->nome) !!}</h3>
</div>

@if(Session::has('flash_message'))
    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><h4> {!! session('flash_message') !!}</h4></div>
@endif

@if (!$contenitori->isEmpty())
<div class="col-md-12" style="margin-top: 10px;margin-bottom: 20px;">
    {!! Form::label('aaaa', 'Visualizza Contenitori') !!}
    @foreach($contenitori as $contenitore)
    <h4><a href="{!! URL::to('visualizzaContenitoreAmbito', $contenitore->id) !!}">{!! $contenitore->nome. str_repeat('&nbsp;', 2) !!}</a></h4>
    @endforeach
</div>
@endif

<div class="col-md-12" style="margin-top: 5px">
    <h4>{!! Form::label(null, $rigaResponsabili) !!}<h4>
            <a href="{{ URL::to('contattaAmbito') }}" class="btn btn-success">Contatta</a>
            </div>


            <div class="col-md-12" style="margin-top:-20px;">
                <h3>{!! HTML::link($ambito->link_diretto_1, $ambito->label_link_diretto_1) !!}</h3>
            </div>

            <div class="col-md-12" style="margin-top: 20px;">
                {!! Form::label(null, 'Presentazione gruppo') !!}
            </div>
            @if ((Session::get('utenteAutenticato') and ($ambito->utenteAppartenenteAmbito or Session::get('user')->admin == 1)))
            <div class="col-md-12" style="margin-top: -10px;">
                {!! Form::open(['url'=> 'saveCorpoAmbito', 'class' => 'form-horizontal']) !!}
                {!! Form::textarea('body', $ambito->body, array('id'=>'body','class'=>'jqte-body')) !!}
                {!! Form::submit('Salva', ['class' => 'btn btn-primary']) !!}
            </div>
            @else
            <div class="col-md-12" style="margin-top: -10px;">
                {!! Form::textarea('body', $ambito->body, array('id'=>'body','class'=>'jqte-body-lettura','class'=>'jqte-body-lettura','readonly'=>'true')) !!}
            </div>
            @endif


            @include('home.incListaNewsPrimoPiano')
            @include('home.incListaNews')


            <script>
                $('.jqte-body').jqte({
                    sub: false,
                    sup: false,
                    strike: false,
                    remove: false,
                    source: false
                });
                $('.jqte-body-lettura').jqte({
                    b: false,
                    i: false,
                    indent: false,
                    link: false,
                    left: false,
                    ol: false,
                    fsize: false,
                    format: false,
                    color: false,
                    sub: false,
                    outdent: false,
                    center: false,
                    remove: false,
                    right: false,
                    rule: false,
                    u: false,
                    ul: false,
                    unlink: false,
                    sup: false,
                    strike: false,
                    source: false
                });

                $('.jqte-body-lettura').parents(".jqte").find(".jqte_toolbar").hide();
                $('.jqte-body-lettura').parents(".jqte").css('max-height', '200px');
                $('.jqte-body-lettura').parents(".jqte").css('overflow-y', 'auto');

            </script>

            <style>
                h4 {
                    display: inline;
                }
            </style>

            @stop
