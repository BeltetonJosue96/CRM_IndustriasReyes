<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\LineaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\PlanMantoController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\ControlDeMantoController;
use App\Http\Controllers\DetalleCheckController;
use App\Http\Controllers\HistorialMantoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Para registro de nuevos usuarios
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Rutas para Modulos
    Route::resource('productos', ProductoController::class)->parameters([
        'productos' => 'hashedId'
    ]);
    Route::resource('lineas', LineaController::class)->parameters([
        'lineas' => 'hashedId'
    ]);
    Route::resource('modelos', ModeloController::class)->parameters([
        'modelos' => 'hashedId'
    ]);
    Route::resource('departamentos', DepartamentoController::class)->parameters([
        'departamentos' => 'hashedId'
    ]);
    Route::resource('empresas', EmpresaController::class)->parameters([
        'empresas' => 'hashedId'
    ]);
    Route::resource('clientes', ClienteController::class)->parameters([
        'clientes' => 'hashedId'
    ]);
    Route::resource('ventas', VentaController::class)->parameters([
        'ventas' => 'hashedId'
    ]);
    Route::resource('planes', PlanMantoController::class)->parameters([
        'planes' => 'hashedId'
    ]);
    // Define la ruta 'create' manualmente con el hashedId
    Route::get('/detalle_ventas/create/{hashedId}', [DetalleVentaController::class, 'create'])->name('detalle_ventas.create');
    Route::resource('detalle_ventas', DetalleVentaController::class)->except(['create','show']);

    Route::resource('checklist', ChecklistController::class)->parameters([
        'checklist' => 'hashedId'
    ]);
    Route::resource('estados', EstadoController::class)->parameters([
        'estados' => 'hashedId'
    ]);
    Route::resource('controlmantos', ControlDeMantoController::class);

    Route::resource('detallecheck', DetalleCheckController::class)->parameters([
        'detallecheck' => 'hashedId'
    ]);
    Route::get('/detallecheck/create/{hashedId}', [DetalleCheckController::class, 'create'])->name('detallecheck.create');
    Route::post('/detallecheck/store/{hashedId}', [DetalleCheckController::class, 'store'])->name('detallecheck.store');

    Route::resource('historial', HistorialMantoController::class);
    Route::get('/config', function () {
        return view('config');
    })->name('config');
});

require __DIR__.'/auth.php';
