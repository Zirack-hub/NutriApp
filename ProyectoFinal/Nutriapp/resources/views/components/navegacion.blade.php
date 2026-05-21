<link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
<nav>
    {{ $slot }}
    <div class="nav-user">
        <div class="nav-avatar"></div>
        <span class="nav-username">{{ Auth::user()->nombre }}</span>
        <button type="button" class="nav-logout" onclick="confirmarLogout(event)">Cerrar sesión</button>
        <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display:none;"></form>
    </div>
</nav>