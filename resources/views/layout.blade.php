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
        @yield('contentHeader')
        @yield('content')
    </body>
    
<!-- <?php phpinfo();?> -->

</html>