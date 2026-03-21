<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    // Lista completa de ingredientes asociados a un producto
    Schema::create('ingredientes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
        $table->text('nombre'); // Usamos text para listas extensas de ingredientes
        $table->timestamps();
    });
    }
};
