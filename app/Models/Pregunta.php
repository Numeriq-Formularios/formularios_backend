<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Docente;
use App\Models\Tema;
use App\Models\NivelBloom;
use App\Models\Dificultad;
use App\Models\TipoPregunta;
use App\Models\PreguntaActividadExamen;       
use App\Models\OpcionRespuesta;

class Pregunta extends Model
{
    protected $table = 'preguntas';
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
        return $this->belongsTo(NivelBloom::class, 'id_nivel_bloom');
    }
    // Relación: Una pregunta pertenece a una dificultad
    public function dificultad()
    {
        return $this->belongsTo(Dificultad::class, 'id_dificultad');
    }
    // Relación: Una pregunta pertenece a un tipo de pregunta
    public function tipoPregunta()
    {
        return $this->belongsTo(TipoPregunta::class, 'id_tipo_pregunta');
    }

    
       // Relación: Una pregunta tiene muchas opciones de respuesta
    public function opcionesRespuesta()
    {
        return $this->hasMany(OpcionRespuesta::class, 'id_pregunta');
    }

    public function actividadExamenes()
    {
        return $this->belongsToMany(ActividadExamen::class, 'pregunta_actividad_examen', 'id_pregunta', 'id_actividad_examen')
            ->using(PreguntaActividadExamen::class)
            ->withPivot('orden')
            ->withTimestamps();
    }

    public function actividadPracticas(){
        return $this->belongsToMany(ActividadPractica::class, 'pregunta_actividad_practica', 'id_pregunta', 'id_actividad_practica')
            ->using(PreguntaActividadExamen::class)
            ->withPivot('orden')
            ->withTimestamps();
    }




}
