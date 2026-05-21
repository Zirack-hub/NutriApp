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

    public function store(Request $request)
    {
        $alimento = $request->all();
        $alimento['user_id'] = Auth::user()->id;
        Alimento::create($alimento);
        return redirect()->route('alimentos');
    }

    public function edit(Alimento $alimento): View
    {
        return view('alimentos.edit', compact('alimento'));
    }

    public function update(Request $request, Alimento $alimento): RedirectResponse
    {
        $alimento->update($request->all());
        return redirect()->route('alimentos');
    }

    public function destroy(Alimento $alimento): RedirectResponse
    {
        $alimento->delete();
        return redirect()->route('alimentos');
    }
}