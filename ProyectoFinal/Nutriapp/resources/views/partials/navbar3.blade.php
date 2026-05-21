<link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
<nav>
    <div class="nav-user">
    <div class="nav-avatar"></div>
    <span class="nav-username">{{ Auth::user()->nombre }}</span>
    <x-logout/>
</div>
</nav>