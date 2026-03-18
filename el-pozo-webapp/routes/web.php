<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TrazabilidadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("welcome");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/escaner', function () {
    return view('escaner');
})->name('escaner');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/productos/nuevoProducto', [ProductoController::class, 'create'])->name('productos.crear');
    Route::post('/productos/guardarProducto', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::post('/trazabilidad', [TrazabilidadController::class, 'store'])->name('trazabilidad.store');
    Route::resource('productos', ProductoController::class);
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});

Route::get('/catalogo', [ProductoController::class, 'index'])->name('productos.catalogo');

Route::get('/buscar-producto/{ean}', [ProductoController::class, 'buscarPorEan']);

Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('productos.show');

require __DIR__.'/auth.php';
