<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DenunciaController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


    // Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/json', [UsuarioController::class, 'getUsuarios'])->name('usuarios.json');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    Route::get('/usuarios/export', [UsuarioController::class, 'export'])->name('usuarios.export');
    Route::post('/usuarios/import', [UsuarioController::class, 'import'])->name('usuarios.import');

    // Denuncias
    Route::get('/denuncias', [DenunciaController::class, 'index'])->name('denuncias.index');
    Route::get('/denuncias/json', [DenunciaController::class, 'getDenuncias'])->name('denuncias.json');
    Route::post('/denuncias', [DenunciaController::class, 'store'])->name('denuncias.store');
    Route::put('/denuncias/{denuncia}', [DenunciaController::class, 'update'])->name('denuncias.update');
    Route::delete('/denuncias/{denuncia}', [DenunciaController::class, 'destroy'])->name('denuncias.destroy');
    Route::get('/denuncias/export', [DenunciaController::class, 'export'])->name('denuncias.export');
    Route::post('/denuncias/import', [DenunciaController::class, 'import'])->name('denuncias.import');

});
