@extends('layouts.formulario')
@section('title', 'Usuarios')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/usuarios.css') }}">
@endsection
@section('content')
<div class="container">
    <h2>Gestión de usuarios</h2>
    <div class="botonera-acciones">
        @if(auth()->user()->tipo != 3)
            <a href="/usuarios/create" class="btn">➕ Crear nuevo usuario</a>
        @endif
    </div>
    <br>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Dietas</th>
                    <th>Alimentos</th>
                    <th>Contraseña</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td>
                        {{ $usuario->nombre }}
                    </td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->tipoRelacion->nombre ?? $usuario->tipo }}</td>
                    <td>
                        @if(auth()->user()->tipo != 3)
                            <a href="{{ route('usuarios.dietas', $usuario->id) }}">Ver</a>
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->tipo != 3)
                            <a href="{{ route('usuarios.alimentos', $usuario->id) }}">Ver</a>
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->tipo == 1)
                            <form method="POST" action="{{ route('usuarios.cambiar-password', $usuario->id) }}" class="form-tabla">
                                @csrf
                                <input type="password" name="password" placeholder="Nueva..." required>
                                <button class="btn btn-small">Cambiar</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->tipo == 1 && auth()->id() !== $usuario->id)
                            <form method="POST" action="{{ route('usuarios.destroy', $usuario->id) }}" style="display:inline;" class="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger btn-small" 
                                        data-nombre="{{ $usuario->nombre }}" 
                                        data-tipo="usuario">
                                    🗑️ Borrar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/mensaje_borrado.js') }}"></script>
@endsection