@extends('layouts.formulario')
@section('title', 'Crear usuario')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/usuarios.css') }}">
@endsection
@section('content')
<div class="container">
    <h2>Crear nuevo usuario</h2>
    <div class="card">
        <form method="POST" action="{{ route('usuarios.store') }}" class="form-container">
            @csrf
            <div class="form-group">
                <label>Nombre</label>
                <input name="nombre" placeholder="Nombre completo" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" placeholder="correo@ejemplo.com" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input name="password" type="password" placeholder="Mínimo 6 caracteres" required>
            </div>
            <div class="form-group">
                <label>Tipo de usuario</label>
                <select name="tipo">
                    @if(auth()->user()->tipo == 1)
                        <option value="1">Admin</option>
                        <option value="2">Profesor</option>
                    @endif
                    <option value="3">Alumno</option>
                </select>
            </div>
            <button type="submit" class="btn">+ Crear Usuario</button>
        </form>
    </div>
    <div class="botonera-acciones">
        <a href="/usuarios" class="btn">⬅ Volver al listado</a>
    </div>
</div>
@endsection