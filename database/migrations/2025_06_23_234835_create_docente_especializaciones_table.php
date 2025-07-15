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
        Schema::create('docente_especializaciones', function (Blueprint $table) {
            $table->foreignId('id_docente')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('id_especializacion')->constrained('especializaciones')->onDelete('cascade');
            $table->timestamps();


            //Definimos la clave primaria compuesta por id_docente e id_especializacion
            $table->primary(['id_docente', 'id_especializacion']);
            // Creamos un índice para buscar especializaciones de un docente
            $table->index(['id_docente', 'id_especializacion']);
            // Creamos un índice para buscar docentes de una especialización
            $table->index(['id_especializacion', 'id_docente']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docente_especializaciones');
    }
};
