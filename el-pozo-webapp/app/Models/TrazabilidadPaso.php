<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrazabilidadPaso extends Model
{
    // Nombre de la tabla manual
    protected $table = 'trazabilidad_pasos';

    // Guardamos el orden del paso, título, descripción y la fecha en la que ocurrió
    protected $fillable = ['producto_id', 'orden', 'titulo', 'descripcion', 'fecha_proceso'];

    //Relación inversa con el modelo Producto. Indica que este paso de trazabilidad pertenece a un producto específico.
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}