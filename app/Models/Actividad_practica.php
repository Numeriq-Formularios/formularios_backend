<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad_practica extends Model
{
    protected $table = 'actividad_practica';

    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad_reactivos',
        'fecha_creacion',
        'intentos_permitidos',
        'umbral_aprobacion',
        'estado',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    public function preguntasActividad() {
        return $this->hasMany(Pregunta_actividad_practica::class, 'id_practica', 'id_pregunta');
    }
}
