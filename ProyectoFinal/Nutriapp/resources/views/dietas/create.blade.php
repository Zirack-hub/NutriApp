@extends('layouts.formulario')
@section('title', 'Crear dieta')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dietas.css') }}">
@endsection
@section('content')
<div class="container">
    <h1 class="title">Crear nueva dieta</h1>
    <form action="{{ route('dietas.store') }}" method="POST" class="dieta-form">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre de la dieta:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="objetivo">Objetivo calórico:</label>
            <input type="number" id="objetivo" name="objetivo" required>
        </div>
        <button type="submit" class="btn">Crear dieta</button>
    </form>
</div>
@endsection