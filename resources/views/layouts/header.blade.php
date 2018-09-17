<html>
    <head>
        <title>Simulador Memória Cache</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/semantic.min.css') }}"/>
        <link href="{{ asset('img/favicon.ico') }}" rel="shortcut icon" type="image/vnd.microsoft.icon" />   
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/icon.min.css') }}"/>
        <script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/semantic.min.js') }}" ></script>
        <script type="text/javascript" src="{{ asset('js/script.js') }}" ></script>
    </head>
    <body>
        @yield('content')
    </body>
</html>