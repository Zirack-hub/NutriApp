@extends('layouts.formulario')
@section('title', 'Dietas de ' . $usuario->nombre)
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/usuarios.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dietas.css') }}">
@endsection
@section('content')
<div class="container">
    <h2>📋 Dietas de {{ $usuario->nombre }}</h2>

    {{-- Selector de dieta si tiene varias --}}
    @if($dietas->count() > 1)
    <div class="card" style="margin-bottom: 1rem;">
        <form method="GET" action="{{ route('usuarios.dietas', $usuario->id) }}" style="display:flex; gap:1rem; align-items:center; justify-content:center;">
            <label style="font-weight:600; color:#4e6b4e;">Ver dieta:</label>
            <select name="dieta_id" onchange="this.form.submit()" style="padding:8px 12px; border-radius:8px; border:1px solid #ccc;">
                @foreach($dietas as $d)
                    <option value="{{ $d->id }}" {{ $d->id == $dieta->id ? 'selected' : '' }}>
                        {{ $d->nombre }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    @endif

    <div class="card">
        <h3 style="color:#4e6b4e; margin-bottom:0.5rem;">{{ $dieta->nombre }}</h3>
        <p>🎯 Objetivo calórico: <strong>{{ $dieta->objetivo }} kcal</strong></p>
        <p>📊 Porcentaje alcanzado: <strong>{{ $porcentajeAlcanzado }} %</strong></p>
        <p>📊 Creado en: <strong>{{ $dieta->created_at }}</strong></p>
        <p>📊 Actualizado en: <strong>{{ $dieta->updated_at }}</strong></p>
    </div>

    @foreach(['desayuno' => '🌅', 'almuerzo' => '🍎', 'comida' => '🍽️', 'merienda' => '🥪', 'cena' => '🌙', 'suplementos' => '💊'] as $tipo => $icono)
        @php
            $alimentos = $alimentos_por_comida[$tipo] ?? collect();
            $kcalSeccion  = $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->e_100 / 100);
            $protSeccion  = $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->prot_100 / 100);
            $grasaSeccion = $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->grasa_100 / 100);
            $hcSeccion    = $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->hc_100 / 100);
            $pct = $dieta->objetivo > 0 ? round($kcalSeccion / $dieta->objetivo * 100, 1) : 0;
        @endphp

        <div class="card">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:0.75rem;">
                <span style="font-size:20px">{{ $icono }}</span>
                <h3 style="color:#4e6b4e; margin:0;">{{ ucfirst($tipo) }}</h3>
            </div>

            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:1rem;">
                <span class="macro-pill macro-kcal">Kcal: <strong>{{ round($kcalSeccion, 1) }}</strong></span>
                <span class="macro-pill macro-prot">Prot: <strong>{{ round($protSeccion, 1) }}g</strong></span>
                <span class="macro-pill macro-grasa">Grasas: <strong>{{ round($grasaSeccion, 1) }}g</strong></span>
                <span class="macro-pill macro-hc">HC: <strong>{{ round($hcSeccion, 1) }}g</strong></span>
                <span class="macro-pill macro-pct">Energía: <strong>{{ $pct }}%</strong></span>
            </div>

            @if($alimentos->isNotEmpty())
                <table>
                    <thead>
                        <tr>
                            <th>Alimento</th>
                            <th>Peso bruto (g)</th>
                            <th>Peso neto (g)</th>
                            <th>Medidas caseras</th>
                            <th>Kcal</th>
                            <th>Proteínas</th>
                            <th>Grasas</th>
                            <th>H. Carbono</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alimentos as $alimento)
                            <tr>
                                <td>{{ $alimento->alimento }}</td>
                                <td>{{ $alimento->pivot->peso_bruto }}</td>
                                <td>{{ $alimento->pivot->peso_neto }}</td>
                                <td>{{ $alimento->pivot->medidas_caseras ?? '-' }}</td>
                                <td>{{ round($alimento->pivot->peso_bruto * $alimento->pc * $alimento->e_100 / 100, 1) }}</td>
                                <td>{{ round($alimento->pivot->peso_bruto * $alimento->pc * $alimento->prot_100 / 100, 1) }}</td>
                                <td>{{ round($alimento->pivot->peso_bruto * $alimento->pc * $alimento->grasa_100 / 100, 1) }}</td>
                                <td>{{ round($alimento->pivot->peso_bruto * $alimento->pc * $alimento->hc_100 / 100, 1) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if(isset($comidas[$tipo]) && $comidas[$tipo]->receta)
                    <div style="margin-top:1rem; padding:1rem; background:rgba(255,255,255,0.5); border-radius:8px;">
                        <strong>📝 Receta:</strong>
                        <p style="margin-top:0.5rem; white-space:pre-line;">{{ $comidas[$tipo]->receta }}</p>
                    </div>
                @endif
            @else
                <p style="color:#888;">No hay alimentos en {{ $tipo }}.</p>
            @endif
        </div>
    @endforeach
    
    <div class="botonera-acciones">
        <a href="{{ route('usuarios') }}" class="btn">⬅️ Volver a usuarios</a>
    </div>
</div>
@endsection
