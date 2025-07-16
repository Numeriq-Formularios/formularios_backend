<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dificultad;

class DificultadSeeder extends Seeder
{
    public function run():void
    {
        $dificultades = [
            [
                'nivel' => 'Facil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nivel' => 'Medio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nivel' => 'Dificil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($dificultades as $dificultad) {
            Dificultad::create($dificultad);
        }
    }
}