<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use APP\Models\IntentoAlumnoActividadPractica;
use App\Models\OpcionRespuesta;
use App\Models\Pregunta;


class ResultadoPreguntaActividadPractica extends Model
{
    protected $table = 'resultado_pregunta_actividad_practica';

    protected $fillable = [
        'id_intento',
        'id_pregunta',
        'id_opcion_res',
        'respuesta_texto',
        'es_correcta',
        'puntaje_obtenido',
        'explicacion_docente',
        'estado'
    ];

    public function intento()
    {
        return $this->belongsTo(IntentoAlumnoActividadPractica::class, 'id_intento');
    }

    public function opcionRespuesta()
    {
        return $this->belongsTo(OpcionRespuesta::class, 'id_opcion_res');
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }
}

