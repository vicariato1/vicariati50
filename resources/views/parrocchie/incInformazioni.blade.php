
<div class="col-md-12">
    <div class="col-md-12">
        @if ($utenteAbilitatoParrocchia)
        {!! Form::open(['url'=> 'saveCorpoParrocchia', 'class' => 'form-horizontal']) !!}
        {!! Form::hidden('id', $parrocchia->id)!!}
        {!! Form::textarea('body', $parrocchia->body, array('id'=>'body','class'=>'jqte-body')) !!}
        {!! Form::submit('Salva', ['class' => 'btn btn-primary']) !!}
        @else
        {!! $parrocchia->body !!}
        @endif
    </div>

</div>

<script>
    $('.jqte-body').jqte({
        sub: false,
        sup: false,
        strike: false,
        remove: false,
        source: false
    });
    $('.jqte-body-lettura').jqte({
        b: false,
        i: false,
        indent: false,
        link: false,
        left: false,
        ol: false,
        fsize: false,
        format: false,
        color: false,
        sub: false,
        outdent: false,
        center: false,
        remove: false,
        right: false,
        rule: false,
        u: false,
        ul: false,
        unlink: false,
        sup: false,
        strike: false,
        source: false
    });

    $('.jqte-body-lettura').parents(".jqte").find(".jqte_toolbar").hide();
    $('.jqte-body-lettura').parents(".jqte").css('min-height', '250px');
    $('.jqte-body-lettura').parents(".jqte").css('overflow-y', 'auto');

</script>

