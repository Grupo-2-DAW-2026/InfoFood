<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    protected $fillable = ['producto_id', 'nombre'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
