<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use App\Models\Especializacion;
use App\Models\TipoPregunta;
use App\Models\User;
use App\Models\Usuario;
use App\Models\Pregunta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DificultadSeeder::class,
            AsignaturaSeeder::class,
            NivelBloomSeeder::class,
            TipoPreguntaSeeder::class,
            EspecializacionSeeder::class,
            TemaSeeder::class,

            UsuarioSeeder::class,
            DocenteSeeder::class,
            AlumnoSeeder::class,
            DocenteEspecializacionSeeder::class,
            PreguntaSeeder::class,

            CursoSeeder::class,
        ]);
    }
}
