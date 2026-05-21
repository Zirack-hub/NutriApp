<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dieta;
use App\Models\Alimento;
use App\Models\Comida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\alert;

class DietaController extends Controller
{
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

    function createDieta()
    {
        return view('dietas.create');
    }

    function storeDieta(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'objetivo' => 'required|integer',
        ]);

        Dieta::create([
            'nombre' => $request->nombre,
            'objetivo' => $request->objetivo,
            'user_id' => Auth::id(),
        ]);

        $primeraDieta = Dieta::where('user_id', Auth::id())
                    ->oldest()
                    ->first();

        return redirect()->route('dietas.show', $primeraDieta->id);
    }

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

        // Totales de macronutrientes del día
        $protTotalDia  = $dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->prot_100  / 100);
        $grasaTotalDia = $dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->grasa_100 / 100);
        $hcTotalDia    = $dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->hc_100    / 100);

        // Porcentajes de macros sobre kcal totales
        $pctProteinas = $kcalTotalDia > 0 ? round($protTotalDia  * 4 / $kcalTotalDia * 100, 2) : 0;
        $pctGrasas    = $kcalTotalDia > 0 ? round($grasaTotalDia * 9 / $kcalTotalDia * 100, 2) : 0;
        $pctHC        = $kcalTotalDia > 0 ? round($hcTotalDia    * 4 / $kcalTotalDia * 100, 2) : 0;
        $pctMacros    = round($pctProteinas + $pctGrasas + $pctHC, 2);

        return view('dietas.dieta', compact(
            'dieta', 'dietas', 'alimentos_por_comida', 'alimentos_usuario',
            'porcentajeAlcanzado', 'kcalTotalDia', 'comidas',
            'protTotalDia', 'grasaTotalDia', 'hcTotalDia',
            'pctProteinas', 'pctGrasas', 'pctHC', 'pctMacros'
        ));
    }

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

        $dieta->alimentos()->attach($request->alimento_id, [
            'tipo_comida'     => $request->tipo_comida,
            'peso_bruto'      => $request->peso_bruto,
            'peso_neto'       => $request->peso_neto,
            'medidas_caseras' => $request->medidas_caseras,
        ]);

        return redirect()->route('dietas.show', $id);
    }

    function eliminarAlimento(Request $request, $id)
    {
        $dieta = Dieta::findOrFail($id);

        $dieta->alimentos()->wherePivot('tipo_comida', $request->tipo_comida)
              ->detach($request->alimento_id);
        

        return redirect()->route('dietas.show', $id);
    }

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

    return back()->with('success', 'Receta guardada correctamente.');
    }
}