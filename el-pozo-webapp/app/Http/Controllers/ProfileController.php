<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario para que el usuario edite su perfil.
     */
    public function edit(Request $request): View
    {
        // Retornamos la vista de edición pasando los datos del usuario actual
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualiza la información básica del perfil (Nombre y Email).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Rellenamos el modelo con los datos ya validados del formulario
        $request->user()->fill($request->validated());

        // OPTIMIZACIÓN: Si el usuario cambia su correo, tenemos que invalidar 
        // la verificación anterior para que tenga que confirmar el nuevo email.
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Guardamos los cambios en la base de datos
        $request->user()->save();

        // Redirigimos atrás con un mensaje de estado para mostrar un aviso de "Guardado"
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Muestra la vista principal del perfil (la tarjeta con avatar).
     */
    public function index(Request $request): View
    {
        // Esta función simplemente devuelve la vista con los datos del usuario logueado
        return view('dashboard', [
            'user' => $request->user(),
        ]);
    }
}