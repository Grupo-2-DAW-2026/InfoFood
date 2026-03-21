<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Indica si el usuario está autorizado a hacer esta petición.
     */
    public function authorize(): bool
    {
        return true; // Cualquiera logueado puede intentar actualizar su perfil
    }

    /**
     * Reglas de validación para el nombre y el correo.
     */
    public function rules(): array
    {
        return [
            // El nombre es obligatorio, texto y máximo 255 caracteres
            'name' => ['required', 'string', 'max:255'],

            // El email es obligatorio, formato email y máximo 255
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                // Regla especial: el email debe ser único en la tabla 'users', 
                // PERO ignoramos el ID del propio usuario para que pueda guardar sin cambiar su email.
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}