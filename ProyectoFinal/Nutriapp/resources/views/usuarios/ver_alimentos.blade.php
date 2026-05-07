@extends('layouts.formulario')
@section('title', 'Alimentos de ' . $usuario->nombre)
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/usuarios.css') }}">
@endsection
@section('content')
<div class="container">
    <h2>🥗 Alimentos de {{ $usuario->nombre }}</h2>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Alimento</th>
                    <th>Energía (kcal/100g)</th>
                    <th>Proteínas</th>
                    <th>Grasas</th>
                    <th>H. Carbono</th>
                    <th>Fibra</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alimentos as $alimento)
                    <tr>
                        <td>{{ $alimento->alimento }}</td>
                        <td>{{ $alimento->e_100 }}</td>
                        <td>{{ $alimento->prot_100 }}</td>
                        <td>{{ $alimento->grasa_100 }}</td>
                        <td>{{ $alimento->hc_100 }}</td>
                        <td>{{ $alimento->fibra_100 }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Este usuario no tiene alimentos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="botonera-acciones">
        <a href="{{ route('usuarios') }}" class="btn">⬅️ Volver a usuarios</a>
    </div>
</div>
@endsection
