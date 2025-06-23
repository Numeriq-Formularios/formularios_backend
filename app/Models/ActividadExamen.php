<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\IntentoAlumnoActividadExamen;
use App\Models\PreguntaActividadExamen;


class ActividadExamen extends Model
{
    protected $table = 'actividad_examen';

    // Definición de los campos que se pueden asignar masivamente
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
        return $this->hasMany(IntentoAlumnoActividadExamen::class, 'id_actividad_examen');
    }

        //Relacion de actividadExamen con preguntaActividadExamen con la tabla padre pregunta n: n 
    public function preguntas(): BelongsToMany
    {
        return $this->belongsToMany(Pregunta::class, 'pregunta_actividad_examen', 'id_actividad_examen', 'id_pregunta')
        ->using(PreguntaActividadExamen::class)
        ->withPivot('orden')
        ->withTimestamps();
    }

}
