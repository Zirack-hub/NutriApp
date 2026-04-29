<?php

use App\Http\Controllers\AlimentosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', [AuthController::class, 'showLogin'])->name('showlogin');
Route::get('/login', [AuthController::class, 'showLogin'])->name('showlogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/inicio', [AuthController::class, 'inicio'])->name('inicio');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/usuarios', [UserController::class, 'usuarios'])->name('usuarios');
Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
Route::post('/usuarios/{usuario}/cambiar-password', [UserController::class, 'cambiarPassword'])->name('usuarios.cambiar-password');
Route::get('/alimentos', [AlimentosController::class,'mostrar'])->name('alimentos');