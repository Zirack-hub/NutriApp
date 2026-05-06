<link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
<nav>
    <a href="{{ route('inicio') }}" class="nav-brand">
        🥗 NutriApp
    </a>

    <div class="nav-spacer"></div>

    <div class="nav-dropdown">
        <a href="#" class="nav-link">
            Mis Dietas ▾
        </a>

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
</nav>