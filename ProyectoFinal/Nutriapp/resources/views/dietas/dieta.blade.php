@extends('layouts.dieta')
@section('title', $dieta->nombre)
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dietas.css') }}">
@endsection
@section('content')
<script src="{{ asset('assets/js/mantener_secciones.js') }}"></script>
<div class="container">
    <div class="dashboard">
        <h1 class="title">{{ $dieta->nombre }}</h1>
        <div class="botonera">
            <a href="{{ route('dietas.create') }}" class="btn">+ Nueva dieta</a>
        </div>
        <p class="objetivo">🎯 Objetivo calórico: {{ $dieta->objetivo }} kcal</p>
        @php
            $pctAlcanzado = round($porcentajeAlcanzado);
            $colorBarra = $pctAlcanzado > 105 ? 'danger' : ($pctAlcanzado >= 100 ? 'ok' : 'warning');
        @endphp
        <p class="objetivo">🔥 Porcentaje calórico alcanzado: {{ $pctAlcanzado }}%</p>
        <div class="progress-bar-container">
            <div class="progress-bar progress-bar--{{ $colorBarra }}" style="width: {{ min($pctAlcanzado, 100) }}%"></div>
        </div>
        <x-seccion tipo="desayuno" icono="🌅" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['desayuno'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="almuerzo" icono="🍎" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['almuerzo'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="comida"   icono="🍽️" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['comida'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="merienda" icono="🥪" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['merienda'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="cena"     icono="🌙" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['cena'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="suplementos" icono="💊" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['suplementos'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
    </div>
</div>
@endsection
@section('scripts')  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/mensaje_borrado.js') }}"></script>
@endsection