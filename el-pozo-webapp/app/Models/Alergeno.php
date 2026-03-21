<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergeno extends Model
{
    // Solo guardamos el nombre (ej: Gluten) y el nombre del icono
    protected $fillable = ['nombre', 'icono'];

    // Para sacar la lista de productos que contienen este alérgeno concreto
    public function productos()
    {
        // Relación inversa: muchos alérgenos en muchos productos
        return $this->belongsToMany(Producto::class, 'alergeno_producto');
    }
}