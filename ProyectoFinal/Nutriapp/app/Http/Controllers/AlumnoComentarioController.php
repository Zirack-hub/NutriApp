<?php

namespace App\Http\Controllers;

use App\Models\Dieta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoComentarioController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $dietasConComentarios = Dieta::where('user_id', Auth::id())
            ->whereNotNull('comentario')
            ->where('comentario', '!=', '')
            ->orderBy('comentario_leido', 'asc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('usuarios.comentarios', compact('dietasConComentarios'));
    }

    public function marcarVisto($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $dieta = Dieta::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $dieta->comentario_leido = true;
        $dieta->save();

        return redirect()->back()->with('success', 'Comentario marcado como visto.');
    }
}