<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlimentosController extends Controller
{
    public function mostrar()
    {
        $alimentos= Alimento::where('id', Auth::user()->id);
        return view('alimentos.alimentos', compact('alimentos'));
    }
}
