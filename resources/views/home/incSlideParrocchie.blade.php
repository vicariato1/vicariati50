<div id="dialog">
    <ul class="bjqs pull-right" >
        @foreach($parrocchieSlide as $parrocchia)
        <li   onclick="location.href ='{!! action('ParrocchieController@mostraParrocchia', $parrocchia->id) !!}';">
            {!! HTML::image( 'chiese/' . $parrocchia->nome_file_immagine, null , array('title' => $parrocchia->nome, 'id' => 'img1')) !!}
            <!--{!! HTML::image( URL::to('getImmagine', $parrocchia->nome_file_immagine), null, array('title' => $parrocchia->nome, 'id' => 'img1')) !!}-->
        </li>
        @endforeach
    </ul>
</div>

<!--<style>
    #img1{
        position: relative;
        margin: auto;
        right: 0;
    }

    li { cursor: pointer; }
</style>-->

<script>
    $(function () {
        $('#dialog').bjqs({
            showmarkers: false,
            responsive: true,
            animduration: 2000, // how fast the animation are
            animspeed: 4000, // the delay between each slide
            width: 300,
            height: 300,
            automatic: true,
            showcontrols: false,
            usecaptions: true,
            randomstart: true
        });
    });
</script>

