<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
            return redirect('/inicio');
        }
        return back()->with('error','Credenciales incorrectas');
    }

    public function inicio(){
        if(!Auth::check()){
            return redirect('/login');
        }
        return view('inicio.inicio');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    
}
