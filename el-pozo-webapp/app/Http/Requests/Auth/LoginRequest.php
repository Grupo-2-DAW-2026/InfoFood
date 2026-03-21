<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determina si el usuario tiene permiso.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas básicas: email válido y contraseña obligatoria.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Intenta autenticar al usuario.
     */
    public function authenticate(): void
    {
        // 1. Mira si el usuario ha fallado demasiadas veces seguidas
        $this->ensureIsNotRateLimited();

        // 2. Intenta hacer el login con el email y el password
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Si falla, suma un "punto de fallo" al limitador
            RateLimiter::hit($this->throttleKey());

            // Lanza el error de "Credenciales incorrectas"
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // 3. Si entra bien, borra el contador de fallos
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Controla que no se pasen de intentos (5 intentos máximo).
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        // Si se pasa, bloqueamos el acceso y avisamos
        event(new Lockout($this));
        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Genera una clave única por usuario para el limitador de intentos.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}