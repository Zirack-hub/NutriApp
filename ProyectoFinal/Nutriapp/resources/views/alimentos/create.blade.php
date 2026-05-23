@extends('layouts.default')
@section('title', 'Alimentos/create')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/agregar_alimentos.css') }}">
@endsection
@section('content')
<div class="container">
    <form method="POST" action="{{ route('alimentos.store') }}">
        @csrf
        <div class="form-header field-group" style="background: none;">
            <label>Alimento:</label>
            <input type="text" name="alimento" placeholder="Nombre del alimento..." required/>
        </div>
        <div class="field-group"><label>PC:</label><input type="number" step="1" name="pc" required></div>
        <div class="field-group"><label>E_100:</label><input type="number" step="0.01" name="e_100" required></div>
        <div class="field-group"><label>Prot_100:</label><input type="number" step="0.01" name="prot_100" required></div>
        <div class="field-group"><label>Grasa_100:</label><input type="number" step="0.01" name="grasa_100" required></div>
        <div class="field-group"><label>AGS_100:</label><input type="number" step="0.01" name="ags_100" required></div>
        <div class="field-group"><label>AGMI_100:</label><input type="number" step="0.01" name="agmi_100" required></div>
        <div class="field-group"><label>AGPI_100:</label><input type="number" step="0.01" name="agpi_100" required></div>
        <div class="field-group"><label>Colest_100:</label><input type="number" step="0.01" name="col_100" required></div>
        <div class="field-group"><label>HC_100:</label><input type="number" step="0.01" name="hc_100" required></div>
        <div class="field-group"><label>Fibra_100:</label><input type="number" step="0.01" name="fibra_100" required></div>
        <div class="field-group"><label>Vit C_100:</label><input type="number" step="0.01" name="vit_c_100" required></div>
        <div class="field-group"><label>Vit B6_100:</label><input type="number" step="0.01" name="vit_b6_100" required></div>
        <div class="field-group"><label>Vit E_100:</label><input type="number" step="0.01" name="vit_e_100" required></div>
        <div class="field-group"><label>Fe_100:</label><input type="number" step="0.01" name="fe_100" required></div>
        <div class="field-group"><label>Na_100:</label><input type="number" step="0.01" name="na_100" required></div>
        <div class="field-group"><label>Ca_100:</label><input type="number" step="0.01" name="ca_100" required></div>
        <div class="field-group"><label>K_100:</label><input type="number" step="0.01" name="k_100" required></div>
        <div class="field-group"><label>Vit D_100:</label><input type="number" step="0.01" name="vit_d_100" required></div>
        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Crear alimento</button>
            <a href="javascript:history.back()" class="btn btn-back">
                ← Volver
            </a>
        </div>
    </form>
</div>
@endsection