<div class="col-md-12" id="divParrocchie">
    <table id="tabParrocchie">
        @foreach($parrocchie as $parrocchia)
        <tr>
            <td><a href="{!! action('ParrocchieController@mostraParrocchia', $parrocchia->id) !!}">{!! $parrocchia->nome !!}</a></td>
        </tr>        
        @endforeach
    </table>
</div>
