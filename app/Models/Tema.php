<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asignatura;
use App\Models\Pregunta;

class Tema extends Model
{
    protected $table = 'temas';

    protected $fillable = [
        'id_asignatura',
        'nombre',
        'estado',
    ];

    // Relación: Un tema pertenece a una asignatura
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'id_asignatura');
    }

    // Relación: Un tema puede tener muchas preguntas
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'id_tema');
    }
}
