<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            // Usuarios que serán superusuarios (docentes)
            [
                'nombre' => 'Admin Principal',
                'correo' => 'admin@numeriq.edu',
                'clave' => Hash::make('admin123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María José Rodríguez',
                'correo' => 'maria.rodriguez@numeriq.edu',
                'clave' => Hash::make('docente123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Usuarios que serán docentes normales
            [
                'nombre' => 'Carlos Mendoza',
                'correo' => 'carlos.mendoza@numeriq.edu',
                'clave' => Hash::make('docente123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ana Lucía Herrera',
                'correo' => 'ana.herrera@numeriq.edu',
                'clave' => Hash::make('docente123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Luis Fernando García',
                'correo' => 'luis.garcia@numeriq.edu',
                'clave' => Hash::make('docente123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Patricia Jiménez',
                'correo' => 'patricia.jimenez@numeriq.edu',
                'clave' => Hash::make('docente123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Usuarios que serán alumnos
            [
                'nombre' => 'Pedro Martínez',
                'correo' => 'pedro.martinez@estudiante.numeriq.edu',
                'clave' => Hash::make('alumno123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Sofia Castillo',
                'correo' => 'sofia.castillo@estudiante.numeriq.edu',
                'clave' => Hash::make('alumno123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Miguel Ángel Torres',
                'correo' => 'miguel.torres@estudiante.numeriq.edu',
                'clave' => Hash::make('alumno123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Valentina Morales',
                'correo' => 'valentina.morales@estudiante.numeriq.edu',
                'clave' => Hash::make('alumno123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Andrés Felipe Ruiz',
                'correo' => 'andres.ruiz@estudiante.numeriq.edu',
                'clave' => Hash::make('alumno123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Camila Sánchez',
                'correo' => 'camila.sanchez@estudiante.numeriq.edu',
                'clave' => Hash::make('alumno123'),
                'foto_perfil' => asset('storage/images/user-default-Image.svg'),
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($usuarios as $usuario) {
            Usuario::create($usuario);
        }
    }
}