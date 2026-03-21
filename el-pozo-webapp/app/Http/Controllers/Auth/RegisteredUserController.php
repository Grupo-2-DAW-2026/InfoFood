<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // Muestra el formulario de registro
    public function create(): View
    {
        return view('auth.register');
    }

    // Crea el nuevo usuario en la base de datos
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Por defecto todos son usuarios normales
        ]);

        // Dispara el evento de "Usuario Registrado" (para que se envíe el email)
        event(new Registered($user));

        // Lo loguea automáticamente tras registrarse
        Auth::login($user);

        return redirect(route('productos.catalogo'));
    }
}