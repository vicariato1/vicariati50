@if (empty($newsPrimoPiano))
@else
<p class="col-md-12 text-center label label-primoPiano">Primo Piano</p>
<table class="col-md-12 table-striped table-bordered" style="margin-top: -10px">
    <thead>
        <tr>
            @if (Session::get('utenteAutenticato'))
            <th class="col-md-3 text-center label label-default"><small>News</small></th> 
            @else
            <th class="col-md-4 text-center label label-default"><small>News</small></th> 
            @endif
            <th class="col-md-1 text-center label label-default"><small>Data</small></th> 
            <th class="col-md-2 text-center label label-default"><small>Ambito</small></th> 
            <th class="col-md-2 text-center label label-default"><small>Parrocchia</small></th> 
            <th class="col-md-2 text-center label label-default"><small>Pubblicata da</small></th>
            <th class="col-md-1 text-center label label-default"><small>Visite</small></th>
            @if (Session::get('utenteAutenticato'))
            <th class="col-md-1 text-center label label-default"> </th> 
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($newsPrimoPiano as $news)
        <tr>
            <td id="tdlista">
                <strong><a href="{!! URL::to('dettaglioNews', $news->id_task) !!}">{!! $news->title !!}</a></strong>
            </td>
            @if ($news->data_evento_da !== '--' and date("d/m/Y",strtotime($news->data_evento_da)) !== '01/01/1970')
            <td id="tdlista" class="text-center">{!! DayWeekIT(date('w',strtotime($news->data_evento_da))) !!} {!!date("d/m/y",strtotime($news->data_evento_da)) !!}</td>            
            @else
            <td id="tdlista" class="text-center"></td>
            @endif
            <td id="tdlista">{!! $news->nome_ambito !!}</td>
            <td id="tdlista">{!! $news->nome_parrocchia !!}</td>
            <td id="tdlista">{!! $news->nome_user !!}</td>
            <td id="tdlista" class="text-center">{!! $news->count !!}</td>
            @if (Session::get('utenteAutenticato') and (Session::get('user')->id == $news->id_user or Session::get('user')->admin == 1))
            <td id="tdlista"><a href="{!! URL::to('domandaDeleteNews', $news->id_task) !!}">{!! HTML::image("/img/trash.gif") !!}</a></td>
            @else
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<?php
function DayWeekIT($numbrdayweek) {
    $days = array("Dom.", "Lun.", "Mar.", "Mer.",
        "Gio.", "Ven.", "Sab.");
    $nameday = $days[$numbrdayweek];
    return $nameday;
}
?>
