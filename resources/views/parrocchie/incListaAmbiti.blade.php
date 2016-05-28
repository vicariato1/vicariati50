<div class="col-md-12" >
    @foreach($ambiti as $ambito)
    <p class="medium" style="line-height: 80%"><strong>
        <a href="{!! action('AmbitiController@mostraAmbito', $ambito->id) !!}">
            {!! $ambito->nome !!}</a>
    </p>
    @endforeach
</div>

<!--style="overflow-y: scroll; height:300px;"-->
