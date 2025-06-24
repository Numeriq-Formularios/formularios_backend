<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\ActividadExamen;
use App\Models\Pregunta;

class PreguntaActividadExamen extends Pivot
{
    protected $table = 'pregunta_actividad_examen';

    // Definimos los campos que se pueden llenar
 protected $fillable = [
        'id_actividad_examen',
        'id_pregunta',
        'orden',
    ];

    public function actividadExamen()
    {
        return $this->belongsTo(ActividadExamen::class, 'id_actividad_examen');
    }
    
    // Relación: Una pregunta puede pertenecer a muchas actividades de examen
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');

    }



}
