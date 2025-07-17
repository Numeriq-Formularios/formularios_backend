<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = [
            [
                'id_docente' => 1,
                'id_asignatura' => 1,
                'nombre' => 'Matemáticas Básicas',
                'descripcion' => 'Curso introductorio de matemáticas.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-12-15',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_docente' => 2,
                'id_asignatura' => 2,
                'nombre' => 'Álgebra Intermedia',
                'descripcion' => 'Conceptos fundamentales de álgebra.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-12-15',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_docente' => 3,
                'id_asignatura' => 3,
                'nombre' => 'Geometría Analítica',
                'descripcion' => 'Estudio de figuras geométricas y sus propiedades.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-12-15',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_docente' => 4,
                'id_asignatura' => 4,
                'nombre' => 'Cálculo Diferencial',
                'descripcion' => 'Introducción al cálculo y sus aplicaciones.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-12-15',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_docente' => 5,
                'id_asignatura' => 5,
                'nombre' => 'Cálculo Integral',
                'descripcion' => 'Curso sobre integración y técnicas avanzadas.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-12-15',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_docente' => 1,
                'id_asignatura' => 6,
                'nombre' => 'Estadística Descriptiva',
                'descripcion' => 'Fundamentos de estadística y análisis de datos.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-12-15',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_docente' => 2,
                'id_asignatura' => 7,
                'nombre' => 'Probabilidad',
                'descripcion' => 'Teoría y problemas de probabilidad.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-12-15',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_docente' => 3,
                'id_asignatura' => 8,
                'nombre' => 'Matemáticas Discretas',
                'descripcion' => 'Lógica, conjuntos y estructuras discretas.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-12-15',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_docente' => 4,
                'id_asignatura' => 9,
                'nombre' => 'Ecuaciones Diferenciales',
                'descripcion' => 'Solución y aplicaciones de ecuaciones diferenciales.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-12-15',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_docente' => 5,
                'id_asignatura' => 10,
                'nombre' => 'Física Básica',
                'descripcion' => 'Principios fundamentales de la física.',
                'fecha_inicio' => '2025-08-01',
                'fecha_fin' => '2025-12-15',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}