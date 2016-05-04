<html>
    <head>
        <meta name="csrf_token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

        <title>Auto Reviews - @yield('title')</title>

        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">

        <script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.0.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/admin.css') }}">
        <script type="text/javascript" src="{{ URL::asset('js/admin.js') }}"></script>

    </head>
    <body>
        @section('navbar')
            <!-- Top nav goes here -->
        @show

        @yield('content')

    </body>
</html>