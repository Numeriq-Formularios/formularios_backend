<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Alumno;
use App\Models\ActividadPractica;

class IntentoAlumnoActividadPractica extends Model
{
    protected $table = 'intento_alumno_actividad_practica';

    protected $fillable = [
        'id_alumno',
        'id_actividad_practica',
        'fecha_inicio',
        'fecha_fin',
        'puntaje_total',
        'completado',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

    public function actividadPractica()
    {
        return $this->belongsTo(ActividadPractica::class, 'id_actividad_practica');
    }
}
