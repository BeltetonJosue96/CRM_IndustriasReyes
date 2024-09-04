<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\LineaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para Producto
    Route::resource('productos', ProductoController::class);

    // Rutas para Linea
    Route::resource('lineas', LineaController::class);

    // Rutas para Modelo
    Route::resource('modelos', ModeloController::class);

    // Rutas para Departamento
    Route::resource('departamentos', DepartamentoController::class);

    // Rutas para Empresas
    Route::resource('empresas', EmpresaController::class);
});

require __DIR__.'/auth.php';
