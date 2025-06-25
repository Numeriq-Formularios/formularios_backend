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
        Schema::create('actividad_examens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_curso')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('id_docente')->constrained('docentes')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('modo')->nullable(); // por si es 'formativo', 'sumativo', etc.
            $table->integer('cantidad_reactivos')->default(0);
            $table->integer('tiempo_limite')->nullable(); // en minutos
            $table->integer('intentos_permitidos')->default(1);
            $table->boolean('aleatorizar_preguntas')->default(false);
            $table->boolean('aleatorizar_opciones')->default(false);
            $table->decimal('umbral_aprobacion', 5, 2)->default(0);
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
        Schema::dropIfExists('actividad_examenes');
    }
};
