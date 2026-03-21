<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    // Catálogo maestro de alérgenos (Gluten, Lácteos, etc.)
    Schema::create('alergenos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); 
        $table->string('icono')->nullable(); // Nombre del archivo de imagen del icono
        $table->timestamps();
    });
    }
};
