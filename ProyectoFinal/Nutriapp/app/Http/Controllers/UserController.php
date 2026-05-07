<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alimento;
use App\Models\Dieta;
use App\Models\Comida;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

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
        $usuarios = collect();

        // admin ve todos
        if (Auth::user()->tipo == 1) {
            $usuarios = User::with('tipoRelacion')->get();
        }
        // profesor ve profesor + alumnos
        if (Auth::user()->tipo == 2) {
            $usuarios = User::with('tipoRelacion')->whereIn('tipo', [2,3])->get();
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
            'must_change_password' => $request->tipo == 3 ? true : false,
        ]);

        return redirect()->route('usuarios')->with('success', 'Usuario creado exitosamente');
    }
    public function showCambiarPasswordPropio()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (!Auth::user()->must_change_password) {
            return redirect('/inicio');
        }
        return view('usuarios.cambiar_password_propio');
    }

    public function cambiarPasswordPropio(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect('/inicio')->with('success', '¡Contraseña actualizada correctamente!');
    }

    public function destroy(User $usuario)
    {
        // Solo admin puede borrar usuarios
        if (Auth::user()->tipo != 1) {
            abort(403, 'No tienes permiso para borrar usuarios');
        }

        // No puede borrarse a sí mismo
        if (Auth::id() == $usuario->id) {
            return redirect()->route('usuarios')->with('error', 'No puedes eliminar tu propio usuario');
        }

        $usuario->delete();

        return redirect()->route('usuarios')->with('success', 'Usuario eliminado correctamente');
    }

    public function verAlimentosDeUsuario(User $usuario)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        // Solo admin y profesor pueden ver datos de otros usuarios
        if (Auth::user()->tipo == 3) {
            abort(403);
        }
        // Profesor solo puede ver alumnos, no admins
        if (Auth::user()->tipo == 2 && $usuario->tipo == 1) {
            abort(403);
        }

        $alimentos = Alimento::where('user_id', $usuario->id)->get();
        return view('alimentos.alimentos', compact('alimentos', 'usuario'));
    }

    public function verDietasDeUsuario(User $usuario)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        // Solo admin y profesor pueden ver datos de otros usuarios
        if (Auth::user()->tipo == 3) {
            abort(403);
        }
        // Profesor solo puede ver alumnos, no admins
        if (Auth::user()->tipo == 2 && $usuario->tipo == 1) {
            abort(403);
        }

        $primeraDieta = Dieta::where('user_id', $usuario->id)->oldest()->first();

        if (!$primeraDieta) {
            return redirect()->route('usuarios')->with('error', "{$usuario->nombre} no tiene dietas creadas.");
        }

        $dieta  = $primeraDieta;
        $dietas = Dieta::where('user_id', $usuario->id)->get();

        $alimentos_por_comida = $dieta->alimentos()->get()->groupBy('pivot.tipo_comida');
        foreach ($alimentos_por_comida as $tipo => $items) {
            $alimentos_por_comida[$tipo] = $items->sortBy('pivot.created_at');
        }

        $alimentos_usuario    = Alimento::where('user_id', $usuario->id)->get();
        $kcalTotalDia         = $dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->e_100 / 100) * 100;
        $porcentajeAlcanzado  = $dieta->objetivo > 0 ? round($kcalTotalDia / $dieta->objetivo, 2) : 0;
        $comidas              = Comida::where('dieta_id', $dieta->id)->get()->keyBy('comida');

        return view('dietas.dieta', compact('dieta', 'dietas', 'alimentos_por_comida', 'alimentos_usuario', 'porcentajeAlcanzado', 'kcalTotalDia', 'comidas', 'usuario'));
    }

    public function cambiarPassword(Request $request, User $usuario)
    {
        if (Auth::user()->tipo != 1) {
            return redirect('/usuarios')->with('error', 'No tienes permiso para cambiar contraseñas');
        }

        $request->validate([
            'password' => 'required|min:6'
        ]);

        $usuario->update([
            'password' => Hash::make($request->password),
            'must_change_password' => true,
        ]);

        return redirect('/usuarios');
    }
}
