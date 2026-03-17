<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrazabilidadPaso extends Model
{
    protected $table = 'trazabilidad_pasos';

    protected $fillable = ['producto_id', 'orden', 'titulo', 'descripcion', 'fecha_proceso'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
