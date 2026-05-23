<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use App\Models\Dieta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AlimentoController extends Controller
{
    // Muestra la lista de alimentos del usuario autenticado
    public function mostrar()
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        $userId = Auth::id();

        $alimentos = Alimento::where('user_id', $userId)->get();

        $comentariosNuevos = Dieta::where('user_id', $userId)
            ->whereNotNull('comentario')
            ->where('comentario', '!=', '')
            ->where('comentario_leido', false)
            ->count();

        $dietas = Dieta::where('user_id', $userId)->get();

        return view('alimentos.alimentos', compact('alimentos', 'comentariosNuevos', 'dietas'));
    }

    // Muestra el formulario para crear un nuevo alimento
    public function create()
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        $userId = Auth::id();

        $comentariosNuevos = Dieta::where('user_id', $userId)
            ->whereNotNull('comentario')
            ->where('comentario', '!=', '')
            ->where('comentario_leido', false)
            ->count();

        $dietas = Dieta::where('user_id', $userId)->get();

        return view('alimentos.create', compact('comentariosNuevos', 'dietas'));
    }

    // Valida y guarda un nuevo alimento en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'alimento' => 'required',
            'pc' => 'required|integer|min:1',
            'e_100' => 'required|numeric|min:0',
            'prot_100' => 'required|numeric|min:0',
            'grasa_100' => 'required|numeric|min:0',
            'ags_100' => 'required|numeric|min:0',
            'agmi_100' => 'required|numeric|min:0',
            'agpi_100' => 'required|numeric|min:0',
            'col_100' => 'required|numeric|min:0',
            'hc_100' => 'required|numeric|min:0',
            'fibra_100' => 'required|numeric|min:0',
            'vit_c_100' => 'required|numeric|min:0',
            'vit_b6_100' => 'required|numeric|min:0',
            'vit_e_100' => 'required|numeric|min:0',
            'fe_100' => 'required|numeric|min:0',
            'na_100' => 'required|numeric|min:0',
            'ca_100' => 'required|numeric|min:0',
            'k_100' => 'required|numeric|min:0',
            'vit_d_100' => 'required|numeric|min:0',
        ]);

        $datos = $request->all();
        $datos['user_id'] = Auth::user()->id;
        Alimento::create($datos);

        return redirect()->route('alimentos')
            ->with('success', '"' . $request->alimento . '" creado correctamente.');
    }

    // Muestra el formulario de edición de un alimento existente
    public function edit(Alimento $alimento): View
    {
        $userId = Auth::id();

        return view('alimentos.edit', compact('alimento'));
    }

    // Actualiza los datos de un alimento existente en la base de datos
    public function update(Request $request, Alimento $alimento): RedirectResponse
    {
        try {
            $nombreAnterior = $alimento->alimento;
            $alimento->update($request->all());
            return redirect()->route('alimentos')
                ->with('success', '"' . $nombreAnterior . '" actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'No se pudo actualizar "' . $alimento->alimento . '".');
        }
    }

    // Elimina un alimento de la base de datos
    public function destroy(Alimento $alimento): RedirectResponse
    {
        try {
            $nombre = $alimento->alimento;
            $alimento->delete();
            return redirect()->route('alimentos')
                ->with('success', '"' . $nombre . '" eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'No se pudo eliminar "' . $alimento->alimento . '".');
        }
    }
}