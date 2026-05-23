<?php

namespace App\Http\Controllers;

use App\Models\Dieta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoComentarioController extends Controller
{
    // Muestra todos los comentarios de retroalimentación recibidos por el alumno autenticado,
    // ordenando primero los no leídos y luego por fecha de actualización
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

    // Marca un comentario de una dieta concreta como leído
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