<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Muestra la pantalla de aviso de verificación.(NO SE USA)
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // Si el usuario ya verificó su cuenta, lo mandamos al catálogo directamente
        // Si no, le enseñamos la vista 'auth.verify-email' para que sepa que tiene que revisar su correo
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('productos.catalogo'))
                    : view('auth.verify-email');
    }
}