<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Intento_alumno_actividad_examen;
use App\Models\Pregunta_actividad_examen;


class Actividad_examen extends Model
{
   protected $fillable = [
        'id_curso',
        'id_docente',
        'nombre',
        'descripcion',
        'modo',
        'cantidad_reactivos',
        'tiempo_limite',
        'intentos_permitidos',
        'aleatorizar_preguntas',
        'aleatorizar_opciones',
        'umbral_aprobacion',
        'estado',
    ];

    // Relación: Un examen pertenece a un curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }
    // Relación: Un examen pertenece a un docente
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }
       // Relación con el modelo de Intento_alumno_actividad_examen
    public function intentosAlumnos()
    {
        return $this->hasMany(Intento_alumno_actividad_examen::class, 'id_actividad_examen');
    }
    
       // Relación con el modelo de pregunta actividad examen
    public function preguntas()
    {
        return $this->hasMany(Pregunta_actividad_examen::class, 'id_actividad_examen');
    }

}
