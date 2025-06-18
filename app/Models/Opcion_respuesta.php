<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pregunta;
use App\Models\Resultado_pregunta_actividad_practica;
use App\Models\Resultado_pregunta_actividad_examen;

class Opcion_respuesta extends Model
{

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
        return $this->hasMany(Resultado_pregunta_actividad_practica::class, 'id_opcion_respuesta');
    }

       // Relación: Una opción de respuesta tiene muchos resultados de pregunta en actividad examen
    public function resultadosPreguntaActividadExamen()
    {
        return $this->hasMany(Resultado_pregunta_actividad_examen::class, 'id_opcion_respuesta');
    }

}
