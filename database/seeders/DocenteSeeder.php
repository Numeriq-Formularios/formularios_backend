<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Docente;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los primeros 6 usuarios (que serán docentes)
        $usuariosDocentes = Usuario::take(6)->get();
        
        $datosDocentes = [
            // Superusuarios
            [
                'id' => 1, // Admin Principal
                'titulo_profesional' => 'Magíster en Educación',
                'linkedin' => 'https://linkedin.com/in/admin-principal',
                'es_superusuario' => 1,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2, // María José
                'titulo_profesional' => 'Doctora en Pedagogía Social',
                'linkedin' => 'https://linkedin.com/in/maria-rodriguez-edu',
                'es_superusuario' => 1,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Docentes normales
            [
                'id' => 3, // Carlos
                'titulo_profesional' => 'Licenciado en Matemáticas',
                'linkedin' => 'https://linkedin.com/in/carlos-mendoza-math',
                'es_superusuario' => 0,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4, // Ana Lucía
                'titulo_profesional' => 'Magíster en Pedagogía Infantil',
                'linkedin' => 'https://linkedin.com/in/ana-herrera-infantil',
                'es_superusuario' => 0,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5, // Luis Fernando
                'titulo_profesional' => 'Licenciado en Ciencias Naturales',
                'linkedin' => 'https://linkedin.com/in/luis-garcia-ciencias',
                'es_superusuario' => 0,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6, // Patricia
                'titulo_profesional' => 'Especialista en Pedagogía Artística',
                'linkedin' => 'https://linkedin.com/in/patricia-jimenez-arte',
                'es_superusuario' => 0,
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($datosDocentes as $datosDocente) {
            Docente::create($datosDocente);
        }
    }
}