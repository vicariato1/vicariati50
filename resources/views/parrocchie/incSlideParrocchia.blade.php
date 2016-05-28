<div id="dialogParrocchia" class="col-md-12">
    <ul class="bjqs">
        @foreach($immaginiShow as $immagine)
        <li>{!! HTML::image( 'parrocchie/' .$immagine->id_parrocchia .'/' . $immagine->nome_file, null , array('title' => $immagine->didascalia)) !!}</li>
        @endforeach
     </ul>
</div>


<style>
    img1{
    position: relative;
    margin: auto;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}
</style>




<script>
    $(function () {
        $('#dialogParrocchia').bjqs({
            showmarkers: false,
            responsive: true,
            animduration: 2000, // how fast the animation are
            animspeed: 4000, // the delay between each slide
            width: 280,
            height: 280,
            automatic: true,
            showcontrols: false,
            usecaptions: true,
            randomstart: true
        });
    });
</script>

