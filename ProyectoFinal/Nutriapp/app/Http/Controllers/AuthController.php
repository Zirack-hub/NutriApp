<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dieta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Muestra la vista del formulario de login
    public function showLogin(){
        return view('inicio.login');
    }

    // Procesa el intento de login con email y contraseña.
    // Si el usuario debe cambiar su contraseña, lo redirige a ese formulario.
    // Si las credenciales son incorrectas, devuelve un error
    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)){
            if(Auth::user()->must_change_password){
                return redirect()->route('usuarios.cambiar-password-propio');
            }
            return redirect('/inicio');
        }
        return back()->with('error','Credenciales incorrectas');
    }

    // Muestra la página de inicio para el usuario autenticado
    // junto con el contador de comentarios de retroalimentación no leídos
    public function inicio(){
        if(!Auth::check()){
            return redirect('/login');
        }

        $comentariosNuevos = Dieta::where('user_id', Auth::id())
            ->whereNotNull('comentario')
            ->where('comentario', '!=', '')
            ->where('comentario_leido', false)
            ->count();

        return view('inicio.inicio', compact('comentariosNuevos'));
    }

    // Cierra la sesión del usuario y redirige al login
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}