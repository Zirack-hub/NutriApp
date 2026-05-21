<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('styles')
    <title>
        @yield('title')
    </title>
</head>
<body>
    <x-navegacion>
        <a href="{{ route('inicio') }}" class="nav-brand">INICIO</a>
        <div class="nav-spacer"></div>
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