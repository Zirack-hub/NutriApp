@props(['tipo', 'icono', 'alimentos', 'alimentosUsuario', 'dieta'])

<div class="seccion">
    <div class="seccion-header" onclick="toggleSeccion('{{ $tipo }}')">
        <span class="seccion-icon">{{ $icono }}</span>
        <span class="seccion-title">{{ ucfirst($tipo) }}</span>
        <span class="seccion-arrow">▾</span>
    </div>
    <div class="seccion-body" id="seccion-{{ $tipo }}">
        @if($alimentos->isNotEmpty())
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Alimento</th>
                            <th>Peso bruto (g)</th>
                            <th>Peso neto (g)</th>
                            <th>Unidad</th>
                            <th>Medidas caseras</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alimentos as $alimento)
                            <tr>
                                <td>{{ $alimento->alimento }}</td>
                                <td>{{ $alimento->pivot->peso_bruto }}</td>
                                <td>{{ $alimento->pivot->peso_neto }}</td>
                                <td>{{ $alimento->pivot->unidad }}</td>
                                <td>{{ $alimento->pivot->medidas_caseras ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('dietas.alimentos.eliminar', $dieta->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="alimento_id" value="{{ $alimento->id }}">
                                        <input type="hidden" name="tipo_comida" value="{{ $tipo }}">
                                        <button type="submit" class="btn btn-danger btn-sm">✕</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="empty-msg">No hay alimentos en {{ $tipo }}</p>
        @endif
        <div class="form-añadir">
            <form action="{{ route('dietas.alimentos.agregar', $dieta->id) }}" method="POST">
                @csrf
                <input type="hidden" name="tipo_comida" value="{{ $tipo }}">
                
                <select name="alimento_id" class="form-select" required>
                    <option value="">-- Selecciona alimento --</option>
                    @foreach($alimentosUsuario as $alimentoU)
                        <option value="{{ $alimentoU->id }}">{{ $alimentoU->alimento }}</option>
                    @endforeach
                </select>
                <div class="form-grid">
                    <input type="number" name="peso_bruto" class="form-input" placeholder="Peso bruto (g)" min="0" required>
                    <input type="number" name="peso_neto" class="form-input" placeholder="Peso neto (g)" min="0" required>
                    <input type="text" name="unidad" class="form-input" placeholder="Unidad" required>
                    <input type="text" name="medidas_caseras" class="form-input" placeholder="Medidas caseras (opcional)">
                    <button type="submit" class="btn">+ Añadir</button>
                </div>
            </form>
        </div>
    </div>
</div>