<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergeno extends Model
{
    protected $fillable = ['nombre', 'icono'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'alergeno_producto');
    }
}
