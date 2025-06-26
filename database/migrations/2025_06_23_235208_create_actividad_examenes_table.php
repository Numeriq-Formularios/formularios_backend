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
        Schema::create('actividad_examenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->string('modo', 50)->nullable();
            $table->integer('cantidad_reactivos')->default(0);
            $table->integer('tiempo_limite')->nullable();
            $table->integer('intentos_permitidos')->default(1);
            $table->boolean('aleatorizar_preguntas')->default(false);
            $table->boolean('aleatorizar_opciones')->default(false);
            $table->decimal('umbral_aprobacion', 5, 2)->default(0);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_examenes');
    }
};
