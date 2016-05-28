<div class="col-md-12">

    @if ($utenteAbilitatoParrocchia)
    <p><a href="{!! URL::to('insertBollettino') !!}">Inserisci Bollettino</a></p>
    @endif

    @if ($bollettini->isEmpty())
    <p> Nessun Bollettino presente!</p>
    @else
    <table class="table table-striped table-condensed">
        <tbody>
            @foreach($bollettini as $bollettino)
            <tr>
                <td><a href="{!! URL::to('downloadBol', $bollettino->id  ) !!}">{!! $bollettino->title !!}</a></td>
                @if ($bollettino->created_at !== '--' and date("d/m/Y",strtotime($bollettino->created_at)) !== '01/01/1970')
                <td class="text-center" title="{!! $bollettino->count !!} download">{!! date("d/m/y",strtotime($bollettino->created_at)) !!} </td>
                @else
                <td class="text-center"></td>
                @endif
                @if ($utenteAbilitatoParrocchia)
                <td><a href="{!! URL::to('domandaDeleteBollettino', $bollettino->id) !!}" >{!! HTML::image("/img/trash.gif") !!}</a></td>
                @else
                <td class="text-center"></td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="divPaginazione" class="text-center">
        {!! str_replace('/?', '?', $bollettini->render()) !!}
    </div>
    @endif

</div>


 