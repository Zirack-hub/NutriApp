@extends('layouts.vista_admin')
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
        <p>📊 Porcentaje alcanzado: <strong>{{ round($porcentajeAlcanzado, 2) }} %</strong></p>
        <p>📊 Creado en: <strong>{{ $dieta->created_at }}</strong></p>
        <p>📊 Actualizado en: <strong>{{ $dieta->updated_at }}</strong></p>
        @php
            $alimentosTotales = collect($alimentos_por_comida)->flatten();
            
            $kcalTotal  = round($alimentosTotales->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->e_100   / 100), 2);
            $protTotal  = round($dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->prot_100  / 100), 2);
            $grasaTotal = round($dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->grasa_100 / 100), 2);
            $hcTotal    = round($dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->hc_100    / 100), 2);
            
            $pctProt   = $kcalTotal > 0 ? round((($protTotal * 4 / $kcalTotal) * 100) , 2) : 0;
            $pctGrasa  = $kcalTotal > 0 ? round((($grasaTotal * 9 / $kcalTotal) * 100) , 2) : 0;
            $pctHC     = $kcalTotal > 0 ? round((($hcTotal    * 4 / $kcalTotal) * 100) , 2) : 0;
            
            $pctMacros = round($pctProt + $pctGrasa + $pctHC, 2);
        @endphp
        <div style="margin-top:1rem;">
            <p style="font-weight:600; color:#4e6b4e; margin-bottom:0.5rem;">📊 Distribución de macronutrientes</p>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <span class="macro-pill macro-prot">Proteínas: <strong>{{ round($protTotal, 2) }}g</strong> · <strong>{{ $pctProt }}%</strong></span>
                <span class="macro-pill macro-grasa">Grasas: <strong>{{ round($grasaTotal, 2) }}g</strong> · <strong>{{ $pctGrasa }}%</strong></span>
                <span class="macro-pill macro-hc">Hidratos: <strong>{{ round($hcTotal, 2) }}g</strong> · <strong>{{ $pctHC }}%</strong></span>
                <span class="macro-pill macro-pct">% Macros: <strong>{{ $pctMacros }}%</strong></span>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 1rem; margin-bottom: 1rem;">
        <div style="display:flex; align-items:center; gap:10px; margin-bottom:0.75rem;">
            <span style="font-size:20px">💬</span>
            <h3 style="color:#4e6b4e; margin:0;">Retroalimentación para el alumno</h3>
        </div>
        <form action="{{ route('dietas.comentario.guardar', $dieta->id) }}" method="POST" style="width: 100%;">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <textarea 
                    name="comentario" 
                    placeholder="Escribe aquí las correcciones, anotaciones o sugerencias para el alumno sobre esta planificación..." 
                    style="width: 100%; min-height: 100px; padding: 12px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.15); background: rgba(255,255,255,0.6); font-family: inherit; font-size: 0.9em; color: #4e6b4e; resize: vertical; outline: none;"
                >{{ old('comentario', $dieta->comentario) }}</textarea>
                
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px;">
                    @if($dieta->comentario)
                        <span style="font-size: 0.8em; color: {{ $dieta->comentario_leido ? '#56ab2f' : '#ff9800' }}; font-weight: 600;">
                            {{ $dieta->comentario_leido ? '✓ Visto por el alumno' : '✉️ Pendiente de leer' }}
                        </span>
                    @endif
                    <button type="submit" class="btn" style="padding: 10px 20px; border-radius: 12px; font-weight: bold; color: white; background: linear-gradient(135deg, #a8e063, #56ab2f); border: none; cursor: pointer; transition: 0.3s; font-size:0.85em;">
                        💾 Guardar comentario
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Bucle de las comidas existentes --}}
    @foreach(['desayuno' => '🌅', 'almuerzo' => '🍎', 'comida' => '🍽️', 'merienda' => '🥪', 'cena' => '🌙', 'suplementos' => '💊'] as $tipo => $icono)
        @php
            $alimentos = $alimentos_por_comida[$tipo] ?? collect();
            $kcalSeccion  = $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->e_100 / 100);
            $protSeccion  = $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->prot_100 / 100);
            $grasaSeccion = $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->grasa_100 / 100);
            $hcSeccion    = $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->hc_100 / 100);
            $kcalTotal = round($alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->e_100), 2);
            $pct = $kcalTotalDia > 0 ? round($kcalTotal / $kcalTotalDia, 2) * 100 : 0;
        @endphp

        <div class="card">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:0.75rem;">
                <span style="font-size:20px">{{ $icono }}</span>
                <h3 style="color:#4e6b4e; margin:0;">{{ ucfirst($tipo) }}</h3>
            </div>

            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:1rem;">
                <span class="macro-pill macro-kcal">Kcal: <strong>{{ round($kcalSeccion, 2) }}</strong></span>
                <span class="macro-pill macro-prot">Prot: <strong>{{ round($protSeccion, 2) }}g</strong></span>
                <span class="macro-pill macro-grasa">Grasas: <strong>{{ round($grasaSeccion, 2) }}g</strong></span>
                <span class="macro-pill macro-hc">HC: <strong>{{ round($hcSeccion, 2) }}g</strong></span>
                <span class="macro-pill macro-pct">Energía: <strong>{{ round($pct, 2) }}%</strong></span>
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
                                <td>{{ round($alimento->pivot->peso_bruto * $alimento->pc * $alimento->e_100 / 100, 2) }}</td>
                                <td>{{ round($alimento->pivot->peso_bruto * $alimento->pc * $alimento->prot_100 / 100, 2) }}</td>
                                <td>{{ round($alimento->pivot->peso_bruto * $alimento->pc * $alimento->grasa_100 / 100, 2) }}</td>
                                <td>{{ round($alimento->pivot->peso_bruto * $alimento->pc * $alimento->hc_100 / 100, 2) }}</td>
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
</div>
@endsection
