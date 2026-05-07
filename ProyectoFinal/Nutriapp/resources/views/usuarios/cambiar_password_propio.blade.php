@extends('layouts.formulario')
@section('title', 'Cambiar contraseña')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/usuarios.css') }}">
@endsection
@section('content')
<div class="container">
    <h2>🔒 Cambia tu contraseña</h2>
    <div class="card">
        <p style="margin-bottom:1.2rem; color:#555;">
            Es tu primer acceso. Por seguridad, debes establecer una contraseña personal antes de continuar.
        </p>

        @if($errors->any())
            <div style="color:#e53935; margin-bottom:1rem;">
                @foreach($errors->all() as $error)
                    <p>⚠️ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('usuarios.cambiar-password-propio.store') }}" class="form-container">
            @csrf
            <div class="form-group">
                <label>Nueva contraseña</label>
                <input type="password" name="password" placeholder="Mínimo 6 caracteres" required>
            </div>
            <div class="form-group">
                <label>Confirmar contraseña</label>
                <input type="password" name="password_confirmation" placeholder="Repite la contraseña" required>
            </div>
            <button type="submit" class="btn">✅ Guardar contraseña</button>
        </form>
    </div>
</div>
@endsection
