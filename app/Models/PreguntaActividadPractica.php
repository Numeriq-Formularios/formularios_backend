<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\ActividadPractica;
use App\Models\Pregunta;

class PreguntaActividadPractica extends Pivot
{
    protected $table = 'pregunta_actividad_practica';

    protected $fillable = [
        'id_practica',
        'id_pregunta',
        'orden',
        'estado'
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
