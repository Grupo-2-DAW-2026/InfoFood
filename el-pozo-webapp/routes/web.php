<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TrazabilidadController;
use Illuminate\Support\Facades\Route;

// 1. RUTAS PÚBLICAS (Home y Escáner)
Route::get('/', function () {
    return view('welcome');
})->name("welcome");

Route::get('/escaner', function () {
    return view('escaner');
})->name('escaner');

// 2. RUTAS DE PRODUCTOS (ORDEN CRÍTICO PARA EVITAR 404)
// Primero las fijas
Route::get('/catalogo', [ProductoController::class, 'index'])->name('productos.catalogo');
Route::get('/buscar-producto/{ean}', [ProductoController::class, 'buscarPorEan'])->name('productos.buscar');

// Rutas de creación (Deben ir ANTES que la de {id})
Route::middleware('auth')->group(function () {
    Route::get('/productos/nuevoProducto', [ProductoController::class, 'create'])->name('productos.crear');
    Route::post('/productos/guardarProducto', [ProductoController::class, 'store'])->name('productos.store');
});

// AHORA SÍ, la ruta con parámetro {id} al final de las de productos
Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('productos.show');


// 3. RESTO DE RUTAS PROTEGIDAS
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Edición y Borrado
    Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Trazabilidad
    Route::post('/trazabilidad', [TrazabilidadController::class, 'store'])->name('trazabilidad.store');
    Route::delete('/trazabilidad/{id}', [TrazabilidadController::class, 'destroy'])->name('trazabilidad.destroy');
});

require __DIR__.'/auth.php';