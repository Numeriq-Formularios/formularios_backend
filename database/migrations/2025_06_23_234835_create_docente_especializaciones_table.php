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
            $table->id();
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('especializacion_id')->constrained('especializaciones')->onDelete('cascade');
            $table->timestamps();
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
