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
                        title="Usuarios" 
                        description="Gestionar usuarios del sistema" 
                    />
                @endif
                <x-card 
                    url="/alimentos" 
                    title="Base de datos" 
                    description="Explorar información almacenada" 
                />
            </div>
            <button type='submit' name='logout' class='logout'>Cerrar sesión</button>"
        </form>
    </div>
</div>
@endsection