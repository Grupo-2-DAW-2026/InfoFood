<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    // Cronología de producción (pasos desde origen a destino)
    Schema::create('trazabilidad_pasos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
        $table->integer('orden'); // Determina la posición en la línea de tiempo
        $table->string('titulo'); // Ejemplo: "Cosecha", "Envasado"
        $table->text('descripcion'); // Detalles del proceso realizado
        $table->date('fecha_proceso')->nullable(); // Fecha real del evento
        $table->timestamps();
    });
    }
};
