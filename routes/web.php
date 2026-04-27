<?php


use App\Http\Controllers\CanchaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Vista de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Rutas protegidas (Solo para usuarios logueados)
Route::middleware('auth')->group(function () {
    
    // Pestaña Principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Módulo de Canchas
    Route::get('/canchas/crear', [CanchaController::class, 'create'])->name('canchas.create');
    Route::post('/canchas', [CanchaController::class, 'store'])->name('canchas.store');
    
    // Si quieres conservar la edición de perfil (opcional)
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
});


// En web.php, añade esto fuera del middleware 'auth'
Route::get('/login', function() { return view('auth.login'); })->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// routes/web.php

Route::get('/dashboard', [CanchaController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/auth.php';
