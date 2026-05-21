@props(['tipo', 'icono', 'kcalTotalDia', 'comidas', 'alimentos', 'alimentosUsuario', 'dieta'])

<div class="seccion">
    <div class="seccion-header" onclick="toggleSeccion('{{ $tipo }}')">
        <span class="seccion-icon">{{ $icono }}</span>
        <span class="seccion-title">{{ ucfirst($tipo) }}</span>
        <div class="seccion-macros">
            <span class="macro-item macro-kcal">
                <span class="macro-label">Kcal: </span>
                <span class="macro-valor">{{ $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->e_100 / 100) }}</span>
            </span>
            <span class="macro-item macro-prot">
                <span class="macro-label">Prot: </span>
                <span class="macro-valor">{{ $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->prot_100 / 100) }}</span>
            </span>
            <span class="macro-item macro-grasa">
                <span class="macro-label">Grasas: </span>
                <span class="macro-valor">{{ $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->grasa_100 / 100) }}</span>
            </span>
            <span class="macro-item macro-hc">
                <span class="macro-label">HC:</span>
                <span class="macro-valor">{{ $alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->hc_100 / 100) }}</span>
            </span>
            @php
                $kcalTotal = round($alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->e_100), 2);
                $pct = $kcalTotalDia > 0 ? round($kcalTotal / $kcalTotalDia, 2) * 100 : 0;
            @endphp
            <span class="macro-item macro-pct">
                <span class="macro-label">Energia: </span>
                <span class="macro-valor">{{ $pct }}%</span>
            </span>
        </div>
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
                            <th>Medidas caseras</th>
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
                            <th>Eliminar</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alimentos as $alimento)
                            <tr>
                                <td>{{ $alimento->alimento }}</td>
                                <td>{{ $alimento->pivot->peso_bruto }}</td>
                                <td>{{ $alimento->pivot->peso_neto }}</td>
                                <td>{{ $alimento->pivot->medidas_caseras ?? '-' }}</td>
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
                                <td>
                                    <form action="{{ route('dietas.alimentos.eliminar', $dieta->id) }}" method="POST" class="form-eliminar">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="alimento_id" value="{{ $alimento->id }}">
                                        <input type="hidden" name="tipo_comida" value="{{ $tipo }}">
                                        <button type="submit" class="btn btn-danger btn-sm">✕</button>
                                    </form>
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-sm btn-edit"
                                            onclick="abrirModalEditar({{ $alimento->id }}, '{{ $tipo }}', {{ $alimento->pivot->peso_bruto }}, {{ $alimento->pivot->peso_neto }}, '{{ $alimento->pivot->medidas_caseras ?? '' }}')">
                                        ✏️
                                    </button>
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
                    <input type="text" name="medidas_caseras" class="form-input" placeholder="Medidas caseras (opcional)">
                    <button type="submit" class="btn">+ Añadir</button>
                </div>
            </form>
            <form action="{{ route('dietas.receta.agregar', $dieta->id) }}" method="POST">
                @csrf
                <input type="hidden" name="tipo_comida" value="{{ $tipo }}">
                <input type="hidden" name="dieta_id" value="{{ $dieta->id }}">
                <div class="form-grid">
                    <textarea name="receta"
                              class="form-input receta-textarea"
                              placeholder="Escribe o pega aquí la receta..."
                              rows="4">{{ old('receta', $comidas[$tipo]->receta ?? '') }}</textarea>
                    <button type="submit" class="btn">💾 Guardar receta</button>
                </div>
            </form>
        </div>
    </div>
</div>