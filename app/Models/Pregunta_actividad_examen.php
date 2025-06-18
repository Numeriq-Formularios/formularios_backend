<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Actividad_examen;
use App\Models\Pregunta;

class Pregunta_actividad_examen extends Model
{
 protected $fillable = [
        'id_actividad_examen',
        'id_pregunta',
        'orden',
    ];

    public function actividadExamen()
    {
        return $this->belongsTo(Actividad_examen::class, 'id_actividad_examen');
    }
    // Relación: Una pregunta puede pertenecer a muchas actividades de examen
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');

    }



}
