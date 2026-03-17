<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValorNutricional extends Model
{
    protected $table = 'valores_nutricionales';

    protected $fillable = [
        'producto_id', 'kcal', 'grasas_totales', 'grasas_saturadas', 
        'hidratos', 'azucares', 'proteinas', 'sal'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
