@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

<div class="container">

    <div class="row">

        <div class="form-group">
            {!! Form::label(null, 'Titolo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::label('title', $ne->title) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label(null, 'Parrocchia:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::label('title', $ne->nome_parrocchia) !!}
            </div>
        </div>

        @if ($ne->luogo !== '')
        <div class="form-group">
            {!! Form::label(null, 'Luogo/Stanza:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::label(null, $ne->luogo) !!}
            </div>
        </div>
        @endif


        @if ($ne->body !== '')
        <div class="form-group">
            {!! Form::label(null, 'Testo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10" >
                {!! Form::textarea('body', $ne->body, array('id'=>'body','class'=>'jqte-body-lettura','disabled'=>'true')) !!}
            </div>
        </div>
        @endif

        @foreach($attachments as $attachment)
        @if ($attachment->immagine)
        <div class="form-group">
            {!! Form::label(null, null, ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                <img id="immagine" src="{!! $attachment->src !!} "/>
            </div>
        </div>

        @else
        <div class="form-group">
            {!! Form::label(null, null, ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                <h4><a href="{!! URL::to('download', $attachment->id) !!}">{!! $attachment->nome !!}</a></h4>
            </div>
        </div>
        @endif
        @endforeach


        <!--
                <div class="form-group">
                    {!! Form::label(null, 'Ambito:', ['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::label('title', $ne->nome_ambito, ['class'=>'form-control']) !!}
                    </div>
                </div>
        
                <div class="form-group">
                    {!! Form::label('aaaa', 'Data:', ['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        @if ($ne->data_evento_da !== '--')
                        {!! Form::label('title', date("d/m/Y",strtotime($ne->data_evento_da)), ['class'=>'form-control']) !!}
                        @else
                        {!! Form::label(null, '', ['class'=>'form-control']) !!}
                        @endif
                    </div>
                    <div class="form-inline col-sm-8">
                        {!! Form::label(null, 'Ora:', ['class'=>'control-label']) !!}
                        {!! Form::label(null, $ne->ora_inizio.' : '.$ne->minuti_inizio, array('id'=>'ora_inizio','class'=>'form-control')) !!}
                        @if ($ne->ora_fine > 0)
                        {!! Form::label(null, ' A:', ['class'=>'control-label']) !!}
                        {!! Form::label(null, $ne->ora_fine.':'.$ne->minuti_fine, array('id'=>'ora_fine','class'=>'form-control')) !!}
                        @endif
                    </div>
                </div>
        
                <div class="form-group">
                    {!! Form::label(null, 'Pubblic.:', ['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::label('title', $ne->nome_user . ' - ' . date("d/m/Y H:i",strtotime($ne->created_at)), ['class'=>'form-control']) !!}
                    </div>
                </div>
        
                @if ($ne->posizione_primo_piano > 0)
                <div class="form-group">
                    {!! Form::label(null, 'Primo Piano:', ['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::label('title', $ne->posizione_primo_piano, ['class'=>'form-control']) !!}
                    </div>
                </div>
                @endif
        
                <div class="form-group">
                    {!! Form::label(null, 'Accessi:', ['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::label('title', $ne->count, ['class'=>'form-control']) !!}
                    </div>
                </div>
        -->

    </div>

</div>




<style>
    #ora_inizio  {
        width: 100px;
    }
    #ora_fine  {
        width: 100px;
    }
    #immagine  {
        max-width: 100%;
    }
</style>

<script>
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
    $('.jqte_editor').prop('contenteditable', 'false');

    $(function () {
        $("#datepicker").datepicker({
            regional: 'it',
            defaultDate: new Date()
        });
    });

</script>



@stop