<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Envía un nuevo enlace de verificación por email.(NO SE USA)
     */
    public function store(Request $request): RedirectResponse
    {
        // Si el usuario ya está verificado, no le enviamos nada y lo mandamos dentro
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('productos.catalogo'));
        }

        // Si no, le enviamos la notificación (el email con el botón)
        $request->user()->sendEmailVerificationNotification();

        // Volvemos atrás avisando de que el enlace ha sido enviado
        return back()->with('status', 'verification-link-sent');
    }
}