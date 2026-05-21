@extends('layouts.alimento')
@section('title', 'Alimentos')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/alimentos.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="dashboard">
        <h1 class="title">Mis Alimentos</h1>

        <div class="botonera">
            <a href="{{ route('alimentos.create') }}" class="btn">+ Crear alimento</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Alimento</th>
                        <th>pc</th>
                        <th>e_100</th>
                        <th>prot_100</th>
                        <th>grasa_100</th>
                        <th>ags_100</th>
                        <th>agmi_100</th>
                        <th>agpi_100</th>
                        <th>col_100</th>
                        <th>hc_100</th>
                        <th>fibra_100</th>
                        <th>vit_c_100</th>
                        <th>vit_b6_100</th>
                        <th>vit_e_100</th>
                        <th>fe_100</th>
                        <th>na_100</th>
                        <th>ca_100</th>
                        <th>k_100</th>
                        <th>vit_d_100</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alimentos as $alimento)
                        <tr>
                            <td>{{ $alimento->alimento }}</td>
                            <td>{{ $alimento->pc }}</td>
                            <td>{{ $alimento->e_100 }}</td>
                            <td>{{ $alimento->prot_100 }}</td>
                            <td>{{ $alimento->grasa_100 }}</td>
                            <td>{{ $alimento->ags_100 }}</td>
                            <td>{{ $alimento->agmi_100 }}</td>
                            <td>{{ $alimento->agpi_100 }}</td>
                            <td>{{ $alimento->col_100 }}</td>
                            <td>{{ $alimento->hc_100 }}</td>
                            <td>{{ $alimento->fibra_100 }}</td>
                            <td>{{ $alimento->vit_c_100 }}</td>
                            <td>{{ $alimento->vit_b6_100 }}</td>
                            <td>{{ $alimento->vit_e_100 }}</td>
                            <td>{{ $alimento->fe_100 }}</td>
                            <td>{{ $alimento->na_100 }}</td>
                            <td>{{ $alimento->ca_100 }}</td>
                            <td>{{ $alimento->k_100 }}</td>
                            <td>{{ $alimento->vit_d_100 }}</td>
                            <td class="acciones">
                                <a href="{{ route('alimentos.edit', $alimento->id) }}" class="btn btn-edit btn-sm">✏️</a>
                                
                                <form method="POST" action="{{ route('alimentos.destroy', $alimento->id) }}" style="display:inline;" class="form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            data-nombre="{{ $alimento->alimento }}"
                                            data-tipo="alimento">
                                        ✕
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="20" class="mensaje">No se han introducido alimentos</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/mensaje_borrado.js') }}"></script>
@endsection