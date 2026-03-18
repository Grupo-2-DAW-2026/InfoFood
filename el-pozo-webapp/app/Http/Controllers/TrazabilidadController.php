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
}
