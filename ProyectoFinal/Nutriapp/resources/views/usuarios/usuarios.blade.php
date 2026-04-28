@extends('layouts.default')

@section('title', 'Usuarios')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/usuarios.css') }}">
@endsection
@section('content')

<h1>Gestión de usuarios</h1>

<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Tipo</th>
        <th>Alimentos</th>
        <th>Dietas</th>
        <th>Contraseña</th>
    </tr>

    @foreach($usuarios as $usuario)
    <tr>
        <td>{{ $usuario->nombre }}</td>
        <td>{{ $usuario->email }}</td>
        <td>{{ $usuario->tipo }}</td>

        <td><a href="/alimentos/{{ $usuario->id }}">Ver</a></td>
        <td><a href="/dietas/{{ $usuario->id }}">Ver</a></td>

        <td>
            @if(auth()->user()->tipo == 1)
                <form method="POST" action="{{ route('usuarios.cambiar-password', $usuario->id) }}">
                    @csrf
                
                    <input type="password" name="password" placeholder="Nueva contraseña" required>
                
                    <button>Cambiar</button>
                </form>
            @else
                ---
            @endif
        </td>
    </tr>
    @endforeach

</table>

@if(auth()->user()->tipo != 3)
    <a href="/usuarios/create">Crear usuario</a>
@endif
<a href="{{ route('inicio') }}">
    <button type="button">
        🏠 Volver al inicio
    </button>
</a>
@endsection