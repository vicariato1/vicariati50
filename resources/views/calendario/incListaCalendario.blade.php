<link rel="stylesheet" href="{!! url('css/calendario.css') !!}">

<table class="col-md-12 table-condensed table-bordered" style="margin-top: -10px">
    <thead>
        <tr>
            <th class="col-md-1 text-left label label-default"><small>Data</small></th> 
            <th class="col-md-1 text-center label label-default"><small>Ora</small></th> 
            <th class="col-md-4 text-left label label-default"><small>News</small></th> 
            <th class="col-md-2 text-left label label-default"><small>Parrocchia</small></th> 
            <th class="col-md-2 text-left label label-default"><small>Sala</small></th> 
            <th class="col-md-2 text-left label label-default"><small>User</small></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach($newss as $news)

            @if($news->scriviRigaInizioSettimana)
            <?php $id = 'tdCalendarioBorder' ?>           
            @else
            <?php $id = 'tdCalendario' ?>           
            @endif

            @if($news->visualizzaData)
            @if($news->rowspan > 0)
            <td rowspan="{!! $news->rowspan !!}" id="{{$id}}" class="text-left coloreGiorno{!! $news->giorno_settimana !!}" >{!!date("j",strtotime($news->data_calendario)) !!} {!! DayWeekIT(date('w',strtotime($news->data_calendario))) !!}</td>            
            @else
            <td id="{{$id}}" class="text-left coloreGiorno{!! $news->giorno_settimana !!}" >{!!date("j",strtotime($news->data_calendario)) !!} {!! DayWeekIT(date('w',strtotime($news->data_calendario))) !!}</td>            
            @endif
            @endif
            <td id="{{$id}}" class="text-center" bgcolor="{!! $news->colore !!}">{!! $news->ora !!}</td>
            <td id="{{$id}}" class="text-left" bgcolor="{!! $news->colore !!}"><strong><a color="black" href="{!! URL::to('dettaglioNews', $news->id) !!}">{!! $news->title !!}</a></strong></td>            
            <td id="{{$id}}" class="text-left" bgcolor="{!! $news->colore !!}">{!! $news->nome_parrocchia !!}</td>            
            <td id="{{$id}}" class="text-left" bgcolor="{!! $news->colore !!}">{!! $news->luogo !!}</td>            
            <td id="{{$id}}" class="text-left" bgcolor="{!! $news->colore !!}">{!! $news->nome_user !!}</td>            
        </tr>
        @endforeach
    </tbody>
</table>

<style>
    a {color:#000000; /*new colour*/}
</style>


<?php

function DayWeekIT($numbrdayweek) {
    $days = array("Domenica", "Lunedì", "Martedì", "Mercoledì",
        "Giovedì", "Venerdì", "Sabato");
    $nameday = $days[$numbrdayweek];
    return $nameday;
}
?>




