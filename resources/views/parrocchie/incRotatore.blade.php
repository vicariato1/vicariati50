<div class="col-md-12">
    <!-- // Prelevato ed illustrato su http://www.web-link.it -->
    <marquee behavior="scroll" 
             direction="up" 
             scrollamount="1" 
             scrolldelay="1" 
             onmouseover="this.stop()" 
             onmouseout="this.start()" 
             style="background:#ffffff;" 
             height="200px"
             width="100%">
        @foreach($newsScroll as $news)
        <p> {!! date("d/m/Y",strtotime($news->data_evento_da)) !!} 
            <a href="{!! URL::to('dettaglioNews', $news->id_task) !!}">{!! $news->title !!}</a>
        </p>
        @endforeach
    </marquee>    
</div>
