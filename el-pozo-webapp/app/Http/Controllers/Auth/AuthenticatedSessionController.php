<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // Muestra la pantalla de Login
    public function create(): View
    {
        return view('auth.login');
    }

    // Procesa el intento de entrar a la web
    public function store(LoginRequest $request): RedirectResponse
    {
        // Comprueba si el email y la clave son correctos
        $request->authenticate();

        // Regenera la sesión para evitar ataques de seguridad
        $request->session()->regenerate();

        // Te manda al catálogo o a donde intentaras entrar antes
        return redirect()->intended(route('welcome'));
    }

    // Cierra la sesión (Log out)
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}