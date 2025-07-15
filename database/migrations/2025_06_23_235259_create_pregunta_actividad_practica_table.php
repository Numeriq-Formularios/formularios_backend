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
        Schema::create('pregunta_actividad_practica', function (Blueprint $table) {
            
            $table->foreignId('id_practica')->constrained('actividad_practica')->onDelete('cascade');
            $table->foreignId('id_pregunta')->constrained('preguntas')->onDelete('cascade');
            $table->integer('orden')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->primary(['id_practica', 'id_pregunta']);
            $table->index('id_practica');
            $table->index('id_pregunta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregunta_actividad_practica');
    }
};
