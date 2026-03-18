<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlergenosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $alergenos = ['Gluten', 'Crustáceos', 'Huevos', 'Pescado', 'Cacahuetes', 'Soja', 'Lácteos', 'Frutos de cáscara', 'Apio', 'Mostaza', 'Sésamo', 'Sulfitos', 'Altramuces', 'Moluscos'];

    foreach ($alergenos as $nombre) {
        \App\Models\Alergeno::firstOrCreate(['nombre' => $nombre]);
    }
    }
}
