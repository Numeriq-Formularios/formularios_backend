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
        Schema::create('cursos_alumnos', function (Blueprint $table) {
            $table->foreignId('id_curso')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('id_alumno')->constrained('alumnos')->onDelete('cascade');
            $table->integer('calificacion')->nullable(); // Calificación del alumno en el curso, puede ser nula si aún no ha sido evaluado
            $table->date('fecha_inscripcion')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->primary(['id_curso', 'id_alumno']);
            $table->index(['id_curso', 'estado']); // Para buscar alumnos activos de un curso
            $table->index(['id_alumno', 'estado']); // Para buscar cursos activos de un alumno
        });
    }

            
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_alumnos');
    }
};
