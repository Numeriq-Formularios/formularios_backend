<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pregunta;
class Dificultad extends Model
{
protected $fillable = [
        'nivel',
       
    ];

    // Relación: Una dificultad puede tener muchas preguntas
    public function preguntasDificultad()
    {
        return $this->hasMany(Pregunta::class, 'id_dificultad');
    }
}
