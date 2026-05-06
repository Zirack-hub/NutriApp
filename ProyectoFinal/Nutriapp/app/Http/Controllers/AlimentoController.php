<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlimentoController extends Controller
{

    //Función para mostrar los alimentos
    public function mostrar()
    {
        //Si no está la sesión iniciada, se manda a la página de login
        if(!Auth::check()){
            return redirect('/login');
        }

        //Con Eloquent, obligo a que los alimentos que recoja tengan el mismo id que el usuario de la sesión
        //En el return devuelvo la vista de alimentos y la agrupación de los alimentos
        $alimentos= Alimento::where('user_id', Auth::user()->id)->get();
        return view('alimentos.alimentos', compact('alimentos'));
    }

    //Función para redirigir a la vista de crear alimentos 
    public function create()
    {
        if(!Auth::check()){
            return redirect('/login');
        }
        return view('alimentos.create');
    }

    //Función encargada de guardar el alimento introducido
    public function store(Request $request)
    {
        $alimento=$request->all();
        //Por mayor seguridad, el id es introducido aquí y no en la vista
        $alimento['user_id']=Auth::user()->id;
        Alimento::create($alimento);
        return redirect()->route('alimentos');
    }
}
