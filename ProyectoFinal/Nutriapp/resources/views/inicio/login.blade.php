@extends('layouts.default')
@section('title', 'Login')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@endsection

@section('content')
<body class="body-login">
<div class="login-container">
    <div class="login-card">
        <h1 class="login-title">Iniciar Sesión</h1>
        <form method="POST" action="/login">
        @csrf
            <div class="input-group">
                        <label>Email</label>
                        <input type="text" name="email" class="input-field" required>
                    </div>

                    <div class="input-group">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="input-field" required>
                    </div>
                    <button type="submit" name="submit" class="btn-login">Entrar</button>
            <div>
        </form>
    </div>
</div>
@endsection