<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tema;

class TemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $temas = [
            // Temas para Matemáticas (id_asignatura: 1)
            [
                'id_asignatura' => 1,
                'nombre' => 'Aritmética Básica',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 1,
                'nombre' => 'Álgebra',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 1,
                'nombre' => 'Geometría',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 1,
                'nombre' => 'Fracciones y Decimales',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Español (id_asignatura: 2)
            [
                'id_asignatura' => 2,
                'nombre' => 'Gramática y Ortografía',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 2,
                'nombre' => 'Comprensión Lectora',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 2,
                'nombre' => 'Redacción y Composición',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 2,
                'nombre' => 'Análisis Textual',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Inglés (id_asignatura: 3)
            [
                'id_asignatura' => 3,
                'nombre' => 'Vocabulario Básico',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 3,
                'nombre' => 'Gramática Inglesa',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 3,
                'nombre' => 'Conversación y Pronunciación',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 3,
                'nombre' => 'Reading Comprehension',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Ciencias Naturales (id_asignatura: 4)
            [
                'id_asignatura' => 4,
                'nombre' => 'Método Científico',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 4,
                'nombre' => 'Ecosistemas y Medio Ambiente',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 4,
                'nombre' => 'Materia y Energía',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 4,
                'nombre' => 'Cuerpo Humano',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Ciencias Sociales (id_asignatura: 5)
            [
                'id_asignatura' => 5,
                'nombre' => 'Historia Universal',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 5,
                'nombre' => 'Geografía Mundial',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 5,
                'nombre' => 'Educación Cívica',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 5,
                'nombre' => 'Cultura y Sociedad',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Educación Física (id_asignatura: 6)
            [
                'id_asignatura' => 6,
                'nombre' => 'Deportes Colectivos',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 6,
                'nombre' => 'Acondicionamiento Físico',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 6,
                'nombre' => 'Recreación y Juegos',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 6,
                'nombre' => 'Salud y Nutrición',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Educación Artística (id_asignatura: 7)
            [
                'id_asignatura' => 7,
                'nombre' => 'Artes Plásticas',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 7,
                'nombre' => 'Música y Ritmo',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 7,
                'nombre' => 'Teatro y Expresión',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 7,
                'nombre' => 'Danza y Movimiento',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Ética y Valores (id_asignatura: 8)
            [
                'id_asignatura' => 8,
                'nombre' => 'Valores Humanos',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 8,
                'nombre' => 'Convivencia Social',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 8,
                'nombre' => 'Derechos Humanos',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 8,
                'nombre' => 'Resolución de Conflictos',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Tecnología e Informática (id_asignatura: 9)
            [
                'id_asignatura' => 9,
                'nombre' => 'Fundamentos de Computación',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 9,
                'nombre' => 'Ofimática Básica',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 9,
                'nombre' => 'Internet y Navegación',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 9,
                'nombre' => 'Programación Básica',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Química (id_asignatura: 10)
            [
                'id_asignatura' => 10,
                'nombre' => 'Estructura Atómica',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 10,
                'nombre' => 'Enlaces Químicos',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 10,
                'nombre' => 'Reacciones Químicas',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 10,
                'nombre' => 'Tabla Periódica',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Física (id_asignatura: 11)
            [
                'id_asignatura' => 11,
                'nombre' => 'Mecánica Clásica',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 11,
                'nombre' => 'Electricidad y Magnetismo',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 11,
                'nombre' => 'Ondas y Sonido',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 11,
                'nombre' => 'Óptica',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Biología (id_asignatura: 12)
            [
                'id_asignatura' => 12,
                'nombre' => 'Célula y Genética',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 12,
                'nombre' => 'Anatomía Humana',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 12,
                'nombre' => 'Evolución y Biodiversidad',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 12,
                'nombre' => 'Ecología',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Temas para Literatura (id_asignatura: 13)
            [
                'id_asignatura' => 13,
                'nombre' => 'Géneros Literarios',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 13,
                'nombre' => 'Literatura Clásica',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 13,
                'nombre' => 'Literatura Contemporánea',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_asignatura' => 13,
                'nombre' => 'Análisis Literario',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($temas as $tema) {
            Tema::create($tema);
        }
    }
}