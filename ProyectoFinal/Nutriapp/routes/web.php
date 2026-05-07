<?php

use App\Http\Controllers\AlimentoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DietaController;
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
Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');

Route::get('/alimentos', [AlimentoController::class, 'mostrar'])->name('alimentos');
Route::get('/alimentos/create', [AlimentoController::class, 'create'])->name('alimentos.create');
Route::post('/alimentos', [AlimentoController::class, 'store'])->name('alimentos.store');
Route::get('/alimentos/edit/{alimento}', [AlimentoController::class, 'edit'])->name('alimentos.edit');
Route::put('/alimentos/update/{alimento}', [AlimentoController::class, 'update'])->name('alimentos.update');
Route::delete('/alimentos/destroy/{alimento}', [AlimentoController::class, 'destroy'])->name('alimentos.destroy');

Route::get('/dietas', [DietaController::class, 'mostrarDietas'])->name('dietas');
Route::get('/dietas/create', [DietaController::class, 'createDieta'])->name('dietas.create');
Route::post('/dietas', [DietaController::class, 'storeDieta'])->name('dietas.store');
Route::get('/dietas/{id}', [DietaController::class, 'mostrarDieta'])->name('dietas.show');
Route::post('/dietas/{id}/alimentos', [DietaController::class, 'agregarAlimento'])->name('dietas.alimentos.agregar');
Route::delete('/dietas/{id}/alimentos', [DietaController::class, 'eliminarAlimento'])->name('dietas.alimentos.eliminar');