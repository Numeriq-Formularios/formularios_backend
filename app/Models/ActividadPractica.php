<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Docente;
use App\Models\Curso;
use App\Models\PreguntaActividadPractica;
use App\Models\Pregunta;

class ActividadPractica extends Model
{
    protected $table = 'actividad_practica';

    protected $fillable = [
        'id_curso',
        'id_docente',
        'nombre',
        'descripcion',
        'cantidad_reactivos',
        'fecha_creacion',
        'intentos_permitidos',
        'umbral_aprobacion',
        'estado',
    ];

    // Relación con el modelo Docente una actividad práctica pertenece a un docente
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }

    // Relación con el modelo Curso una actividad práctica pertenece a un curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }


            //Relacion de actividadExamen con preguntaActividadExamen con la tabla padre pregunta n: n 
    public function preguntas(): BelongsToMany
    {
        return $this->belongsToMany(Pregunta::class, 'pregunta_actividad_practica', 'id_actividad_practica', 'id_pregunta')
        ->using(PreguntaActividadPractica::class)
        ->withPivot('orden')
        ->withTimestamps();
    }
}
