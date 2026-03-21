<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValorNutricional extends Model
{
    // Le decimos a Laravel cómo se llama la tabla exactamente porque no es el plural estándar
    protected $table = 'valores_nutricionales';

    // Todos los campos de la tabla nutricional
    protected $fillable = [
        'producto_id', 'kcal', 'grasas_totales', 'grasas_saturadas', 
        'hidratos', 'azucares', 'proteinas', 'sal'
    ];

    // Para volver desde los valores al producto al que pertenecen
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}