<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta_actividad_practica extends Model
{
    protected $table = 'pregunta_actividad_practica';

    protected $fillable = [
        'orden',
        'estado',
    ];

    public function actividad_practica()
    {
        return $this->belongsTo(Actividad_practica::class, 'id_practica');
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }
}
