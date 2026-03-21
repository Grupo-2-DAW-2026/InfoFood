<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Alergeno;

class ProductoController extends Controller
{
    public function create()
    {
        return view('productos.crear');
    }

    public function store(Request $request)
    {
        // 1. Crear el Producto base
        $producto = Producto::create([
            'nombre'     => $request->nombre,
            'ean_13'     => $request->ean_13,
            'imagen_url' => $request->imagen_url,
            'user_id'    => auth()->id(), // <--- IMPORTANTE
        ]);

        // 2. Guardar Nutrición (Relación: nutricion)
        $producto->nutricion()->create([
            'kcal'             => $request->kcal,
            'grasas_totales'   => $request->grasas_totales,
            'grasas_saturadas' => $request->grasas_saturadas,
            'hidratos'         => $request->hidratos,
            'azucares'         => $request->azucares,
            'proteinas'        => $request->proteinas,
            'sal'              => $request->sal,
        ]);

        // 3. Guardar Ingredientes (Campo 'nombre' en tu migración)
        $producto->ingredientes()->create([
            'nombre' => $request->ingredientes 
        ]);

        // 4. Guardar Trazabilidad (Tabla trazabilidad_pasos)
        $lote = $request->lote ?? 'Sin lote';
        $origen = $request->origen_materia_prima ?? 'No especificado';

        $producto->trazabilidad()->create([
            'orden'         => 1,
            'titulo'        => 'Origen y Envasado',
            'descripcion'   => "Producido en: {$origen}. Lote: {$lote}",
            'fecha_proceso' => $request->fecha_envasado ?? now(),
        ]);

        // 5. Relacionar Alérgenos (Tabla pivote alergeno_producto)
        if ($request->has('alergenos')) {
            foreach ($request->alergenos as $nombreAlergeno) {
                $alergeno = Alergeno::where('nombre', $nombreAlergeno)->first();
                if ($alergeno) {
                    $producto->alergenos()->attach($alergeno->id);
                }
            }
        }

        return redirect()->route('productos.catalogo')->with('info', '¡Producto creado con éxito! Ya puedes verlo en tu catálogo.');    
    }

    public function index()
    {
    $user = auth()->user();

    // Si no está logueado, redirigir a la welcome con el mensaje de error
    if (!$user) {
        return redirect()->route('welcome')->with('error', 'Debes iniciar sesión para acceder al catálogo.');
    }

    // Lógica original: Si es admin ve todo, si no, ve lo suyo + historial
    if ($user->role == 'admin') {
        $productos = Producto::with(['nutricion', 'alergenos'])->get();
    } else {
        $productos = Producto::with(['nutricion', 'alergenos'])
            ->where('user_id', $user->id)
            ->orWhereHas('usuariosHistorial', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->get();
    }

    return view('productos.catalogo', compact('productos'));
    }

   public function buscarPorEan(Request $request, $ean)
    {
    $eanLimpio = trim($ean);
    $producto = \App\Models\Producto::where('ean_13', $eanLimpio)->first();

    if ($producto) {
        // Registrar historial si está logueado
        if (auth()->check()) {
            $user = auth()->user();
            if ($producto->user_id !== $user->id) {
                $user->historialBusquedas()->syncWithoutDetaching([$producto->id]);
            }
        }

        $url = route('productos.show', $producto->id);

        // SI LA PETICIÓN ES POR FETCH/AJAX (Desde el JS del escáner)
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['url' => $url]);
        }

        // SI ES UNA PETICIÓN NORMAL
        return redirect($url);
    }

    // Si no existe
    if ($request->expectsJson() || $request->ajax()) {
        return response()->json(['error' => 'No encontrado'], 404);
    }

    return redirect()->route('escanear')->with('error', 'El producto con EAN ' . $eanLimpio . ' no existe.');
    }

    public function show($id)
    {
    // Usamos exactamente los nombres que definiste en tu modelo Producto
    $producto = \App\Models\Producto::with([
        'ingredientes', 
        'nutricion',     // Antes tenías 'valoresNutricionales'
        'trazabilidad',  // Antes tenías 'trazabilidadPasos'
        'alergenos'
    ])->findOrFail($id);

    return view('productos.show', compact('producto'));
    }

    public function edit($id)
    {
    $user = auth()->user();
    
    // Buscamos el producto
    $producto = Producto::findOrFail($id);

    // Seguridad: Si NO eres admin y el producto NO es tuyo, bloqueamos el acceso
    if ($user->role !== 'admin' && $producto->user_id !== $user->id) {
        return redirect()->route('productos.catalogo')->with('error', 'No tienes permiso para editar este producto.');
    }

    $alergenos = Alergeno::all();
    return view('productos.edit', compact('producto', 'alergenos'));
    }

    public function update(Request $request, $id)
    {
    $user = auth()->user();

    // --- PUNTO CLAVE: Lógica de búsqueda con permisos ---
    
    if ($user->role == 'admin') {
        // 1. Si eres Admin, búscalo globalmente (cualquier dueño)
        $producto = Producto::findOrFail($id);
    } else {
        // 2. Si eres Usuario, búscalo SOLO si te pertenece
        $producto = Producto::where('user_id', $user->id)->findOrFail($id);
    }
    
    // Si llega aquí, significa que se ha encontrado el producto con los permisos correctos.
    // Si no, failOrFail() habrá lanzado el 404 (para el usuario que no es dueño).

    // --- Resto de la actualización (el código que ya tenías) ---
    
    // Actualizar datos básicos
    $producto->update($request->only(['nombre', 'ean_13', 'imagen_url']));

    // Actualizar Nutrición (aseguramos que exista la relación, o el update fallará si es nula en DB)
    if($producto->nutricion) {
        $producto->nutricion()->update($request->only(['kcal', 'grasas_totales', 'grasas_saturadas', 'hidratos', 'azucares', 'proteinas', 'sal']));
    }

    // Actualizar Ingredientes (aseguramos que exista)
    if($producto->ingredientes) {
        $producto->ingredientes()->update(['nombre' => $request->ingredientes]);
    }

    if ($request->has('alergenos')) {
        // Buscamos los IDs de esos nombres de alérgenos para poder sincronizar
        $alergenosIds = \App\Models\Alergeno::whereIn('nombre', $request->alergenos)->pluck('id');
        $producto->alergenos()->sync($alergenosIds);
    } else {
        // Si no mandó ningún checkbox, vaciamos la lista de alérgenos del producto
        $producto->alergenos()->detach();
    }

    // Redirigir al catálogo con un mensaje de éxito azul (info)
    return redirect()->route('productos.catalogo')->with('info', '¡Producto actualizado correctamente!');
    }

    public function destroy($id)
    {
    $producto = \App\Models\Producto::findOrFail($id);
    
    // Opcional: Verificar que solo el dueño o el admin borren
    if (auth()->user()->role != 'admin' && auth()->id() != $producto->user_id) {
        return back()->with('error', 'No tienes permiso para borrar este producto.');
    }

    $producto->delete();

    // Redirigir al catálogo con un mensaje de éxito
    return redirect()->route('productos.catalogo')->with('success', 'Producto eliminado correctamente.');
    }
}