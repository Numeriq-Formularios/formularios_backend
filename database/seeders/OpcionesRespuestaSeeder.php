<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OpcionRespuesta;

class OpcionesRespuestaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opcionesRespuesta = [
            // Pregunta 1: ¿Cuánto es 5 + 7?
            [
                'id_pregunta' => 1,
                'texto_opcion' => '12',
                'es_correcta' => true,
            ],
            [
                'id_pregunta' => 1,
                'texto_opcion' => '10',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 1,
                'texto_opcion' => '13',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 1,
                'texto_opcion' => '11',
                'es_correcta' => false,
            ],

            // Pregunta 2: ¿Cuánto es 9 x 6?
            [
                'id_pregunta' => 2,
                'texto_opcion' => '54',
                'es_correcta' => true,
            ],
            [
                'id_pregunta' => 2,
                'texto_opcion' => '48',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 2,
                'texto_opcion' => '56',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 2,
                'texto_opcion' => '52',
                'es_correcta' => false,
            ],

            // Pregunta 3: ¿Qué es una fracción?
            [
                'id_pregunta' => 3,
                'texto_opcion' => 'Parte de un entero',
                'es_correcta' => true,
            ],
            [
                'id_pregunta' => 3,
                'texto_opcion' => 'Un número entero',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 3,
                'texto_opcion' => 'Una operación matemática',
                'es_correcta' => false,
            ],

            // Pregunta 4: Resuelve: 3/4 + 1/4
            [
                'id_pregunta' => 4,
                'texto_opcion' => '1',
                'es_correcta' => true,
            ],
            [
                'id_pregunta' => 4,
                'texto_opcion' => '4/8',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 4,
                'texto_opcion' => '3/8',
                'es_correcta' => false,
            ],

            // Pregunta 5: ¿Qué es un número decimal?
            [
                'id_pregunta' => 5,
                'texto_opcion' => 'Número con parte fraccionaria',
                'es_correcta' => true,
            ],
            [
                'id_pregunta' => 5,
                'texto_opcion' => 'Número sin decimales',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 5,
                'texto_opcion' => 'Número negativo',
                'es_correcta' => false,
            ],

            // Pregunta 6: Convierte 0.75 a fracción
            [
                'id_pregunta' => 6,
                'texto_opcion' => '3/4',
                'es_correcta' => true,
            ],
            [
                'id_pregunta' => 6,
                'texto_opcion' => '7/5',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 6,
                'texto_opcion' => '75/100',
                'es_correcta' => false,
            ],

            // Pregunta 7: ¿Qué es un triángulo?
            [
                'id_pregunta' => 7,
                'texto_opcion' => 'Figura de tres lados',
                'es_correcta' => true,
            ],
            [
                'id_pregunta' => 7,
                'texto_opcion' => 'Figura de cuatro lados',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 7,
                'texto_opcion' => 'Figura circular',
                'es_correcta' => false,
            ],

            // Pregunta 8: Calcula el área de un triángulo de base 6 y altura 4
            [
                'id_pregunta' => 8,
                'texto_opcion' => '12',
                'es_correcta' => true,
            ],
            [
                'id_pregunta' => 8,
                'texto_opcion' => '24',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 8,
                'texto_opcion' => '10',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 8,
                'texto_opcion' => '20',
                'es_correcta' => false,
            ],

            // Pregunta 9: ¿Qué es el perímetro?
            [
                'id_pregunta' => 9,
                'texto_opcion' => 'Suma de los lados de una figura',
                'es_correcta' => true,
            ],
            [
                'id_pregunta' => 9,
                'texto_opcion' => 'Área de una figura',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 9,
                'texto_opcion' => 'Volumen de una figura',
                'es_correcta' => false,
            ],

            // Pregunta 10: Calcula el perímetro de un cuadrado de lado 5
            [
                'id_pregunta' => 10,
                'texto_opcion' => '20',
                'es_correcta' => true,
            ],
            [
                'id_pregunta' => 10,
                'texto_opcion' => '25',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 10,
                'texto_opcion' => '10',
                'es_correcta' => false,
            ],
            [
                'id_pregunta' => 10,
                'texto_opcion' => '15',
                'es_correcta' => false,
            ],
        ];

        foreach ($opcionesRespuesta as $opcion) {
            OpcionRespuesta::create($opcion);
        }
    }
}