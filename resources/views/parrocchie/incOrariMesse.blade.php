<div class="col-md-12">
    <div class="col-md-12" >
        
        @if ($utenteAbilitatoModificaOrari)
        <a href="{!! URL::to('orari_dettaglio',$parrocchia->id) !!}">Modifica Orari</a>
        @endif

        <p>{!! $parrocchia->orari !!}<p>
        
    </div>
</div>
