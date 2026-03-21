<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TrazabilidadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS (Accesibles sin iniciar sesión)
|--------------------------------------------------------------------------
*/

// Página de inicio del sitio
Route::get('/', function () {
    return view('welcome');
})->name("welcome");

// Sección del escáner de códigos de barras
Route::get('/escaner', function () {
    return view('escaner');
})->name('escaner');

// Visualización del catálogo de productos
Route::get('/catalogo', [ProductoController::class, 'index'])->name('productos.catalogo');

// Búsqueda de producto por EAN (usada por el escáner)
Route::get('/buscar-producto/{ean}', [ProductoController::class, 'buscarPorEan'])->name('productos.buscar');


/*
|--------------------------------------------------------------------------
| 2. RUTAS PROTEGIDAS (Requieren estar Autenticado)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // Bloque Dashboard: Redirige al panel de control/perfil del usuario
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');

    // --- BLOQUE PERFIL DE USUARIO ---
    // Muestra la tarjeta de perfil personalizada
    Route::get('/profile/panel', [ProfileController::class, 'index'])->name('profile.index');
    // Muestra el formulario de edición de datos (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Procesa la actualización de los datos del perfil
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // --- BLOQUE GESTIÓN DE PRODUCTOS ---
    // IMPORTANTE: Estas rutas fijas deben ir ANTES de cualquier ruta con {id}
    // Formulario para crear un producto nuevo
    Route::get('/productos/nuevoProducto', [ProductoController::class, 'create'])->name('productos.crear');
    // Guardar el nuevo producto en la base de datos
    Route::post('/productos/guardarProducto', [ProductoController::class, 'store'])->name('productos.store');
    
    // Formulario para editar un producto existente
    Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    // Actualizar los datos del producto
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
    // Eliminar un producto del sistema
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // --- BLOQUE TRAZABILIDAD ---
    // Añadir un nuevo hito a la línea de tiempo del producto
    Route::post('/trazabilidad', [TrazabilidadController::class, 'store'])->name('trazabilidad.store');
    // Eliminar un paso de la trazabilidad
    Route::delete('/trazabilidad/{id}', [TrazabilidadController::class, 'destroy'])->name('trazabilidad.destroy');
});

/*
|--------------------------------------------------------------------------
| 3. RUTAS CON PARÁMETROS DINÁMICOS (Al final para evitar conflictos)
|--------------------------------------------------------------------------
*/

// Detalle de un producto específico 
// Se coloca aquí para que no "se coma" a /productos/nuevoProducto
Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('productos.show');


/*
|--------------------------------------------------------------------------
| 4. RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
// Importamos las rutas de login, registro y contraseñas de Breeze
require __DIR__.'/auth.php';