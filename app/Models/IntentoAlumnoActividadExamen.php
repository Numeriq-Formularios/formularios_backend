<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
USE App\Models\Alumno;
use App\Models\ActividadExamen;

class IntentoAlumnoActividadExamen extends Model
{
    protected $table = 'intento_alumno_actividad_examen';

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'puntaje_total',
        'completado',
    ];

    //Un intento de activcidad examen pertenece a un alumno
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }

    //Un intento de actividad examen pertenece a una actividad examen
    public function actividadExamen()
    {
        return $this->belongsTo(ActividadExamen::class, 'id_actividad_examen');
    }

    public function resultados(){
        return $this->hasMany(ResultadoPreguntaActividadExamen::class, 'id_intento');
    }


}
