<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() 
    {
    // Registro de productos consultados por cada usuario (Historial de búsqueda)
    Schema::create('producto_user_historial', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('producto_id')->constrained()->onDelete('cascade');
        $table->timestamps(); // La fecha de creación actúa como "fecha de escaneo"
    });
    }
};
