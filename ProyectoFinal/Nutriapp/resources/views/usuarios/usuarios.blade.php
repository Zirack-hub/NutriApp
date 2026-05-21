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
                            <button class="btn btn-danger btn-small" onclick="confirmarBorrar({{ $usuario->id }}, '{{ $usuario->nombre }}')">
                                🗑️ Borrar
                            </button>
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

{{-- Modal de confirmación de borrado --}}
<div id="modal-borrar" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h3>⚠️ Confirmar eliminación</h3>
        <p>¿Estás seguro de que quieres eliminar al usuario <strong id="modal-nombre-usuario"></strong>?</p>
        <p style="font-size:0.85rem; color:#888;">Esta acción no se puede deshacer.</p>
        <div class="modal-botones">
            <button class="btn" onclick="cerrarModal()">Cancelar</button>
            <form id="form-borrar" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Sí, eliminar</button>
            </form>
        </div>
    </div>
</div>

<style>
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.5);
    display: flex; align-items: center; justify-content: center;
    z-index: 999;
}
.modal-box {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    max-width: 420px;
    width: 90%;
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    text-align: center;
}
.modal-box h3 { margin-bottom: 0.75rem; }
.modal-botones {
    display: flex; gap: 1rem;
    justify-content: center;
    margin-top: 1.5rem;
}
.btn-danger {
    background-color: #e53935;
    color: white;
    border: none;
    cursor: pointer;
}
.btn-danger:hover { background-color: #c62828; }
</style>

<script>
function confirmarBorrar(id, nombre) {
    document.getElementById('modal-nombre-usuario').textContent = nombre;
    document.getElementById('form-borrar').action = '/usuarios/' + id;
    document.getElementById('modal-borrar').style.display = 'flex';
}
function cerrarModal() {
    document.getElementById('modal-borrar').style.display = 'none';
}
// Cerrar modal si se hace click fuera
document.getElementById('modal-borrar').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
</script>
@endsection