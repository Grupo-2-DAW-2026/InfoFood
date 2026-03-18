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
        if (!auth()->check()) {
        return redirect()->route('welcome')->with('error', 'Debes iniciar sesión para consultar el catálogo de productos.');
        }
        
        $productos = Producto::with(['nutricion', 'alergenos'])->get();
        return view('productos.catalogo', compact('productos'));
    }

    public function buscarPorEan($ean)
    {
    $producto = Producto::where('ean_13', $ean)->first();

    if ($producto) {
        // Si lo encuentra, lo mandamos a su ficha (que haremos luego)
        return response()->json(['url' => route('productos.show', $producto->id)]);
    }

    
    return response()->json(['error' => 'Producto no encontrado'], 404);
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
}