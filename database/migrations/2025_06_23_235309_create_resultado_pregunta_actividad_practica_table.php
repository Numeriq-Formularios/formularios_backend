<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('resultado_pregunta_actividad_practica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intento_id')->constrained('intento_alumno_actividad_practica')->onDelete('cascade');
            $table->foreignId('opcion_res_id')->nullable()->constrained('opcion_respuestas')->onDelete('cascade');
            $table->foreignId('pregunta_id')->constrained('preguntas')->onDelete('cascade');
            $table->text('respuesta_texto')->nullable();
            $table->boolean('es_correcta')->default(false);
            $table->decimal('puntaje_obtenido', 5, 2)->nullable();
            $table->text('explicacion_docente')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultado_pregunta_actividad_practica');
    }
};
