<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intento_alumno_actividad_examen extends Model
{
    protected $table = 'intento_alumno_actividad_examen';

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'puntaje_total',
        'completado',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

    public function actividadExamen()
    {
        return $this->belongsTo(Actividad_examen::class, 'id_actividad_examen');
    }
}
