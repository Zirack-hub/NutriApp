<link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
<nav>
    <a href="{{ route('inicio') }}" class="nav-brand">
        INICIO
    </a>
    <div class="nav-spacer"></div>
    <a href="{{ route('alimentos') }}" class="nav-link">
        🥦 Mis Alimentos
    </a>
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
    <div class="nav-user">
    <div class="nav-avatar"></div>
    <span class="nav-username">{{ Auth::user()->nombre }}</span>
    <x-logout/>
</div>
</nav>