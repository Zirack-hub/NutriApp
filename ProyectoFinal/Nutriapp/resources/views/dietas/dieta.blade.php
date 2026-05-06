@extends('layouts.dieta')
@section('title', $dieta->nombre)
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dietas.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="dashboard">
        <h1 class="title">{{ $dieta->nombre }}</h1>
        <p class="objetivo">🎯 Objetivo calórico: {{ $dieta->objetivo }} kcal</p>
        <div class="botonera">
            <a href="{{ route('dietas.create') }}" class="btn">+ Nueva dieta</a>
        </div>
        <x-seccion tipo="desayuno" icono="🌅" :alimentos="$alimentos_por_comida['desayuno'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="almuerzo" icono="🍎" :alimentos="$alimentos_por_comida['almuerzo'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="comida"   icono="🍽️" :alimentos="$alimentos_por_comida['comida'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="merienda" icono="🥪" :alimentos="$alimentos_por_comida['merienda'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="cena"     icono="🌙" :alimentos="$alimentos_por_comida['cena'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="suplementos" icono="💊" :alimentos="$alimentos_por_comida['suplementos'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
    </div>
</div>
@endsection
@section('scripts')
<script>
    function toggleSeccion(tipo) {
        const body = document.getElementById('seccion-' + tipo);
        if (body) {
            body.classList.toggle('abierto');
        }
    }
</script>
@endsection