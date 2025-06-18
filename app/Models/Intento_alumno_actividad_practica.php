<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intento_alumno_actividad_practica extends Model
{
    protected $table = 'intento_alumno_actividad_practica';

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

    public function actividadPractica()
    {
        return $this->belongsTo(Actividad_practica::class, 'id_actividad_practica');
    }
}
