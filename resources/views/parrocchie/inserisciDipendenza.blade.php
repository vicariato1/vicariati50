@extends('layout')
@section('contentHeader')
@include('layoutHeader')
@stop

@section('content')

{!! HTML::ul($errors->all(), array('class'=>'errors'))!!}
<div class="container">
    <div class="row">
        {!! Form::open(['url'=> 'effettuaInserimentoDipendenza', 'class' => 'form-horizontal', 'id' => 'myForm']) !!}
        {!! Form::hidden('id', $parrocchia->id)!!}

        <div class="form-group">
            {!! Form::label(null, 'Inserisci Dipendenza per '.$parrocchia->nome .':', ['class'=>'col-sm-5 control-label']) !!}
            <div class="col-md-7">
                {!! Form::select('id_parrocchia', array('default' => 'Seleziona...')+Session::get('parrocchieCombo'), null) !!}  
            </div>
        </div>

        <div class="form-group" style="margin-top:-10px;">
            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-md-10">
                {!! Form::submit('Inserisci Dipendenza', ['class'=>'btn btn-primary center-block']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>

@stop











