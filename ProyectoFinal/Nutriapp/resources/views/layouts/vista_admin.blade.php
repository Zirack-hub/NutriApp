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
    <x-navegacion>
        <a href="{{ route('usuarios') }}" class="nav-brand">GESTIONAR USUARIOS</a>
    </x-navegacion>
    @yield('content')
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/cerrar_sesion.js') }}"></script>
</body>
</html>