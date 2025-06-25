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
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_docente')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('id_tema')->constrained('temas')->onDelete('cascade');
            $table->foreignId('id_nivel_bloom')->constrained('nivel_blooms')->onDelete('cascade');
            $table->foreignId('id_dificultad')->constrained('dificultades')->onDelete('cascade');
            $table->foreignId('id_tipo_pregunta')->constrained('tipo_preguntas')->onDelete('cascade');
            $table->text('texto_pregunta');
            $table->text('explicacion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
