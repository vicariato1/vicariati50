<div class="col-md-12" style="margin-top: 10px;">

    @if ($utenteAutorizzatoPubblicazioneBollettini)
    <a href="{!! URL::to('insertBollettino') !!}">Inserisci Bollettino</a>
    @endif

    @if ($bollettini->isEmpty())
    <p> Nessun Bollettino presente!</p>
    @else
    <table class="table table-striped table-condensed">
        <tbody>
            @foreach($bollettini as $bollettino)
            <tr>
                <td id="tdBollettini" >
                    <a href="{!! URL::to('downloadBol', $bollettino->id  ) !!}">{!! $bollettino->nome_parrocchia !!} </a>
                </td>
                @if ($bollettino->created_at !== '--' and date("d/m/Y",strtotime($bollettino->created_at)) !== '01/01/1970')
                <td id="tdBollettini" class="text-center" title="{!! $bollettino->count !!} download"><small>{!! date("d/m/y",strtotime($bollettino->created_at)) !!}</small></td>
                @else
                <td id="tdBollettini" class="text-center"></td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <div id="divPaginazione" class="text-center" >
        {!! str_replace('/?', '?', $bollettini->render()) !!}
    </div>
    @endif

</div>

