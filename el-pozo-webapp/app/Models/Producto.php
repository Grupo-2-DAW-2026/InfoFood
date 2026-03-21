<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Los campos que dejamos que se rellenen de golpe (Mass Assignment)
    protected $fillable = ['nombre', 'ean_13', 'imagen_url', "user_id"];

    /**
     * RELACIONES CON OTRAS TABLAS
     */

    // Relación con los valores nutricionales (calorías, grasas, etc.)
    public function nutricion()
    {
        // Un producto tiene una única tabla de nutrición
        return $this->hasOne(ValorNutricional::class, 'producto_id');
    }

    // Relación con los ingredientes del producto
    public function ingredientes()
    {
        // Un producto suele tener un ingrediente pero varios en la misma linea
        return $this->hasOne(Ingrediente::class);
    }

    // Los pasos de por dónde ha pasado el producto (trazabilidad)
    public function trazabilidad()
    {
        // Un producto tiene muchos pasos en su historia
        return $this->hasMany(TrazabilidadPaso::class, 'producto_id');
    }

    // Relación con los alérgenos (Muchos a Muchos)
    public function alergenos()
    {
        // Un producto tiene varios alérgenos y un alérgeno puede estar en varios productos
        return $this->belongsToMany(Alergeno::class, 'alergeno_producto');
    }

    // El usuario que creó o subió este producto
    public function user() 
    {
        // El producto pertenece a un usuario
        return $this->belongsTo(User::class);
    }

    // Para saber qué usuarios han escaneado o buscado este producto
    public function usuariosHistorial()
    {
        // Relación muchos a muchos para el historial de búsquedas
        return $this->belongsToMany(User::class, 'producto_user_historial');
    }
}