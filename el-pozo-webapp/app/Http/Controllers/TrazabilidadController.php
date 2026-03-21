<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrazabilidadPaso;

class TrazabilidadController extends Controller
{
    /**
     * Guarda un nuevo paso en la historia/trazabilidad del producto.
     */
    public function store(Request $request)
    {
        // Validamos que los datos que llegan del formulario sean correctos
        $request->validate([
            'titulo'      => 'required|string|max:255',
            'orden'       => 'required|integer',
            'producto_id' => 'required|exists:productos,id',
            'descripcion' => 'required|string',
        ]);

        // Guardamos el nuevo paso. 
        // OPTIMIZACIÓN: Usamos el modelo importado arriba para que el código sea más limpio.
        TrazabilidadPaso::create([
            'producto_id'   => $request->producto_id,
            'titulo'        => $request->titulo,
            'descripcion'   => $request->descripcion,
            'orden'         => $request->orden,
            'fecha_proceso' => now(), // Registramos el momento exacto de la creación
        ]);

        return back()->with('success', 'Paso de trazabilidad añadido correctamente.');
    }

    /**
     * Elimina un paso y reajusta el orden de los demás.
     */
    public function destroy($id)
    {
        // Buscamos el paso que queremos borrar o lanzamos error 404 si no existe
        $pasoABorrar = TrazabilidadPaso::findOrFail($id);
        $productoId = $pasoABorrar->producto_id;

        // 1. Borramos el paso seleccionado
        $pasoABorrar->delete();

        // 2. REORDENACIÓN AUTOMÁTICA: 
        // Esto evita que si borras el paso 2, la lista pase del 1 al 3.
        // Recuperamos los pasos que quedan ordenados por su número de orden actual.
        $pasosRestantes = TrazabilidadPaso::where('producto_id', $productoId)
                            ->orderBy('orden')
                            ->get();

        // Recorremos los pasos y les asignamos un nuevo número correlativo (1, 2, 3...)
        foreach ($pasosRestantes as $index => $paso) {
            $paso->update([
                'orden' => $index + 1
            ]);
        }

        return back()->with('info', 'Paso eliminado y cronología actualizada.');
    }
}