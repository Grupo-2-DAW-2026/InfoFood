<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alergeno;

class AlergenosSeeder extends Seeder
{
    /**
     * Ejecuta el llenado de la tabla de alérgenos.
     */
    public function run(): void
    {
        // Listado oficial de los 14 alérgenos de declaración obligatoria
        $alergenos = [
            'Gluten', 'Crustáceos', 'Huevos', 'Pescado', 'Cacahuetes', 
            'Soja', 'Lácteos', 'Frutos de cáscara', 'Apio', 'Mostaza', 
            'Sésamo', 'Sulfitos', 'Altramuces', 'Moluscos'
        ];

        foreach ($alergenos as $nombre) {
            // Usamos firstOrCreate para que si el alérgeno ya existe, no lo duplique
            // y así evitar errores de clave única.
            Alergeno::firstOrCreate([
                'nombre' => $nombre,
                'icono' => strtolower($nombre) . '.png' // Preparamos el nombre del archivo del icono
            ]);
        }
    }
}