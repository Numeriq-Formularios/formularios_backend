<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pregunta;


class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run(): void
{
    $preguntas = [
        // 10 preguntas de Matemáticas (IDs en 1)
        [
            'id_docente' => 1,
            'id_tema' => 1,
            'id_nivel_bloom' => 1,
            'id_dificultad' => 1,
            'id_tipo_pregunta' => 1,
            'texto_pregunta' => '¿Cuánto es 5 + 7?',
            'explicacion' => 'Suma básica.',
            'estado' => true,
        ],
        [
            'id_docente' => 1,
            'id_tema' => 1,
            'id_nivel_bloom' => 1,
            'id_dificultad' => 1,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Cuánto es 9 x 6?',
            'explicacion' => 'Multiplicación básica.',
            'estado' => true,
        ],
        [
            'id_docente' => 1,
            'id_tema' => 2,
            'id_nivel_bloom' => 1,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 1,
            'texto_pregunta' => '¿Qué es una fracción?',
            'explicacion' => 'Parte de un entero.',
            'estado' => true,
        ],
        [
            'id_docente' => 1,
            'id_tema' => 2,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => 'Resuelve: 3/4 + 1/4',
            'explicacion' => 'Suma de fracciones.',
            'estado' => true,
        ],
        [
            'id_docente' => 1,
            'id_tema' => 3,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 1,
            'texto_pregunta' => '¿Qué es un número decimal?',
            'explicacion' => 'Número con parte fraccionaria.',
            'estado' => true,
        ],
        [
            'id_docente' => 1,
            'id_tema' => 3,
            'id_nivel_bloom' => 3,
            'id_dificultad' => 3,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => 'Convierte 0.75 a fracción.',
            'explicacion' => '0.75 = 3/4.',
            'estado' => true,
        ],
        [
            'id_docente' => 1,
            'id_tema' => 4,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 1,
            'texto_pregunta' => '¿Qué es un triángulo?',
            'explicacion' => 'Figura de tres lados.',
            'estado' => true,
        ],
        [
            'id_docente' => 1,
            'id_tema' => 4,
            'id_nivel_bloom' => 3,
            'id_dificultad' => 3,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => 'Calcula el área de un triángulo de base 6 y altura 4.',
            'explicacion' => 'Área = (base x altura)/2 = 12.',
            'estado' => true,
        ],
        [
            'id_docente' => 1,
            'id_tema' => 5,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 1,
            'texto_pregunta' => '¿Qué es el perímetro?',
            'explicacion' => 'Suma de los lados de una figura.',
            'estado' => true,
        ],
        [
            'id_docente' => 1,
            'id_tema' => 5,
            'id_nivel_bloom' => 3,
            'id_dificultad' => 3,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => 'Calcula el perímetro de un cuadrado de lado 5.',
            'explicacion' => 'Perímetro = 4 x 5 = 20.',
            'estado' => true,
        ],

        // 10 preguntas de Español (IDs en 2)
        [
            'id_docente' => 2,
            'id_tema' => 6,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Qué es un sustantivo?',
            'explicacion' => 'Palabra que nombra personas, animales, cosas o ideas.',
            'estado' => true,
        ],
        [
            'id_docente' => 2,
            'id_tema' => 6,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Qué es un adjetivo?',
            'explicacion' => 'Palabra que describe a un sustantivo.',
            'estado' => true,
        ],
        [
            'id_docente' => 2,
            'id_tema' => 7,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Qué es un verbo?',
            'explicacion' => 'Palabra que indica acción, estado o proceso.',
            'estado' => true,
        ],
        [
            'id_docente' => 2,
            'id_tema' => 7,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Quién escribió "Cien años de soledad"?',
            'explicacion' => 'Gabriel García Márquez.',
            'estado' => true,
        ],
        [
            'id_docente' => 2,
            'id_tema' => 8,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Qué es una oración simple?',
            'explicacion' => 'Oración con un solo verbo.',
            'estado' => true,
        ],
        [
            'id_docente' => 2,
            'id_tema' => 8,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Qué es una oración compuesta?',
            'explicacion' => 'Oración con dos o más verbos.',
            'estado' => true,
        ],
        [
            'id_docente' => 2,
            'id_tema' => 9,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Qué es la gramática?',
            'explicacion' => 'Conjunto de reglas para hablar y escribir correctamente.',
            'estado' => true,
        ],
        [
            'id_docente' => 2,
            'id_tema' => 9,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Qué es la ortografía?',
            'explicacion' => 'Normas para escribir correctamente las palabras.',
            'estado' => true,
        ],
        [
            'id_docente' => 2,
            'id_tema' => 10,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Qué es la comprensión lectora?',
            'explicacion' => 'Capacidad para entender lo que se lee.',
            'estado' => true,
        ],
        [
            'id_docente' => 2,
            'id_tema' => 10,
            'id_nivel_bloom' => 2,
            'id_dificultad' => 2,
            'id_tipo_pregunta' => 2,
            'texto_pregunta' => '¿Qué es un texto narrativo?',
            'explicacion' => 'Texto que cuenta una historia.',
            'estado' => true,
        ],
    ];

    foreach ($preguntas as $pregunta) {
        \App\Models\Pregunta::create($pregunta);
    }
}
}