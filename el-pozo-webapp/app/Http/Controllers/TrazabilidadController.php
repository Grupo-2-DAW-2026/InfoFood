<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrazabilidadController extends Controller
{
    public function store(Request $request)
    {
    $request->validate([
        'titulo' => 'required|string|max:255',
        'orden' => 'required|integer',
        'producto_id' => 'required|exists:productos,id',
        'descripcion' => 'required|string',
    ]);

    // Aquí guardas el nuevo paso en la base de datos
    \App\Models\TrazabilidadPaso::create($request->all());

    return back()->with('success', 'Paso de trazabilidad añadido correctamente.');
    }

    public function destroy($id)
    {
    $pasoABorrar = \App\Models\TrazabilidadPaso::findOrFail($id);
    $productoId = $pasoABorrar->producto_id;

    // 1. Borrar el paso
    $pasoABorrar->delete();

    // 2. Reordenar los pasos restantes para que sean correlativos (1, 2, 3...)
    $pasosRestantes = \App\Models\TrazabilidadPaso::where('producto_id', $productoId)
                        ->orderBy('orden')
                        ->get();

    foreach ($pasosRestantes as $index => $paso) {
        $paso->update(['orden' => $index + 1]);
    }

    return back()->with('info', 'Paso eliminado y cronología actualizada.');
    }
}
