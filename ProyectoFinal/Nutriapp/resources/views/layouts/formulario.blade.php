<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/mensajes.css') }}">
    @yield('styles')
    <title>
        @yield('title')
    </title>
</head>
<body>
    @include('partials.navbar3')
    @include('partials.mensajes')
    @yield('content')
    @yield('scripts')
</body>
</html>