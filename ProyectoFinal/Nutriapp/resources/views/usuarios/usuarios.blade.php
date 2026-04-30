@extends('layouts.formulario')
@section('title', 'Usuarios')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/usuarios.css') }}">
@endsection
@section('content')
<div class="container">
    <h2>Gestión de usuarios</h2>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Alimentos</th>
                    <th>Dietas</th>
                    <th>Contraseña</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->tipo }}</td>
                    <td><a href="/alimentos/{{ $usuario->id }}">Ver</a></td>
                    <td><a href="/dietas/{{ $usuario->id }}">Ver</a></td>
                    <td>
                        @if(auth()->user()->tipo == 1)
                            <form method="POST" action="{{ route('usuarios.cambiar-password', $usuario->id) }}" class="form-tabla">
                                @csrf
                                <input type="password" name="password" placeholder="Nueva..." required>
                                <button class="btn btn-small">Cambiar</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="botonera-acciones">
        @if(auth()->user()->tipo != 3)
            <a href="/usuarios/create" class="btn">➕ Crear nuevo usuario</a>
        @endif
        <a href="{{ route('inicio') }}" class="btn">
            🏠 Volver al inicio
        </a>
    </div>
</div>
@endsection