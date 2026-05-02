<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlimentosController extends Controller
{
    public function mostrar()
    {
        if(!Auth::check()){
            return redirect('/login');
        }
        $alimentos= Alimento::where('user_id', Auth::user()->id)->get();
        return view('alimentos.alimentos', compact('alimentos'));
    }

    public function create()
    {
        if(!Auth::check()){
            return redirect('/login');
        }
        return view('alimentos.create');
    }

    public function store(Request $request)
    {
        $alimento=$request->all();
        $alimento['user_id']=Auth::user()->id;
        Alimento::create($alimento);
        return redirect()->route('alimentos');
    }
}
