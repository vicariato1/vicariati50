@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
<div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'editNews', 'class' => 'form-horizontal', 'files'=>true]) !!}
        {!! Form::hidden('id', $news->id)!!}

        <div class="form-group">
            {!! Form::label('title', 'Titolo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('title', $news->title, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('corpo', 'Testo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('body', $news->body, array('id'=>'body','class'=>'jqte-body')) !!}
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Data Da:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-2">
                @if ($news->data_evento_da !== '--')
                {!! Form::text('data_evento_da', date("d/m/Y",strtotime($news->data_evento_da)), array('id' => 'datepicker','placeholder' => 'Data Evento' )) !!}
                @else
                {!! Form::text('data_evento_da', null, array('id' => 'datepicker','placeholder' => 'Data Evento' )) !!}
                @endif
            </div>
            <div class="form-inline col-md-8">
                {!! Form::label(null, 'Ora Inizio:', ['class'=>'control-label']) !!}
                {!! Form::select('ora_inizio', $ore, $news->ora_inizio) !!}  
                {!! Form::select('minuti_inizio', $minuti, $news->minuti_inizio) !!}  
                {!! Form::label(null, '                                    ', ['class'=>'control-label']) !!}
                {!! Form::label(null, 'Ora Fine:', ['class'=>'control-label']) !!}
                {!! Form::select('ora_fine', $ore, $news->ora_fine) !!}  
                {!! Form::select('minuti_fine', $minuti, $news->minuti_fine) !!}  
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Ambito:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select('id_ambito', $ambitiCombo, $news->id_ambito, array('id'=>'selezioneAmbito') ) !!}  
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Parrocchia:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select('id_parrocchia', array('default' => 'Seleziona...')+Session::get('parrocchieCombo'), $news->id_parrocchia, array('id'=>'selezioneParrocchia') ) !!}  
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Stanza:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-4">
                {!! Form::text('luogo', $news->luogo, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('aaaa', 'Pubblica Vicariato:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-1">
                {!! Form::checkbox('pubblica_vicariato', true,$news->pubblica_vicariato) !!} 
            </div>
            <div class="col-md-9">
                Impostare il check per far apparire questa news in prima pagina del sito (solo se la news è di effettivo interesse vicariale!)
            </div>
        </div>

        @if ($gestisciPrimoPiano)
        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Pos. Primo Piano Vicariale:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('posizione_primo_piano', $news->posizione_primo_piano, ['class'=>'form-control']) !!}
            </div>
        </div>
        @endif

        @if ($gestisciPrimoPianoParrocchiaGruppo)
        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Pos. Primo Piano:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('posizione_primo_piano_parrocchia_gruppo', $news->posizione_primo_piano_parrocchia_gruppo, ['class'=>'form-control']) !!}
            </div>
        </div>
        @endif

        <div class="form-group">
            {!! Form::label(null, 'Solo Calendario:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-1">
                {!! Form::checkbox('solo_calendario', true,$news->solo_calendario) !!} 
            </div>
            <div class="col-md-9">
                Impostare il check nel caso in cui questa news debba apparire solamente nel calendario e non in lista
            </div>
        </div>


        @foreach($attachments as $attachment)
        <div class="col-md-1">
            <a href="{!! URL::to('cancellaAllegato', $attachment->id) !!}">{!! HTML::image("/img/trash.gif") !!}</a>
        </div>
        @if ($attachment->immagine)
        <div class="col-md-11">
            <img id="immagine" src="{!! $attachment->src !!} "/>
        </div>
        @else
        <div class="col-md-11">
            <a href="{!! URL::to('download', $attachment->id) !!}">{!! $attachment->nome !!}</a>
        </div>
        @endif
        @endforeach

        <div class="form-group">
            {!! Form::label('aaaa', 'Aggiungi Allegato:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-3">
                {!! Form::file('file3', array('class' => 'multi','name' => 'allegati[]' )) !!}
            </div>
            <div class="col-md-7">
                I file di tipo 'jpg', 'gif', 'png' saranno visualizzati come immagine, tutti gli altri come allegati
            </div>
        </div>

        @if (!empty($contenitoriUsers))
        <div style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Contenitore:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select('id_contenitore', array('default' => 'Seleziona...')+$contenitoriUsers, $news->id_contenitore, array('id'=>'selezioneContenitore') ) !!}  
            </div>
        </div>
        @endif

        <div class="text-center">
            {!! Form::submit('Salva', ['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>

<style>
    #ora_inizio  {
        width: 50px;
    }
    #minuti_inizio  {
        width: 50px;
    }
    #ora_fine  {
        width: 50px;
    }
    #minuti_fine  {
        width: 50px;
    }
    #immagine  {
        max-width: 100%;
    }
</style>

<script>
    $('.jqte-body').jqte({
        sub: false,
        sup: false,
        strike: false,
        remove: false,
        source: false
    });

    $(function () {
        $("#datepicker").datepicker({
            regional: 'it',
            defaultDate: new Date()
        });
    });

</script>





@stop