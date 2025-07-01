<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pregunta;
use App\Models\ResultadoPreguntaActividadPractica;
use App\Models\ResultadoPreguntaActividadExamen;

class OpcionRespuesta extends Model
{
    protected $table = 'opcion_respuestas';

    // Definimos los campos que se pueden llenar

   protected $fillable = [
        'id_pregunta',
        'texto_opcion',
        'es_correcta',
    ];

    // Relación: Una opción de respuesta pertenece a una pregunta
    public function preguntaOpcion()
    {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }

    // Relación: Una opción de respuesta tiene muchos resultados de pregunta en actividad práctica
    public function resultadosPreguntaActividadPractica()
    {
        return $this->hasMany(ResultadoPreguntaActividadPractica::class, 'id_opcion_seeleccionada');
    }

       // Relación: Una opción de respuesta tiene muchos resultados de pregunta en actividad examen
    public function resultadosPreguntaActividadExamen()
    {
        return $this->hasMany(ResultadoPreguntaActividadExamen::class, 'id_opcion_seleccionada');
    }

}
