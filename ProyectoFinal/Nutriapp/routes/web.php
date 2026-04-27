<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLogin'])->name('showlogin');
Route::get('/login', [AuthController::class, 'showLogin'])->name('showlogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/inicio', [AuthController::class, 'inicio'])->name('inicio');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');