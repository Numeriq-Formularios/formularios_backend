<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IntentoAlumnoActividadExamen;
use App\Models\OpcionRespuesta;
use App\Models\Pregunta;

class ResultadoPreguntaActividadExamen extends Model
{
    protected $table = 'resultado_pregunta_actividad_examen';

    protected $fillable = [
        'id_intento',
        'id_opcion_res',
        'id_pregunta',
        'respuesta_texto',
        'es_correcta',
        'puntaje_obtenido',
        'explicacion_docente',
        'estado'
    ];

    public function intento()
    {
        return $this->belongsTo(IntentoAlumnoActividadExamen::class, 'id_intento');
    }

    public function opcionRespuesta()
    {
        return $this->belongsTo(OpcionRespuesta::class, 'id_opcion_seleccionada');
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }
}
