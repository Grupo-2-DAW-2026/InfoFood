<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Semilla principal de la aplicación.
     */
    public function run(): void
    {
        // 1. Llamamos al seeder de alérgenos para tener el catálogo listo
        $this->call([
            AlergenosSeeder::class,
        ]);
    }
}