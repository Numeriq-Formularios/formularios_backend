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
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('tema_id')->constrained('temas')->onDelete('cascade');
            $table->foreignId('nivel_bloom_id')->constrained('nivel_blooms')->onDelete('cascade');
            $table->foreignId('dificultad_id')->constrained('dificultades')->onDelete('cascade');
            $table->foreignId('tipo_pregunta_id')->constrained('tipo_preguntas')->onDelete('cascade');
            $table->text('texto_pregunta');
            $table->text('explicacion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
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
