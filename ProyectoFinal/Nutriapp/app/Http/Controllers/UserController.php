<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    public function usuarios()
    {
        if(!Auth::check()){
            return redirect('/login');
        }
        

        // alumno no puede entrar
        if (Auth::user()->tipo == 3) {
            abort(403, 'No tienes permiso para acceder a esta página');
        }
        // admin ve todos
        if (Auth::user()->tipo == 1) {
            $usuarios = User::all();
        }
        // profesor ve profesor + alumnos
        if (Auth::user()->tipo == 2) {
            $usuarios = User::whereIn('tipo', [2, 3])->get();
        }

        return view('usuarios.usuarios', compact('usuarios'));
    }
    public function create()
    {
        if (Auth::user()->tipo == 3) {
            abort(403, 'No tienes permiso para acceder a esta página');
        }
        return view('usuarios.create');
    }
    public function store(Request $request)
    {
        
         // profesor solo puede crear alumnos
        if (Auth::user()->tipo == 2 && $request->tipo == 1) {
            abort(403);
        }

        // alumno no puede crear nada
        if (Auth::user()->tipo == 3) {
            abort(403);
        }
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
            'tipo' => 'required|in:1,2,3',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tipo' => $request->tipo,
        ]);

        return redirect()->route('usuarios')->with('success', 'Usuario creado exitosamente');
    }
    public function cambiarPassword(Request $request, User $usuario){
        if (Auth::user()->tipo != 1) {
        return redirect('/usuarios')->with('error', 'No tienes permisos');
}

        $request->validate([
            'password' => 'required|min:6'
        ]);

        $usuario->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect('/usuarios');
    
    }
}
