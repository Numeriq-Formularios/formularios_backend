<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Alumno;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener los usuarios desde el ID 7 en adelante (que serán alumnos)
        $usuariosAlumnos = Usuario::where('id', '>=', 7)->get();
        
        $datosAlumnos = [
            [
                'id' => 7, // Pedro - Mismo ID que el usuario
                'escolaridad' => 'Bachillerato',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8, // Sofia - Mismo ID que el usuario
                'escolaridad' => 'Técnico en Sistemas',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9, // Miguel - Mismo ID que el usuario
                'escolaridad' => 'Bachillerato',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10, // Valentina - Mismo ID que el usuario
                'escolaridad' => 'Técnico en Administración',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11, // Andrés - Mismo ID que el usuario
                'escolaridad' => 'Bachillerato',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12, // Camila - Mismo ID que el usuario
                'escolaridad' => 'Técnico en Contabilidad',
                'estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($datosAlumnos as $datosAlumno) {
            Alumno::create($datosAlumno);
        }
    }
}