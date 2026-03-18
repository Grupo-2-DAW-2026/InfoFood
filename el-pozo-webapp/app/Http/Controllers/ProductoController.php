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
        $producto->trazabilidad()->create([
            'orden'         => 1,
            'titulo'        => 'Origen y Envasado',
            'descripcion'   => "Producido en: {$request->origen_materia_prima}. Lote: {$request->lote}",
            'fecha_proceso' => $request->fecha_envasado,
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

        return redirect('/')->with('success', 'Producto registrado correctamente en InfoFood');
    }

    public function index()
    {
    
    $user = auth()->user();

    // Si no está logueado, redirigir al login con un mensaje informativo
    if (!$user) {
        return redirect()->route('welcome')->with('error', 'Debes iniciar sesión para acceder al catálogo.');
    }
    if ($user->role == 'admin') {
        $productos = Producto::with(['nutricion', 'alergenos'])->get();
    } else {
        // Traer mis productos O los que he buscado (historial)
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
        $producto = Producto::where('user_id', auth()->id())->findOrFail($id);
        
        // Actualizar datos básicos
        $producto->update($request->only(['nombre', 'ean_13', 'imagen_url']));

        // Actualizar Nutrición
        $producto->nutricion()->update($request->only(['kcal', 'grasas_totales', 'grasas_saturadas', 'hidratos', 'azucares', 'proteinas', 'sal']));

        // Actualizar Ingredientes
        $producto->ingredientes()->update(['nombre' => $request->ingredientes]);

        // Actualizar Alérgenos
        $producto->alergenos()->sync($request->alergenos_ids); // Asumiendo que mandas IDs de alérgenos

        return redirect()->route('productos.catalogo')->with('success', 'Producto actualizado');
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