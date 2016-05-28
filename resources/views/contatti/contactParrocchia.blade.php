@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="col-md-12">

    <div class="col-md-12 label label-primary" style="margin-top:-37px;">
        <h3>{!! Form::label(null, 'Contatti') !!}</h3>
    </div>


    @if (Session::get('utenteAutenticato') and $utenteAppartenenteParrocchia)
    <div class="col-md-12">
        {!! Form::open(['url'=> 'saveCorpoParrocchia', 'class' => 'form-horizontal']) !!}
        {!! Form::textarea('body', $parrocchia->body, array('id'=>'body','class'=>'jqte-body')) !!}
        {!! Form::submit('Salva', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
    @else
    <div class="col-md-12">
        {!! Form::textarea('body', $parrocchia->body, array('id'=>'body','class'=>'jqte-body-lettura','readonly'=>'true')) !!}
    </div>
    @endif

</div>

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
    $('.jqte-body-lettura').parents(".jqte").css('min-height', '350px');
    $('.jqte-body-lettura').parents(".jqte").css('max-height', '600px');
    $('.jqte-body-lettura').parents(".jqte").css('overflow-y', 'auto');

</script>


@stop