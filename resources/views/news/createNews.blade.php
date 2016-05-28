@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
<div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'saveCreateNews', 'class' => 'form-horizontal', 'id' => 'myForm','files'=>true]) !!}

        <div class="form-group">
            {!! Form::label('title', 'Titolo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::text('title', Input::old('title'), ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('body', 'Corpo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::textarea('body', Input::old('body'), array('id'=>'body','class'=>'jqte-body')) !!}
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Data Da:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-2">
                {!! Form::text('data_evento_da', '', array('id' => 'datepicker','placeholder' => 'Data Evento' )) !!}
            </div>
            <div class="form-inline col-md-8">
                {!! Form::label(null, 'Ora Inizio:', ['class'=>'control-label']) !!}
                {!! Form::select('ora_inizio', $ore) !!}  
                {!! Form::select('minuti_inizio', $minuti) !!}  
                {!! Form::label(null, '                                    ', ['class'=>'control-label']) !!}
                {!! Form::label(null, 'Ora Fine:', ['class'=>'control-label']) !!}
                {!! Form::select('ora_fine', $ore) !!}  
                {!! Form::select('minuti_fine', $minuti) !!}  
            </div>
        </div>


        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Gruppo:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select('id_ambito', array('default' => 'Seleziona...')+$ambitiCombo, $ambitoSelezionato, array('id'=>'$parametroselezioneAmbito') ) !!}  
            </div>
        </div>


        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Parrocchia:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select('id_parrocchia', array('default' => 'Seleziona...')+Session::get('parrocchieCombo'), null, array('id'=>'selezioneParrocchia') ) !!}  
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Luogo/Stanza:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('luogo', Input::old('luogo'), ['class'=>'form-control']) !!}
            </div>
            <div class="col-sm-7">
                Valorizzare questo campo solo se è necessario specificare dove si svolge l'evento (Es. Stanza 4)
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Pubblica Vicariato:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-1">
                @if (Session::get('tipoVicariatoUP') == 'V')
                {!! Form::checkbox('pubblica_vicariato', true, true) !!} 
                @else
                {!! Form::checkbox('pubblica_vicariato', true, false) !!} 
                @endif
            </div>
            <div class="col-md-9">
                Impostare il check per far apparire questa news in prima pagina del sito (solo se la news è di effettivo interesse vicariale!)
            </div>
         </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label(null, 'Solo Calendario:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-1">
                {!! Form::checkbox('solo_calendario', true, false) !!} 
            </div>
            <div class="col-md-9">
                Impostare il check nel caso in cui questa news debba apparire solamente nel calendario e non in lista
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Aggiungi Allegato:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-3">
                {!! Form::file('allegati[]', array('class' => 'multi','name' => 'allegati[]' )) !!}
            </div>
            <div class="col-md-7">
                I file di tipo 'jpg', 'gif', 'png' saranno visualizzati come immagine, tutti gli altri come allegati
            </div>
        </div>

        @if (!empty($contenitoriUsers))
        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('aaaa', 'Contenitore:', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::select('id_contenitore', array('default' => 'Seleziona...')+$contenitoriUsers, 'default', array('id'=>'selezioneContenitore') ) !!}  
            </div>
        </div>
        @endif

        <div class="text-center">
            {!! Form::submit('Salva', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}



    </div>

    <style>
        #ora_inizio  {
            width: 20px;
        }
        #minuti_inizio  {
            width: 20px;
        }
        #ora_fine  {
            width: 20px;
        }
        #minuti_fine  {
            width: 20px;
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
        $('.jqte-body').parents(".jqte").css('max-height', '300px');
        $('.jqte-body').parents(".jqte").css('overflow-y', 'auto');
        $(function () {
            $("#datepicker").datepicker({
                regional: 'it',
                defaultDate: new Date()
            });
        });

    </script>

    @stop







