@extends('layouts.dieta')
@section('title', $dieta->nombre)
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/dietas.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="dashboard">
        <h1 class="title">{{ $dieta->nombre }}</h1>
        <div class="botonera">
            <a href="{{ route('dietas.create') }}" class="btn">+ Nueva dieta</a>
            <div class="dieta-control-btns">
                <button type="button" class="btn btn-edit" onclick="abrirModalEditarDieta('{{ $dieta->nombre }}', {{ $dieta->objetivo }})">Editar Dieta</button>
                <form method="POST" action="{{ route('dietas.destroy', $dieta->id) }}" style="display:inline;" class="form-eliminar">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" data-nombre="{{ $dieta->nombre }}" data-tipo="dieta">Borrar</button>
                </form>
            </div>
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

        <div class="macros-resumen">
            <div class="macros-resumen-titulo">📊 Distribución de macronutrientes</div>
            <div class="macros-resumen-pills">
                <div class="macro-resumen-item macro-resumen-prot">
                    <span class="macro-resumen-label">Proteínas</span>
                    <span class="macro-resumen-gramos">{{ $protTotalDia }}g</span>
                    <span class="macro-resumen-pct">{{ $pctProteinas }}%</span>
                </div>
                <div class="macro-resumen-item macro-resumen-grasa">
                    <span class="macro-resumen-label">Grasas</span>
                    <span class="macro-resumen-gramos">{{ $grasaTotalDia }}g</span>
                    <span class="macro-resumen-pct">{{ $pctGrasas }}%</span>
                </div>
                <div class="macro-resumen-item macro-resumen-hc">
                    <span class="macro-resumen-label">Hidratos</span>
                    <span class="macro-resumen-gramos">{{ $hcTotalDia }}g</span>
                    <span class="macro-resumen-pct">{{ $pctHC }}%</span>
                </div>
                <div class="macro-resumen-item macro-resumen-total">
                    <span class="macro-resumen-label">% Macros</span>
                    <span class="macro-resumen-gramos">{{ $pctMacros }}</span>
                </div>
            </div>
        </div>
        <x-seccion tipo="desayuno" icono="🌅" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['desayuno'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="almuerzo" icono="🍎" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['almuerzo'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="comida"   icono="🍽️" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['comida'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="merienda" icono="🥪" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['merienda'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="cena"     icono="🌙" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['cena'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
        <x-seccion tipo="suplementos" icono="💊" kcalTotalDia="{{ $kcalTotalDia }}" :comidas="$comidas" :alimentos="$alimentos_por_comida['suplementos'] ?? collect()" :alimentos-usuario="$alimentos_usuario" :dieta="$dieta" />
    </div>
</div>

<div id="modal-editar-dieta" class="modal-editar-overlay" style="display: none;">
    <div class="modal-editar-box">
        <h3>Configurar Dieta</h3>
        <form action="{{ route('dietas.update', $dieta->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-editar-grupo">
                <label for="modal-dieta-nombre">Nombre de la dieta:</label>
                <input type="text" name="nombre" id="modal-dieta-nombre" class="form-input" required>
            </div>
            <div class="modal-editar-grupo">
                <label for="modal-dieta-objetivo">Objetivo calórico (kcal):</label>
                <input type="number" name="objetivo" id="modal-dieta-objetivo" class="form-input" min="1" required>
            </div>
            <div class="modal-editar-botones">
                <button type="button" class="btn btn-secondary" onclick="cerrarModalEditarDieta()">Cancelar</button>
                <button type="submit" class="btn btn-confirmar-modal">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-editar-alimento" class="modal-editar-overlay" style="display: none;">
    <div class="modal-editar-box">
        <h3>✏️ Editar Alimento y Porciones</h3>
        <form id="form-editar-modal" action="{{ route('dietas.alimentos.actualizar', $dieta->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="alimento_id_viejo" id="modal-input-id-viejo">
            <input type="hidden" name="tipo_comida" id="modal-input-tipo">
            <div class="modal-editar-grupo">
                <label>Alimento:</label>
                <select name="alimento_id_nuevo" id="modal-select-alimento" class="form-select" style="width: 100%; padding: 0.5rem;" required>
                    @foreach($alimentos_usuario as $alimentoU)
                        <option value="{{ $alimentoU->id }}">{{ $alimentoU->alimento }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-editar-grupo">
                <label>Peso bruto (g):</label>
                <input type="number" name="peso_bruto" id="modal-input-bruto" class="form-input" min="0" step="0.01" required>
            </div>
            <div class="modal-editar-grupo">
                <label>Peso neto (g):</label>
                <input type="number" name="peso_neto" id="modal-input-neto" class="form-input" min="0" step="0.01" required>
            </div>
            <div class="modal-editar-grupo">
                <label>Medidas caseras:</label>
                <input type="text" name="medidas_caseras" id="modal-input-medidas" class="form-input">
            </div>
            <div class="modal-editar-botones">
                <button type="button" class="btn btn-secondary" onclick="cerrarModalEditar()">Cancelar</button>
                <button type="submit" class="btn btn-confirmar-modal">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')  
    <script src="{{ asset('assets/js/mantener_secciones.js') }}"></script>
    <script src="{{ asset('assets/js/mensaje_borrado.js') }}"></script>
    <script src="{{ asset('assets/js/editar_alimento.js') }}"></script>
    <script src="{{ asset('assets/js/editar_dieta.js') }}"></script>
@endsection