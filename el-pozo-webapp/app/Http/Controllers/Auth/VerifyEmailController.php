<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Marca la dirección de email del usuario como verificada.(NO SE USA)
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // 1. Si ya estaba verificado de antes, no hacemos nada y lo mandamos al catálogo
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('productos.catalogo').'?verified=1');
        }

        // 2. Si no estaba verificado, marcamos el campo 'email_verified_at' en la BD
        if ($request->user()->markEmailAsVerified()) {
            // Lanzamos un evento de Laravel por si queremos hacer algo cuando alguien se verifica
            event(new Verified($request->user()));
        }

        // 3. Lo mandamos al catálogo con un aviso en la URL de que todo ha ido bien
        return redirect()->intended(route('productos.catalogo').'?verified=1');
    }
}