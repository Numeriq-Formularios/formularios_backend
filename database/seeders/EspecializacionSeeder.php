<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Especializacion;

class EspecializacionSeeder extends Seeder
{
public function run(): void
    {
        $especializaciones = [
            [
                'nombre' => 'Pedagogía Social',
                'descripcion' => 'Especialización en educación para la transformación social y el trabajo con comunidades',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Psicológica',
                'descripcion' => 'Especialización en procesos psicológicos del aprendizaje y desarrollo cognitivo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Infantil',
                'descripcion' => 'Especialización en educación preescolar y primera infancia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Especial',
                'descripcion' => 'Especialización en educación inclusiva y necesidades educativas especiales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Terapéutica',
                'descripcion' => 'Especialización en intervención educativa con dificultades de aprendizaje',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Waldorf',
                'descripcion' => 'Especialización en metodología educativa antroposófica Rudolf Steiner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Montessori',
                'descripcion' => 'Especialización en método educativo María Montessori para el desarrollo autónomo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Constructivista',
                'descripcion' => 'Especialización en aprendizaje constructivista y metodologías activas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Digital',
                'descripcion' => 'Especialización en integración de tecnologías digitales en el proceso educativo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Crítica',
                'descripcion' => 'Especialización en educación transformadora y conciencia crítica Paulo Freire',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Hospitalaria',
                'descripcion' => 'Especialización en educación para niños y adolescentes en situación de enfermedad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Intercultural',
                'descripcion' => 'Especialización en educación multicultural y diversidad étnica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía de Adultos',
                'descripcion' => 'Especialización en andragogía y educación para adultos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Ambiental',
                'descripcion' => 'Especialización en educación ambiental y sostenibilidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Artística',
                'descripcion' => 'Especialización en educación a través de las artes y expresión creativa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Lúdica',
                'descripcion' => 'Especialización en aprendizaje a través del juego y actividades recreativas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Religiosa',
                'descripcion' => 'Especialización en educación religiosa y formación en valores espirituales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Familiar',
                'descripcion' => 'Especialización en orientación educativa familiar y escuela de padres',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Deportiva',
                'descripcion' => 'Especialización en educación física y formación deportiva integral',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Pedagogía Musical',
                'descripcion' => 'Especialización en educación musical y desarrollo de habilidades auditivas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($especializaciones as $especializacion) {
            Especializacion::create($especializacion);
        }
    }
}