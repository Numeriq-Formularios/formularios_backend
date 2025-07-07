<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Alumno;
use App\Models\Docente;
use App\Models\Asignatura;
use App\Models\CursoAlumno;
use App\Models\ActividadExamen;
use App\Models\ActividadPractica;

class Curso extends Model
{
    protected $table = 'cursos';

    protected $fillable = [
        'id_docente',
        'id_asignatura',
        'nombre',
        'descripcion',
        'imagen',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];


    //Relacion de curso con cursos_alumno n: n 
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Alumno::class, 'cursos_alumnos', 'id_curso', 'id_alumno')->using(CursoAlumno::class)->withPivot('calificacion', 'estado', 'fecha_inscripcion')->withTimestamps();
    }

    //Relaciones de curso de n : 1 con docente 
    public function docentes(): BelongsTo
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }

    //Relacion de curso con asignatura el punto es que sea de una asignatura a 1 curso 
    public function asignaturas(): BelongsTo
    {
        return $this->belongsTo(Asignatura::class, 'id_asignatura');
    }

    //Relacion de curso con actividades examen de 1 a n
    //Relacion con el modelo de Curso de 1 a n
    public function actividadExamen(): HasMany
    {
        return $this->hasMany(ActividadExamen::class, 'id_curso');
    }

        public function actividadPractica(): HasMany
    {
        return $this->hasMany(ActividadPractica::class, 'id_curso');
    }

}
