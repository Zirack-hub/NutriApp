<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/campana.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mensajes.css') }}">
    @yield('styles')
    <title>
        @yield('title')
    </title>
</head>
<body>
    @include('partials.mensajes')
    <x-navegacion>
        <a href="{{ route('inicio') }}" class="nav-brand">INICIO</a>
        <div class="nav-spacer"></div>
        <a href="{{ route('alumno.comentarios') }}" class="nav-link" style="display: inline-flex; align-items: center; gap: 5px;">
        COMENTARIOS
        @if(isset($comentariosNuevos) && $comentariosNuevos > 0)
            <span class="nav-bell-container">
                <span class="nav-bell-icon">🔔</span>
                <span class="nav-bell-badge">{{ $comentariosNuevos }}</span>
            </span>
        @endif
        </a>
        <a href="{{ route('alimentos') }}" class="nav-link">ALIMENTOS</a>
        <div class="nav-dropdown">
            <a href="#" class="nav-link">DIETAS ▾</a>
            <div class="dropdown-menu">
                @forelse($dietas as $dieta)
                    <a href="{{ route('dietas.show', $dieta->id) }}" class="dropdown-item">
                        {{ $dieta->nombre }}
                    </a>
                @empty
                    <span class="dropdown-empty">No hay dietas creadas</span>
                @endforelse
            </div>
        </div>
    </x-navegacion>
    @yield('content')
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/cerrar_sesion.js') }}"></script>
</body>
</html>