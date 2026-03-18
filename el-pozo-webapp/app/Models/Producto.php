<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'ean_13', 'imagen_url'];

    public function nutricion()
    {
        return $this->hasOne(ValorNutricional::class, 'producto_id');
    }

    public function ingredientes()
    {
    return $this->hasOne(Ingrediente::class, 'producto_id');
    }

    public function trazabilidad()
    {
    return $this->hasMany(TrazabilidadPaso::class, 'producto_id');
    }

    public function alergenos()
    {
        return $this->belongsToMany(Alergeno::class, 'alergeno_producto');
    }
}
