<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    protected $fillable = ['producto_id', 'nombre'];

    // Relación hacia atrás para saber de qué producto es este ingrediente
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}