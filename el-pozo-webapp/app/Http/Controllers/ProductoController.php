<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Alergeno;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Muestra la vista para crear un nuevo producto.
     */
    public function create()
    {
        return view('productos.crear');
    }

    /**
     * Guarda un producto nuevo en la base de datos junto con su 
     * información nutricional, ingredientes, trazabilidad y alérgenos.
     */
    public function store(Request $request)
    {
        // Usamos una transacción para que si algo falla, no se cree el producto a medias
        DB::transaction(function () use ($request) {
            
            // 1. Creamos el registro base del Producto
            $producto = Producto::create([
                'nombre'     => $request->nombre,
                'ean_13'     => $request->ean_13,
                'imagen_url' => $request->imagen_url,
                'user_id'    => auth()->id(), // Vinculamos al usuario que está logueado
            ]);

            // 2. Guardamos la información nutricional (Relación hasOne)
            $producto->nutricion()->create($request->only([
                'kcal', 'grasas_totales', 'grasas_saturadas', 
                'hidratos', 'azucares', 'proteinas', 'sal'
            ]));

            // 3. Guardamos los ingredientes
            $producto->ingredientes()->create([
                'nombre' => $request->ingredientes 
            ]);

            // 4. Creamos el primer paso de trazabilidad por defecto
            $lote = $request->lote ?? 'Sin lote';
            $origen = $request->origen_materia_prima ?? 'No especificado';

            $producto->trazabilidad()->create([
                'orden'         => 1,
                'titulo'        => 'Origen y Envasado',
                'descripcion'   => "Producido en: {$origen}. Lote: {$lote}",
                'fecha_proceso' => $request->fecha_envasado ?? now(),
            ]);

            // 5. Relacionamos los alérgenos (Tabla intermedia) de forma optimizada
            if ($request->has('alergenos')) {
                // Buscamos todos los IDs de golpe en lugar de hacer un loop con consultas
                $alergenosIds = Alergeno::whereIn('nombre', $request->alergenos)->pluck('id');
                $producto->alergenos()->attach($alergenosIds);
            }
        });

        return redirect()->route('productos.catalogo')->with('info', '¡Producto creado con éxito! Ya puedes verlo en tu catálogo.');    
    }

    /**
     * Muestra el catálogo de productos según el rol del usuario.
     */
    public function index()
    {
        $user = auth()->user();

        // Seguridad básica por si alguien intenta entrar sin sesión
        if (!$user) {
            return redirect()->route('welcome')->with('error', 'Debes iniciar sesión para acceder al catálogo.');
        }

        // Cargamos los productos con sus relaciones (Eager Loading) para que la web vaya más rápida
        $query = Producto::with(['nutricion', 'alergenos']);

        if ($user->role == 'admin') {
            // El admin lo ve absolutamente todo
            $productos = $query->get();
        } else {
            // El usuario ve lo que él creó + lo que tiene en su historial de escaneos
            $productos = $query->where('user_id', $user->id)
                ->orWhereHas('usuariosHistorial', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->get();
        }

        return view('productos.catalogo', compact('productos'));
    }

    /**
     * Busca un producto por su código EAN (usado por el escáner).
     */
    public function buscarPorEan(Request $request, $ean)
    {
        $eanLimpio = trim($ean);
        $producto = Producto::where('ean_13', $eanLimpio)->first();

        if ($producto) {
            // Si el usuario está logueado y el producto no es suyo, lo añadimos a su historial
            if (auth()->check()) {
                $user = auth()->user();
                if ($producto->user_id !== $user->id) {
                    // syncWithoutDetaching evita duplicados en el historial
                    $user->historialBusquedas()->syncWithoutDetaching([$producto->id]);
                }
            }

            $url = route('productos.show', $producto->id);

            // Respondemos según el tipo de petición (AJAX o normal)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['url' => $url]);
            }

            return redirect($url);
        }

        // Si el producto no existe en la base de datos
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        return redirect()->route('escanear')->with('error', 'El producto con EAN ' . $eanLimpio . ' no existe.');
    }

    /**
     * Muestra el detalle completo de un producto.
     */
    public function show($id)
    {
        // Cargamos todas las relaciones necesarias para la vista de detalle
        $producto = Producto::with([
            'ingredientes', 
            'nutricion',
            'trazabilidad',
            'alergenos'
        ])->findOrFail($id);

        return view('productos.show', compact('producto'));
    }

    /**
     * Muestra el formulario de edición con seguridad por usuario.
     */
    public function edit($id)
    {
        $user = auth()->user();
        $producto = Producto::findOrFail($id);

        // Bloqueamos el acceso si el usuario no es dueño ni admin
        if ($user->role !== 'admin' && $producto->user_id !== $user->id) {
            return redirect()->route('productos.catalogo')->with('error', 'No tienes permiso para editar este producto.');
        }

        $alergenos = Alergeno::all();
        return view('productos.edit', compact('producto', 'alergenos'));
    }

    /**
     * Actualiza los datos del producto y sus tablas relacionadas.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        // Buscamos el producto asegurando que el usuario tiene permiso (o es admin)
        if ($user->role == 'admin') {
            $producto = Producto::findOrFail($id);
        } else {
            $producto = Producto::where('user_id', $user->id)->findOrFail($id);
        }
        
        // 1. Actualizar datos generales
        $producto->update($request->only(['nombre', 'ean_13', 'imagen_url']));

        // 2. Actualizar Nutrición (usamos updateOrCreate por seguridad)
        $producto->nutricion()->updateOrCreate(
            ['producto_id' => $producto->id],
            $request->only(['kcal', 'grasas_totales', 'grasas_saturadas', 'hidratos', 'azucares', 'proteinas', 'sal'])
        );

        // 3. Actualizar Ingredientes
        $producto->ingredientes()->updateOrCreate(
            ['producto_id' => $producto->id],
            ['nombre' => $request->ingredientes]
        );

        // 4. Sincronizar Alérgenos
        if ($request->has('alergenos')) {
            $alergenosIds = Alergeno::whereIn('nombre', $request->alergenos)->pluck('id');
            $producto->alergenos()->sync($alergenosIds);
        } else {
            // Si desmarcó todo, limpiamos la relación
            $producto->alergenos()->detach();
        }

        return redirect()->route('productos.catalogo')->with('info', '¡Producto actualizado correctamente!');
    }

    /**
     * Elimina un producto de la base de datos.
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
        // Verificación de seguridad antes de borrar
        if (auth()->user()->role != 'admin' && auth()->id() != $producto->user_id) {
            return back()->with('error', 'No tienes permiso para borrar este producto.');
        }

        $producto->delete();

        return redirect()->route('productos.catalogo')->with('success', 'Producto eliminado correctamente.');
    }
}