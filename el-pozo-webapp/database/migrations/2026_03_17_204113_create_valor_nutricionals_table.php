<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    // Información detallada por cada 100g/ml
    Schema::create('valores_nutricionales', function (Blueprint $table) {
        $table->id();
        // Vinculación con el producto. Si el producto se borra, sus valores también (cascade)
        $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
        
        // Definición numérica: 8 dígitos en total, 2 de ellos decimales
        $table->decimal('kcal', 8, 2)->default(0);
        $table->decimal('grasas_totales', 8, 2)->default(0);
        $table->decimal('grasas_saturadas', 8, 2)->default(0);
        $table->decimal('hidratos', 8, 2)->default(0);
        $table->decimal('azucares', 8, 2)->default(0);
        $table->decimal('proteinas', 8, 2)->default(0);
        $table->decimal('sal', 8, 2)->default(0);
        $table->timestamps();
    });
    }
};
