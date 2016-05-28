<div class="col-md-12">
    <table class="table table-striped table-condensed">
        <tbody>
            @foreach($newsPrimoPiano as $news)
            <tr>
                <td>
                    <a href="{!! URL::to('dettaglioNews', $news->id_task) !!}">{!! $news->title !!}</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
