<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    // Tabla pivot para relación Muchos a Muchos (un producto puede tener varios alérgenos)
    Schema::create('alergeno_producto', function (Blueprint $table) {
        $table->id();
        $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
        $table->foreignId('alergeno_id')->constrained('alergenos')->onDelete('cascade');
    });
    }
};
