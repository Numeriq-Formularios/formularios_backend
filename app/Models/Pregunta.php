<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Docente;
use App\Models\Tema;
use App\Models\Nivel_bloom;
use App\Models\Dificultad;
use App\Models\Tipo_pregunta;
use App\Models\Pregunta_actividad_examen;       
use App\Models\Opcion_respuesta;

class Pregunta extends Model
{
    protected $fillable = [
        'id_docente',
        'id_tema',
        'id_nivel_bloom',
        'id_dificultad',
        'id_tipo_pregunta',
        'texto_pregunta',
        'explicacion',
        'estado',
    ];
    // Relación: Una pregunta pertenece a un docente
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }
    // Relación: Una pregunta pertenece a un tema
    public function tema()
    {
        return $this->belongsTo(Tema::class, 'id_tema');
    }
    // Relación: Una pregunta pertenece a un nivel de Bloom
    public function nivelBloom()
    {
        return $this->belongsTo(Nivel_bloom::class, 'id_nivel_bloom');
    }
    // Relación: Una pregunta pertenece a una dificultad
    public function dificultad()
    {
        return $this->belongsTo(Dificultad::class, 'id_dificultad');
    }
    // Relación: Una pregunta pertenece a un tipo de pregunta
    public function tipoPregunta()
    {
        return $this->belongsTo(Tipo_pregunta::class, 'id_tipo_pregunta');
    }

    // Relación: Una pregunta pertenece a preguntas de actividad examen
    public function preguntaActividadExamen()
    {
        return $this->hasMany(Pregunta_actividad_examen::class, 'id_pregunta');
    }

       // Relación: Una pregunta tiene muchas opciones de respuesta
    public function opcionesRespuesta()
    {
        return $this->hasMany(Opcion_respuesta::class, 'id_pregunta');
    }

}
