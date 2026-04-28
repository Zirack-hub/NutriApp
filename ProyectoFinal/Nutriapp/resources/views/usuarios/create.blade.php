@extends('layouts.default')

@section('title', 'Crear usuario')

@section('content')

<h1>Crear usuario</h1>

<form method="POST" action="/usuarios">
@csrf

<input name="nombre" placeholder="Nombre" required>
<input name="email" placeholder="Email" required>
<input name="password" type="password" placeholder="Contraseña" required>

<select name="tipo">

    @if(auth()->user()->tipo == 1)
        <option value="1">Admin</option>
        <option value="2">Profesor</option>
    @endif

    <option value="3">Alumno</option>

</select>

<button>Crear</button>

</form>

@endsection