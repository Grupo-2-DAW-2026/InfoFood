<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    // Almacena la información básica del producto
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('ean_13')->unique(); // Código de barras estandarizado
        $table->string('imagen_url')->nullable(); // Ruta o enlace a la fotografía
        $table->timestamps();
    });
    }
};
