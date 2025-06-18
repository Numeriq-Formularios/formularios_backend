<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resultado_pregunta_actividad_examen extends Model
{
    protected $table = 'resultado_pregunta_actividad_examen';

    protected $fillable = [
        'respuesta_texto',
        'es_correcta',
        'puntaje_obtenido',
        'explicacion_docente',
        'estado'
    ];

    public function intento()
    {
        return $this->belongsTo(intento_alumno_actividad_examen::class, 'id_intento');
    }

    public function opcionRespuesta()
    {
        return $this->belongsTo(Opcion_respuesta::class, 'id_opcion_respuesta');
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }
}
