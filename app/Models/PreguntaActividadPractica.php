<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\ActividadPractica;
use App\Models\Pregunta;

class PreguntaActividadPractica extends Pivot
{
    protected $table = 'pregunta_actividad_practica';

    protected $fillable = [
        'id_actividad_examen',
        'id_pregunta',
        'orden',
    ];

    public function actividad_practica()
    {
        return $this->belongsTo(ActividadPractica::class, 'id_practica');
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }
}
