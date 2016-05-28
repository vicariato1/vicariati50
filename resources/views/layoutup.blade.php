<!doctype html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title></title>

        <script src="{!! url('js/jquery-1.11.1.min.js') !!}"></script>
        <script src="{!! url('js/bootstrap.min.js') !!}"></script>
        <script src="{!! url('js/jquery-ui.min.js') !!}"></script>
        <script src="{!! url('js/datepicker-it.js') !!}"></script>
        <script src="{!! url('js/jquery-te-1.4.0.min.js') !!}"></script>
        <script src="{!! url('js/jquery.MultiFile.js') !!}"></script>
        <script src="{!! url('js/bjqs-1.3.min.js') !!}"></script>
        <script src="{!! url('js/scriptMenu.js') !!}"></script>

        <link rel="stylesheet" href="{!! url('css/jquery-te-1.4.0.css') !!}">
        <link rel="stylesheet" href="{!! url('css/bootstrap.min.css') !!}">
        <link rel="stylesheet" href="{!! url('css/custom.bootstrap.css') !!}">
        <link rel="stylesheet" href="{!! url('css/jquery-ui.css') !!}">
        <link rel="stylesheet" href="{!! url('css/style.css') !!}">
        <link rel="stylesheet" href="{!! url('css/bjqs.css') !!}">
        <link rel="stylesheet" href="{!! url('css/stylesMenu.css') !!}">

 
    </head>

    <body>
        <header>
            <div id="divLogo" class="container-fluid" style="background-image:url('{{ asset('img/sfondoVicariatiArcella.png') }}')">
                <div style="float: left; width: 10%; margin-bottom: -10px" >
                    {!!  HTML::image("img/logoup.jpg")  !!}
                </div> 
                <div  style="float: left; width: 40%; margin-top: -8px; margin-bottom: -10px" id="divVicariato">
                    <hgroup>
                        <h1><b><font color="white">Unità Pastorale Arcella</font></b></h1>
                        <h4 style="float: right; margin-top: -0px;"><i><font color="white">San Bellino - San Filippo Neri - Ss.ma Trinità</font></i></h4>
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
                        <li><a href="{!! URL::to('uparcella') !!}">Home</a></li>
                        <li><a href="{!! URL::to('home') !!}">Vicariato</a></li>
                        <li><a href="{!! URL::to('orari_lista_uparcella') !!}">Orari Messe</a></li>
                        <li><a href="{!! URL::to('calendarioUpGeneraleLista') !!}">Calendario</a></li>
                        @if (Session::get('utenteAutenticato'))
                        <li><a href="{!! URL::to('createNewsUP') !!}">Nuova News</a></li>
                        @endif
                        <li><a href="{!! URL::to('contattaMainUP') !!}">Contatti</a></li>
                        @if (!Session::get('utenteAutenticato'))
                        <li><a href="{!! URL::to('loginUP') !!}">Login</a></li>
                        @else
                        <li><a href="{!! URL::to('uscitaUP') !!}">Esci</a></li>
                        @endif
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
                </ul>
            </nav>
            @endif
        </header>
        @yield('content')

 
    </body>
</html>



