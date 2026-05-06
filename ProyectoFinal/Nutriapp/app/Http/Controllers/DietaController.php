<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dieta;
use App\Models\Alimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $alimentos_por_comida = $dieta->alimentos()
            ->get()
            ->groupBy('pivot.tipo_comida');

        $alimentos_usuario = Alimento::where('user_id', Auth::id())->get();

        return view('dietas.dieta', compact('dieta', 'dietas', 'alimentos_por_comida', 'alimentos_usuario'));
    }

    function agregarAlimento(Request $request, $id)
    {
        $request->validate([
            'alimento_id'      => 'required|exists:alimentos,id',
            'tipo_comida'      => 'required|in:desayuno,almuerzo,comida,merienda,cena,suplementos',
            'peso_bruto'       => 'required|numeric|min:0',
            'peso_neto'        => 'required|numeric|min:0',
            'unidad'           => 'required|string|max:50',
            'medidas_caseras'  => 'nullable|string|max:100',
        ]);

        $dieta = Dieta::findOrFail($id);

        $dieta->alimentos()->attach($request->alimento_id, [
            'tipo_comida'     => $request->tipo_comida,
            'peso_bruto'      => $request->peso_bruto,
            'peso_neto'       => $request->peso_neto,
            'unidad'          => $request->unidad,
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
}