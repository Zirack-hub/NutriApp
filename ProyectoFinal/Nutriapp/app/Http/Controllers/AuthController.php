<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dieta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin(){
        return view('inicio.login');
    }

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

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}