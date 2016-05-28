<header>
    <div id="divLogo" class="container-fluid" style="background-image:url('{{ asset('img/sfondoVicariatiArcella.png') }}')">
        <div style="float: left; width: 10%; margin-bottom: -10px" >
            @if (Session::get('tipoVicariatoUP') == 'V' or Session::get('tipoVicariatoUP') == 'P')
            {!!  HTML::image("img/vicariato.gif")  !!}
            @elseif (Session::get('tipoVicariatoUP') == 'UP1')
            {!!  HTML::image("img/up1.gif")  !!}
            @elseif (Session::get('tipoVicariatoUP') == 'UP2')
            {!!  HTML::image("img/up2.gif")  !!}
            @elseif (Session::get('tipoVicariatoUP') == 'UP3')
            {!!  HTML::image("img/up3.gif")  !!}
            @endif
        </div> 
        <div  style="float: left; width: 40%; margin-top: -8px; margin-bottom: -10px" id="divVicariato">
            <hgroup>
                @if (Session::get('tipoVicariatoUP') == 'V'  or Session::get('tipoVicariatoUP') == 'P')
                <h1><b><font color="white">{!! Session::get('titolo_generale') !!}</font></b></h1>
                <h4 style="float: right; margin-top: -0px;"><i><font color="white">{!! Session::get('sottotitolo') !!}</font></i></h4>
                @endif
                @if (Session::get('tipoVicariatoUP') == 'UP1')
                <h1><b><font color="white">Unità Pastorale Arcella</font></b></h1>
                <h4 style="float: right; margin-top: -0px;"><i><font color="white">Alla ricerca di perle preziose...</font></i></h4>
                @endif
            </hgroup>
        </div> 
        <div style="float: right; margin-top: 22px;">
            {!! Form::open(['url'=> 'cerca', 'class' => 'form-horizontal', 'id' => 'myForm']) !!}
            {!! Form::text('stringaRicerca', Session::get('stringaRicercaNews'), array('placeholder' => 'Cerca', 'style' => 'border-radius: 5px;')) !!}
            {!! Form::image('/img/cerca.gif', 'btnSub', ['class' => 'btn']) !!}                    
            {!! Form::close() !!}
        </div>
    </div>
    <nav class="navbar navbar-default" >
        <div id='cssmenu'>
            <ul>
                @if (Session::get('tipoVicariatoUP') == 'V' or Session::get('tipoVicariatoUP') == 'P')
                <li><a href="{!! URL::to('home') !!}">Home</a></li>
                @elseif (Session::get('tipoVicariatoUP') == 'UP1')
                <li><a href="{!! URL::to('up1') !!}">Home</a></li>
                <li><a href="{!! URL::to('home') !!}">Vicariato</a></li>
                @elseif (Session::get('tipoVicariatoUP') == 'UP2')
                <li><a href="{!! URL::to('up2') !!}">Home</a></li>
                <li><a href="{!! URL::to('home') !!}">Vicariato</a></li>
                @elseif (Session::get('tipoVicariatoUP') == 'UP3')
                <li><a href="{!! URL::to('up3') !!}">Home</a></li>
                <li><a href="{!! URL::to('home') !!}">Vicariato</a></li>
                @endif

                <li><a href="{!! URL::to('orari_lista') !!}">Orari Messe</a></li>
                <li><a href="{!! URL::to('calendarioGeneraleLista') !!}">Calendario</a></li>

                @if (Session::get('utenteAutenticato'))
                <li><a href="{!! URL::to('createNews') !!}">Nuova News</a></li>
                @endif

                @if (Session::get('tipoVicariatoUP') == 'V' or Session::get('tipoVicariatoUP') == 'P')
                <li><a href="{!! URL::to('contattaMain') !!}">Contatti</a></li>
                @else
                <li><a href="{!! URL::to('contattaParrocchia') !!}">Contatti</a></li>
                @endif

                <li><a href="{!! URL::to('listaLink', 1) !!}">Link</a></li>

                @if (!Session::get('utenteAutenticato'))
                <li><a href="{!! URL::to('login') !!}">Login</a></li>
                @else
                <li><a href="{!! URL::to('uscita') !!}">Esci</a></li>
                @endif
                <!--<li><a href="{!! URL::to('daFare') !!}">Da fare</a></li>-->
            </ul>
        </div>
        @if (Session::get('utenteAutenticato'))
        <div class="utenteAutenticato">Utente Autenticato: {!! Session::get('user')->nome !!}</div>
        <style> 
            div.utenteAutenticato {
                font-size:18px;
                color: #000000 !important;
                text-align: right;
                font-weight: 900;
                margin-right: 10px;
                padding: 10px 0px 20px 0px;
            }
        </style>
        @endif
    </nav>
    @if (Session::get('utenteAutenticato') and Session::get('user')->admin == 1)
    <nav class="navbar navbar-default" style="margin-top: -20px;">
        <ul class="nav navbar-nav navbar-left">
            <li><a href="{!! URL::to('listaParrocchie') !!}">Parrocchie</a></li>
            <li><a href="{!! URL::to('listaAmbiti') !!}">Gruppi</a></li>
            <li><a href="{!! URL::to('listaUtenti') !!}">Utenti</a></li>
            <li><a href="{!! URL::to('listaContenitori') !!}">Contenitori</a></li>
            <li><a href="{!! URL::to('listaParrocchieUtenti') !!}">Parrocchie/Utenti</a></li>
            <li><a href="{!! URL::to('listaAmbitiUtenti') !!}">Gruppi/Utenti</a></li>
            <li><a href="{!! URL::to('listaContenitoriUtenti') !!}">Contenitori/Utenti</a></li>
            <li><a href="{!! URL::to('visualizzaDatiGenerali') !!}">Dati Generali</a></li>
            <li><a href="{!! URL::to('listaLinkGestione', 1) !!}">Link</a></li>
        </ul>
    </nav>
    @endif
</header>