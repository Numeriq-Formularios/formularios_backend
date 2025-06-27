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
        Schema::create('actividad_practica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_curso')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('id_docente')->constrained('docentes')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->integer('cantidad_reactivos')->default(0);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->integer('intentos_permitidos')->default(1);
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
        Schema::dropIfExists('actividad_practica');
    }
};
