<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\NivelBloom;
use Illuminate\Database\Seeder;

class NivelBloomSeeder extends Seeder
{
    public function run():void
    {
        $nivelesBloom = [
            [
                'nombre' => 'Recordar',
                'descripcion' => 'Recordar y reconocer información, ideas y principios en la forma aproximada en que se aprendieron.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comprender',
                'descripcion' => 'Comprender el material y captarlo en sus propias palabras, interpretarlo, compararlo y contrastarlo.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Aplicar',
                'descripcion' => 'Aplicar el conocimiento a situaciones nuevas y concretas.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Analizar',
                'descripcion' => 'Descomponer el conocimiento en sus partes y relacionarlas.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Evaluar',
                'descripcion' => 'Hacer juicios basados en criterios y estándares a través de la verificación.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Crear',
                'descripcion' => 'Juntar elementos para formar un todo coherente y crear nuevos patrones.',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($nivelesBloom as $nivel) {
            NivelBloom::create($nivel);
        }
    }
}
