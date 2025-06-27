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
        Schema::create('resultado_pregunta_actividad_examen', function (Blueprint $table) {
            $table->id();
              $table->foreignId('id_intento')->constrained('intento_alumno_actividad_examen')->onDelete('cascade');
            $table->foreignId('id_opcion_res')->nullable()->constrained('opcion_respuestas')->onDelete('cascade');
            $table->foreignId('id_pregunta')->constrained('preguntas')->onDelete('cascade');
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
        Schema::dropIfExists('resultado_pregunta_actividad_examen');
    }
};
