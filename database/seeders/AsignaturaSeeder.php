<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asignatura;

class AsignaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asignaturas = [
            [
                'nombre' => 'Matemáticas',
                'descripcion' => 'Asignatura fundamental que desarrolla el pensamiento lógico y habilidades numéricas',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Español',
                'descripcion' => 'Asignatura de lengua materna que desarrolla competencias comunicativas y literarias',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Inglés',
                'descripcion' => 'Asignatura de lengua extranjera para desarrollo de competencias comunicativas internacionales',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ciencias Naturales',
                'descripcion' => 'Asignatura que explora el mundo natural y desarrolla pensamiento científico',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ciencias Sociales',
                'descripcion' => 'Asignatura que estudia la sociedad, historia y geografía para formar ciudadanos críticos',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Educación Física',
                'descripcion' => 'Asignatura que desarrolla habilidades motrices y promueve la salud integral',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Educación Artística',
                'descripcion' => 'Asignatura que desarrolla la creatividad y expresión a través de las artes',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ética y Valores',
                'descripcion' => 'Asignatura que forma en principios morales y convivencia ciudadana',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Tecnología e Informática',
                'descripcion' => 'Asignatura que desarrolla competencias digitales y tecnológicas',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Química',
                'descripcion' => 'Asignatura que estudia la materia, sus propiedades y transformaciones',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Física',
                'descripcion' => 'Asignatura que estudia las leyes que gobiernan el universo y los fenómenos naturales',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Biología',
                'descripcion' => 'Asignatura que estudia los seres vivos y sus procesos vitales',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Literatura',
                'descripcion' => 'Asignatura que estudia las obras literarias y desarrolla la comprensión lectora',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($asignaturas as $asignatura) {
            Asignatura::create($asignatura);
        }
    }
}
