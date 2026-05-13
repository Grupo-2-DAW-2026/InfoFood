<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registro de servicios internos. 
     * Aquí no solemos tocar nada a menos que usemos librerías muy raras.
     */
    public function register(): void
    {
        //
    }

    /**
     * Configuración de arranque (Boot).
     * Todo lo que pongas aquí se ejecuta cada vez que cargues una página.
     */
    public function boot(): void
    {

        // OPTIMIZACIÓN 1: Configuramos el idioma de las fechas a español
        // Así, cuando pongas una fecha en tu trazabilidad, saldrá "Lunes" en vez de "Monday".
        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES.utf8');

        if (config('app.env') === 'production') {
        \URL::forceScheme('https');
        }
    }
}