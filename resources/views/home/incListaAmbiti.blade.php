<div class="col-md-12" id="divAmbiti">
    <table id="tabAmbiti">
        @foreach($ambiti as $ambito)
        <tr>
            <td><a href="{!! action('AmbitiController@mostraAmbito', $ambito->id) !!}">{!! $ambito->nome !!}</a></td>
        </tr>        
        @endforeach
    </table>
</div>

