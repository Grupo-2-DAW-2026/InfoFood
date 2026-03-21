<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Implementamos MustVerifyEmail para que Laravel obligue a confirmar el correo
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // Campos que se pueden rellenar al crear el usuario
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Añadido el rol por si diferenciamos entre admin y usuario normal
    ];

    // Datos que no queremos que se vean al convertir el modelo a JSON o Array
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Esto convierte campos de la BD a formatos de PHP (ej: fechas a objetos Carbon)
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Importante para que la clave se guarde cifrada
        ];
    }

    /**
     * RELACIONES
     */

    // Productos que este usuario ha registrado en el sistema
    public function productos() 
    {
        return $this->hasMany(Producto::class);
    }

    // Lista de productos que el usuario ha consultado (su historial)
    public function historialBusquedas()
    {
        // Usamos la tabla intermedia 'producto_user_historial'
        return $this->belongsToMany(Producto::class, 'producto_user_historial');
    }
}