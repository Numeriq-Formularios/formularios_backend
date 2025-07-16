<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Docente;
use App\Models\Especializacion;

class DocenteEspecializacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignar especializaciones a cada docente
        $asignaciones = [
            1 => [1, 2, 3], // Admin Principal: Pedagogía Social, Psicológica, Infantil
            2 => [1, 10],   // María José: Pedagogía Social, Crítica
            3 => [8, 6],    // Carlos: Constructivista, Algoritmos
            4 => [3, 16],   // Ana Lucía: Pedagogía Infantil, Lúdica
            5 => [14, 8],   // Luis Fernando: Pedagogía Ambiental, Constructivista
            6 => [15, 7],   // Patricia: Pedagogía Artística, Montessori
        ];

        foreach ($asignaciones as $docenteId => $especializacionesIds) {
            $docente = Docente::find($docenteId);
            if ($docente) {
                $docente->especializaciones()->attach($especializacionesIds);
            }
        }
    }
}