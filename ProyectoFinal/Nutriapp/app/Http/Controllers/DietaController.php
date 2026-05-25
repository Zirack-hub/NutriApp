<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dieta;
use App\Models\Alimento;
use App\Models\Comida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DietaController extends Controller
{
    // Redirige a la primera dieta del usuario, o al formulario de creación si no tiene ninguna
    function mostrarDietas()
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        $primeraDieta = Dieta::where('user_id', Auth::id())
                    ->oldest()
                    ->first();

        if(!$primeraDieta){
            return redirect()->route('dietas.create');
        }

        return redirect()->route('dietas.show', $primeraDieta->id);
    }

    // Muestra el formulario para crear una nueva dieta
    function createDieta()
    {
        $comentariosNuevos = Dieta::where('user_id', Auth::id())
            ->whereNotNull('comentario')
            ->where('comentario', '!=', '')
            ->where('comentario_leido', false)
            ->count();

        return view('dietas.create', compact('comentariosNuevos'));
    }

    // Valida y guarda una nueva dieta en la base de datos, luego redirige a la primera dieta del usuario
    function storeDieta(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'objetivo' => 'required|numeric|min:1',
        ]);

        Dieta::create([
            'nombre' => $request->nombre,
            'objetivo' => $request->objetivo,
            'user_id' => Auth::id(),
        ]);

        $primeraDieta = Dieta::where('user_id', Auth::id())
                    ->oldest()
                    ->first();

        return redirect()->route('dietas.show', $primeraDieta->id)
            ->with('success', 'Dieta "' . $request->nombre . '" creada correctamente.');
    }

    // Muestra el detalle de una dieta concreta con todos sus alimentos agrupados por tipo de comida,
    // cálculo de calorías totales, macronutrientes y porcentaje de objetivo alcanzado
    function mostrarDieta($id)
    {
        $dieta = Dieta::findOrFail($id);
        $dietas = Dieta::where('user_id', Auth::id())->get();

        $alimentos_por_comida = $dieta->alimentos()->get()->groupBy('pivot.tipo_comida');

        foreach ($alimentos_por_comida as $tipo => $alimentos) {
            $alimentos_por_comida[$tipo] = $alimentos->sortBy('pivot.created_at');
        }

        $alimentos_usuario = Alimento::where('user_id', Auth::id())->get();

        $kcalTotalDia = $dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->e_100 / 100) * 100;
        $porcentajeAlcanzado = round($kcalTotalDia / $dieta->objetivo, 2);
        $comidas = Comida::where('dieta_id', $id)->get()->keyBy('comida');

        $protTotalDia  = round($dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->prot_100  ), 2);
        $grasaTotalDia = round($dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->grasa_100 ), 2);
        $hcTotalDia    = round($dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->hc_100    ), 2);

        $pctProteinas = $kcalTotalDia > 0 ? round($protTotalDia  * 4 / $kcalTotalDia * 100, 2) : 0;
        $pctGrasas    = $kcalTotalDia > 0 ? round($grasaTotalDia * 9 / $kcalTotalDia * 100, 2) : 0;
        $pctHC        = $kcalTotalDia > 0 ? round($hcTotalDia    * 4 / $kcalTotalDia * 100, 2) : 0;
        $pctMacros    = round($pctProteinas + $pctGrasas + $pctHC, 2);

        $comentariosNuevos = Dieta::where('user_id', Auth::id())
            ->whereNotNull('comentario')
            ->where('comentario', '!=', '')
            ->where('comentario_leido', false)
            ->count();

        return view('dietas.dieta', compact(
            'dieta', 'dietas', 'alimentos_por_comida', 'alimentos_usuario',
            'porcentajeAlcanzado', 'kcalTotalDia', 'comidas',
            'protTotalDia', 'grasaTotalDia', 'hcTotalDia',
            'pctProteinas', 'pctGrasas', 'pctHC', 'pctMacros',
            'comentariosNuevos'
        ));
    }

    // Actualiza el nombre y el objetivo calórico de una dieta existente
    public function updateDieta(Request $request, $id)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'objetivo' => 'required|numeric|min:1',
        ]);

        $dieta = Dieta::findOrFail($id);
        $dieta->update([
            'nombre'   => $request->nombre,
            'objetivo' => $request->objetivo,
        ]);

        return redirect()->back()->with('success', 'Dieta "' . $dieta->nombre . '" actualizada correctamente.');
    }

    // Elimina una dieta junto con todos sus alimentos asociados y redirige a la siguiente dieta disponible
    public function destroyDieta($id)
    {
        $dieta = Dieta::findOrFail($id);
        $nombreDieta = $dieta->nombre;

        $dieta->alimentos()->detach();
        $dieta->delete();

        $siguiente = Dieta::where('user_id', Auth::id())->oldest()->first();

        return redirect()->route('dietas.show', $siguiente->id)
            ->with('success', 'Dieta "' . $nombreDieta . '" eliminada correctamente.');
    }

    // Añade un alimento a una dieta en un tipo de comida concreto (desayuno, comida, cena...)
    function agregarAlimento(Request $request, $id)
    {
        $request->validate([
            'alimento_id'      => 'required|exists:alimentos,id',
            'tipo_comida'      => 'required|in:desayuno,almuerzo,comida,merienda,cena,suplementos',
            'peso_bruto'       => 'required|numeric|min:0',
            'peso_neto'        => 'required|numeric|min:0',
            'medidas_caseras'  => 'nullable|string|max:100',
        ]);

        $dieta = Dieta::findOrFail($id);
        $alimento = Alimento::findOrFail($request->alimento_id);

        $dieta->alimentos()->attach($request->alimento_id, [
            'tipo_comida'     => $request->tipo_comida,
            'peso_bruto'      => $request->peso_bruto,
            'peso_neto'       => $request->peso_neto,
            'medidas_caseras' => $request->medidas_caseras,
        ]);

        $dieta->updated_at = now();
        $dieta->save();

        return redirect()->route('dietas.show', $id)
            ->with('success', '"' . $alimento->alimento . '" añadido al ' . $request->tipo_comida . ' correctamente.');
    }

    // Actualiza un alimento de la dieta: si cambia el alimento, desvincula el anterior y adjunta el nuevo;
    // si es el mismo, solo actualiza los pesos y medidas
    public function actualizarAlimento(Request $request, $dietaId)
    {
        $request->validate([
            'alimento_id_viejo' => 'required|exists:alimentos,id',
            'alimento_id_nuevo' => 'required|exists:alimentos,id',
            'tipo_comida'       => 'required|string',
            'peso_bruto'        => 'required|numeric|min:0',
            'peso_neto'         => 'required|numeric|min:0',
            'medidas_caseras'   => 'nullable|string|max:255',
        ]);

        $dieta = Dieta::findOrFail($dietaId);
        $alimentoNuevo = Alimento::findOrFail($request->alimento_id_nuevo);

        if ($request->alimento_id_viejo != $request->alimento_id_nuevo) {
            $dieta->alimentos()->wherePivot('tipo_comida', $request->tipo_comida)->detach($request->alimento_id_viejo);

            $dieta->alimentos()->attach($request->alimento_id_nuevo, [
                'tipo_comida'     => $request->tipo_comida,
                'peso_bruto'      => $request->peso_bruto,
                'peso_neto'       => $request->peso_neto,
                'medidas_caseras' => $request->medidas_caseras,
            ]);
        } else {
            $dieta->alimentos()->wherePivot('tipo_comida', $request->tipo_comida)
                ->updateExistingPivot($request->alimento_id_viejo, [
                    'peso_bruto'      => $request->peso_bruto,
                    'peso_neto'       => $request->peso_neto,
                    'medidas_caseras' => $request->medidas_caseras,
                ]);
        }

        $dieta->updated_at = now();
        $dieta->save();

        return redirect()->back()
            ->with('success', '"' . $alimentoNuevo->alimento . '" actualizado correctamente.');
    }

    // Elimina un alimento concreto de un tipo de comida dentro de una dieta
    function eliminarAlimento(Request $request, $id)
    {
        $dieta = Dieta::findOrFail($id);
        $alimento = Alimento::findOrFail($request->alimento_id);
        $nombreAlimento = $alimento->alimento;

        $dieta->alimentos()->wherePivot('tipo_comida', $request->tipo_comida)
              ->detach($request->alimento_id);

        $dieta->updated_at = now();
        $dieta->save();

        return redirect()->route('dietas.show', $id)
            ->with('success', '"' . $nombreAlimento . '" eliminado del ' . $request->tipo_comida . ' correctamente.');
    }

    // Guarda o actualiza la receta asociada a un tipo de comida dentro de una dieta
    public function agregarReceta(Request $request, $id)
    {
        $request->validate([
            'receta'      => 'required|string',
            'tipo_comida' => 'required|string',
        ]);

        Comida::updateOrCreate(
            ['dieta_id' => $id, 'comida' => $request->tipo_comida],
            ['receta'   => $request->receta]
        );

        return back()->with('success', 'Receta para el ' . $request->tipo_comida . ' guardada correctamente.');
    }
}
