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
    // Muestra la lista de usuarios según el rol del autenticado:
    // el admin ve todos, el profesor ve profesores y alumnos, el alumno no tiene acceso
    public function usuarios()
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        if (Auth::user()->tipo == 3) {
            abort(403, 'No tienes permiso para acceder a esta página');
        }

        $usuarios = collect();

        if (Auth::user()->tipo == 1) {
            $usuarios = User::with('tipoRelacion')->get();
        }
        if (Auth::user()->tipo == 2) {
            $usuarios = User::with('tipoRelacion')->whereIn('tipo', [2,3])->get();
        }

        return view('usuarios.usuarios', compact('usuarios'));
    }

    // Muestra el formulario para crear un nuevo usuario (solo admin y profesor)
    public function create()
    {
        if (Auth::user()->tipo == 3) {
            abort(403, 'No tienes permiso para acceder a esta página');
        }
        return view('usuarios.create');
    }

    // Valida y guarda un nuevo usuario en la base de datos.
    // El profesor solo puede crear alumnos; el alumno no puede crear ningún usuario
    public function store(Request $request)
    {
        if (Auth::user()->tipo == 2 && $request->tipo == 1) {
            abort(403);
        }

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
            'must_change_password' => $request->tipo != 1 ? true : false,
        ]);

        return redirect()->route('usuarios')
            ->with('success', 'Usuario "' . $request->nombre . '" creado correctamente.');
    }

    // Muestra el formulario para que el usuario cambie su propia contraseña por primera vez.
    // Solo accesible si el flag must_change_password está activo
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

    // Procesa el cambio de contraseña propio, desactiva el flag must_change_password
    // y redirige al inicio
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

        return redirect('/inicio')
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    // Elimina un usuario de la base de datos. Solo el admin puede hacerlo
    // y no puede eliminarse a sí mismo
    public function destroy(User $usuario)
    {
        if (Auth::user()->tipo != 1) {
            abort(403, 'No tienes permiso para borrar usuarios');
        }

        if (Auth::id() == $usuario->id) {
            return redirect()->route('usuarios')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $nombre = $usuario->nombre;
        $usuario->delete();

        return redirect()->route('usuarios')
            ->with('success', 'Usuario "' . $nombre . '" eliminado correctamente.');
    }

    // Muestra los alimentos registrados por un usuario concreto.
    // Solo accesible para admin y profesor; el profesor no puede ver datos de admins
    public function verAlimentosDeUsuario(User $usuario)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->tipo == 3) {
            abort(403);
        }
        if (Auth::user()->tipo == 2 && $usuario->tipo == 1) {
            abort(403);
        }

        $alimentos = Alimento::where('user_id', (string) $usuario->id)->get();
        return view('usuarios.ver_alimentos', compact('alimentos', 'usuario'));
    }

    // Muestra las dietas de un usuario concreto con todos sus detalles nutricionales.
    // Permite seleccionar una dieta concreta mediante el parámetro dieta_id en la URL
    public function verDietasDeUsuario(User $usuario)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->tipo == 3) {
            abort(403);
        }
        if (Auth::user()->tipo == 2 && $usuario->tipo == 1) {
            abort(403);
        }

        $dietas = Dieta::where('user_id', $usuario->id)->get();

        if ($dietas->isEmpty()) {
            return redirect()->route('usuarios')
                ->with('error', '"' . $usuario->nombre . '" no tiene dietas creadas.');
        }

        $dietaId = request('dieta_id');
        $dieta = $dietaId
            ? Dieta::where('id', $dietaId)->where('user_id', $usuario->id)->firstOrFail()
            : $dietas->first();

        $alimentos_por_comida = $dieta->alimentos()->get()->groupBy('pivot.tipo_comida');
        foreach ($alimentos_por_comida as $tipo => $items) {
            $alimentos_por_comida[$tipo] = $items->sortBy('pivot.created_at');
        }

        $alimentos_usuario   = Alimento::where('user_id', (string) $usuario->id)->get();
        $kcalTotalDia        = $dieta->alimentos->sum(fn($a) => $a->pivot->peso_bruto * $a->pc * $a->e_100 / 100) * 100;
        $porcentajeAlcanzado = $dieta->objetivo > 0 ? round($kcalTotalDia / $dieta->objetivo, 2) : 0;
        $comidas             = Comida::where('dieta_id', $dieta->id)->get()->keyBy('comida');

        return view('usuarios.ver_dietas', compact(
            'dieta', 'dietas', 'alimentos_por_comida', 'alimentos_usuario',
            'porcentajeAlcanzado', 'kcalTotalDia', 'comidas', 'usuario'
        ));
    }

    // Cambia la contraseña de un usuario concreto (solo el admin puede hacerlo)
    // y activa el flag must_change_password para forzar el cambio en el próximo login
    public function cambiarPassword(Request $request, User $usuario)
    {
        if (Auth::user()->tipo != 1) {
            return redirect('/usuarios')
                ->with('error', 'No tienes permiso para cambiar contraseñas.');
        }

        $request->validate([
            'password' => 'required|min:6'
        ]);

        $usuario->update([
            'password' => Hash::make($request->password),
            'must_change_password' => true,
        ]);

        return redirect('/usuarios')
            ->with('success', 'Contraseña de "' . $usuario->nombre . '" actualizada correctamente.');
    }

    // Guarda o actualiza el comentario de retroalimentación de un profesor sobre una dieta concreta
    // y marca el comentario como no leído para notificar al alumno
    public function guardarComentario(Request $request, $dietaId)
    {
        $request->validate([
            'comentario' => 'nullable|string|max:5000',
        ]);

        $dieta = Dieta::findOrFail($dietaId);

        $dieta->comentario = $request->comentario;
        $dieta->comentario_leido = false;
        $dieta->updated_at = now();
        $dieta->save();

        return redirect()->back()
            ->with('success', 'Comentario de la dieta "' . $dieta->nombre . '" actualizado correctamente.');
    }
}