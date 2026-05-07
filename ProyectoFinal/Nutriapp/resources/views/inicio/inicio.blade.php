@extends('layouts.default')
@section('title', 'Inicio')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/inicio.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="dashboard">
        <h1 class="title">Panel de control</h1>
        <form action="{{ route('logout') }}" method="GET">
            <p class='welcome'>👋 Bienvenido, <strong>{{ Auth::user()->nombre }}</strong></p>
            <div class='grid'>
                @if (Auth::user()->tipo == 1 || Auth::user()->tipo == 2)
                    <x-card 
                        url="/usuarios" 
                        title="Gestión de usuarios" 
                        description="Gestionar usuarios del sistema" 
                    />
                @endif
                <x-card 
                    url="/dietas" 
                    title="Gestión de dietas" 
                    description="Crear y administrar dietas" 
                />
                <x-card 
                    url="/alimentos" 
                    title="Gestión de alimentos" 
                    description="Crear y administrar alimentos" 
                />
            </div>
            <button type='submit' name='logout' class='logout'>Cerrar sesión</button>"
        </form>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        localStorage.removeItem('secciones_activas');
        localStorage.removeItem('dieta_actual_id');
    </script>
@endsection