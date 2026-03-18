<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TrazabilidadController;
use Illuminate\Support\Facades\Route;

// 1. RUTAS PÚBLICAS (Cualquiera accede, incluso sin login)
Route::get('/', function () {
    return view('welcome');
})->name("welcome");

Route::get('/escaner', function () {
    return view('escaner');
})->name('escaner');

// Búsqueda por EAN y Ver Ficha (Públicos para invitados)
Route::get('/buscar-producto/{ean}', [ProductoController::class, 'buscarPorEan'])->name('productos.buscar');
Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('productos.show');


// 2. RUTAS PROTEGIDAS (Solo para usuarios logueados)
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Catálogo (lo movemos aquí para que solo lo vean usuarios registrados)
    Route::get('/catalogo', [ProductoController::class, 'index'])->name('productos.catalogo');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de Productos (Ya NO usamos Route::resource para no liarla)
    Route::get('/productos/nuevoProducto', [ProductoController::class, 'create'])->name('productos.crear');
    Route::post('/productos/guardarProducto', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Trazabilidad
    Route::post('/trazabilidad', [TrazabilidadController::class, 'store'])->name('trazabilidad.store');
    Route::delete('/trazabilidad/{id}', [TrazabilidadController::class, 'destroy'])->name('trazabilidad.destroy');
});

// 3. RUTAS DE AUTENTICACIÓN (Login, Register, Password Reset)
// Esta línea carga automáticamente 'password.store', 'register', etc., desde auth.php
require __DIR__.'/auth.php';