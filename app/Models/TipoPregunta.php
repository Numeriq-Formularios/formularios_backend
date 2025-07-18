<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pregunta;

class TipoPregunta extends Model
{
    protected $table = 'tipo_pregunta';

    protected $fillable = [
        'tipo',
        'estado',
    ];



    // Relación: Un tipo de pregunta puede tener muchas preguntas
    public function preguntasTipo()
    {
        return $this->hasMany(Pregunta::class, 'id_tipo_pregunta');
    }
}
