<div class="col-md-12">
    @if ($newss->isEmpty())
    <p> Nessuna News presente!</p>
    @else
    <table class="table table-striped  table-condensed">
        <thead>
            <tr>
                @if (Session::get('utenteAutenticato'))
                <th class="col-md-3 text-center"><small>News</small></th> 
                @else
                <th class="col-md-4 text-center"><small>News</small></th> 
                @endif
                <th class="col-md-1 text-center"><small>Data</small></th> 
                <th class="col-md-2 text-center"><small>Ambito</small></th> 
                <th class="col-md-2 text-center"><small>Parrocchia</small></th> 
                <th class="col-md-2 text-center"><small>Pubblicata da</small></th>
                <th class="col-md-1 text-center"><small>Visite</small></th>
                @if (Session::get('utenteAutenticato'))
                <th class="col-md-1 text-center"></th> 
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($newss as $news)
            <tr>
                <td>
                    @if (Session::get('utenteAutenticato'))
                    <a href="{!! URL::to('dettaglioNewsModifica', $news->id_task) !!}">{!! $news->title !!}</a>
                    @else
                    <a href="{!! URL::to('dettaglioNewsLettura', $news->id_task) !!}">{!! $news->title !!}</a>
                    @endif
                </td>
                @if ($news->data_evento_da !== '--' and date("d/m/Y",strtotime($news->data_evento_da)) !== '01/01/1970')
                <td class="text-center">{!! date("d/m/Y",strtotime($news->data_evento_da)) !!}</td>
                @else
                <td class="text-center"></td>
                @endif
                <td>{!! $news->nome_ambito !!}</td>
                <td>{!! $news->nome_parrocchia !!}</td>
                <!--<td>{!! $news->nome_user !!} ({!!date("d/m/Y H:i",strtotime($news->created_at)) !!})</td>-->
                <td>{!! $news->nome_user !!}</td>
                <td class="text-center">{!! $news->count !!}</td>

                @if (Session::get('utenteAutenticato'))
                <td><a href="{!! URL::to('domandaDeleteNews', $news->id_task) !!}">{!! HTML::image("/img/trash.gif") !!}</a></td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="divPaginazione" class="text-center">
        {!! str_replace('/?', '?', $newss->render()) !!}
    </div>
    @endif

</div>

