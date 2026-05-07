@extends('layouts.default')
@section('title', 'Editar Alimento')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/agregar_alimentos.css') }}">
@endsection
@section('content')
<div class="container">
    <form method="POST" action="{{ route('alimentos.update', $alimento->id) }}">
        @method('PUT')
        @csrf
        <div class="form-header field-group" style="background: none;">
            <label>Alimento:</label>
            <input type="text" name="alimento" value="{{ $alimento->alimento }}" required/>
        </div>
        <div class="field-group"><label>PC:</label><input type="number" step="0.01" name="pc" value="{{ $alimento->pc }}" required></div>
        <div class="field-group"><label>E_100:</label><input type="number" step="0.01" name="e_100" value="{{ $alimento->e_100 }}" required></div>
        <div class="field-group"><label>Prot:</label><input type="number" step="0.01" name="prot_100" value="{{ $alimento->prot_100 }}" required></div>
        <div class="field-group"><label>Grasa:</label><input type="number" step="0.01" name="grasa_100" value="{{ $alimento->grasa_100 }}" required></div>
        <div class="field-group"><label>AGS:</label><input type="number" step="0.01" name="ags_100" value="{{ $alimento->ags_100 }}" required></div>
        <div class="field-group"><label>AGMI:</label><input type="number" step="0.01" name="agmi_100" value="{{ $alimento->agmi_100 }}" required></div>
        <div class="field-group"><label>AGPI:</label><input type="number" step="0.01" name="agpi_100" value="{{ $alimento->agpi_100 }}" required></div>
        <div class="field-group"><label>Colest:</label><input type="number" step="0.01" name="col_100" value="{{ $alimento->col_100 }}" required></div>
        <div class="field-group"><label>HC:</label><input type="number" step="0.01" name="hc_100" value="{{ $alimento->hc_100 }}" required></div>
        <div class="field-group"><label>Fibra:</label><input type="number" step="0.01" name="fibra_100" value="{{ $alimento->fibra_100 }}" required></div>
        <div class="field-group"><label>Vit C:</label><input type="number" step="0.01" name="vit_c_100" value="{{ $alimento->vit_c_100 }}" required></div>
        <div class="field-group"><label>Vit B6:</label><input type="number" step="0.01" name="vit_b6_100" value="{{ $alimento->vit_b6_100 }}" required></div>
        <div class="field-group"><label>Vit E:</label><input type="number" step="0.01" name="vit_e_100" value="{{ $alimento->vit_e_100 }}" required></div>
        <div class="field-group"><label>Fe:</label><input type="number" step="0.01" name="fe_100" value="{{ $alimento->fe_100 }}" required></div>
        <div class="field-group"><label>Na:</label><input type="number" step="0.01" name="na_100" value="{{ $alimento->na_100 }}" required></div>
        <div class="field-group"><label>Ca:</label><input type="number" step="0.01" name="ca_100" value="{{ $alimento->ca_100 }}" required></div>
        <div class="field-group"><label>K:</label><input type="number" step="0.01" name="k_100" value="{{ $alimento->k_100 }}" required></div>
        <div class="field-group"><label>Vit D:</label><input type="number" step="0.01" name="vit_d_100" value="{{ $alimento->vit_d_100 }}" required></div>
        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Actualizar alimento</button>
            <a href="javascript:history.back()" class="btn btn-back">← Volver</a>
        </div>
    </form>
</div>
@endsection