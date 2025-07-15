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
        Schema::create('pregunta_actividad_examenes', function (Blueprint $table) {
            
            $table->foreignId('id_actividad_examen')->constrained('actividad_examenes')->onDelete('cascade');
            $table->foreignId('id_pregunta')->constrained('preguntas')->onDelete('cascade');
            $table->integer('orden')->nullable();
            $table->timestamps();

            $table->primary(['id_actividad_examen', 'id_pregunta']);
            $table->index('id_actividad_examen');
            $table->index('id_pregunta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregunta_actividad_examenes');
    }
};
