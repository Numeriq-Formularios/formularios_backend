<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CursoAlumno;
use Carbon\Carbon;

class CursoAlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inscripciones = [
            // Pedro (ID: 7) - Inscrito en 3 cursos
            [
                'id_curso' => 1, // Matemáticas Básicas
                'id_alumno' => 7,
                'calificacion' => null, // Se asignará al finalizar
                'estado' => 1, // Activo
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 2, // Álgebra Intermedia
                'id_alumno' => 7,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 6, // Estadística Descriptiva
                'id_alumno' => 7,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sofia (ID: 8) - Inscrita en 2 cursos
            [
                'id_curso' => 3, // Geometría Analítica
                'id_alumno' => 8,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 8, // Matemáticas Discretas
                'id_alumno' => 8,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Miguel (ID: 9) - Inscrito en 4 cursos
            [
                'id_curso' => 1, // Matemáticas Básicas
                'id_alumno' => 9,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 4, // Cálculo Diferencial
                'id_alumno' => 9,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 5, // Cálculo Integral
                'id_alumno' => 9,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 10, // Física Básica
                'id_alumno' => 9,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Valentina (ID: 10) - Inscrita en 2 cursos
            [
                'id_curso' => 6, // Estadística Descriptiva
                'id_alumno' => 10,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 7, // Probabilidad
                'id_alumno' => 10,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Andrés (ID: 11) - Inscrito en 3 cursos
            [
                'id_curso' => 2, // Álgebra Intermedia
                'id_alumno' => 11,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 3, // Geometría Analítica
                'id_alumno' => 11,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 9, // Ecuaciones Diferenciales
                'id_alumno' => 11,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Camila (ID: 12) - Inscrita en 3 cursos
            [
                'id_curso' => 1, // Matemáticas Básicas
                'id_alumno' => 12,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 6, // Estadística Descriptiva
                'id_alumno' => 12,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_curso' => 8, // Matemáticas Discretas
                'id_alumno' => 12,
                'calificacion' => null,
                'estado' => 1,
                'fecha_inscripcion' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($inscripciones as $inscripcion) {
            CursoAlumno::create($inscripcion);
        }
    }
}