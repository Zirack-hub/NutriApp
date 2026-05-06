@extends('layouts.default')
@section('title', 'Alimentos/create')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/agregar_alimentos.css') }}">
@endsection
@section('content')
<div class="container">
    <form method="POST" action="{{ route('alimentos.store') }}">
        @csrf
        
        <label>Alimento:</label>
        <input type="text" name="alimento" required/>

        <label>pc</label>
        <input type="number" step="0.01" name="pc" required/>

        <label>e_100</label>
        <input type="number" step="0.01" name="e_100" required/>

        <label>prot_100</label>
        <input type="number" step="0.01" name="prot_100" required/>

        <label>grasa_100</label>
        <input type="number" step="0.01" name="grasa_100" required/>

        <label>ags_100</label>
        <input type="number" step="0.01" name="ags_100" required/>

        <label>agmi_100</label>
        <input type="number" step="0.01" name="agmi_100" required/>

        <label>agpi_100</label>
        <input type="number" step="0.01" name="agpi_100" required/>

        <label>col_100</label>
        <input type="number" step="0.01" name="col_100" required/>

        <label>hc_100</label>
        <input type="number" step="0.01" name="hc_100" required/>

        <label>fibra_100</label>
        <input type="number" step="0.01" name="fibra_100" required/>

        <label>vit_c_100</label>
        <input type="number" step="0.01" name="vit_c_100" required/>

        <label>vit_b6_100</label>
        <input type="number" step="0.01" name="vit_b6_100" required/>

        <label>vit_e_100</label>
        <input type="number" step="0.01" name="vit_e_100" required/>

        <label>fe_100</label>
        <input type="number" step="0.01" name="fe_100" required/>

        <label>na_100</label>
        <input type="number" step="0.01" name="na_100" required/>

        <label>ca_100</label>
        <input type="number" step="0.01" name="ca_100" required/>

        <label>k_100</label>
        <input type="number" step="0.01" name="k_100" required/>

        <label>vit_d_100</label>
        <input type="number" step="0.01" name="vit_d_100" required/>

        <input type="submit" value="Crear alimento" class="btn"/>
    </form>
</div>
@endsection