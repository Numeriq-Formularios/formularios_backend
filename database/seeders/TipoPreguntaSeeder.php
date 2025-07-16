<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoPregunta;

class TipoPreguntaSeeder extends Seeder
{
        public function run(): void
    {
        $tiposPreguntas = [
            [
                'tipo' => 'Opción múltiple',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tipo' => 'Verdadero/Falso',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($tiposPreguntas as $tipo) {
            TipoPregunta::create($tipo);
        }
    }
}

