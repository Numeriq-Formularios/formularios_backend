<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Curso;
use App\Models\Alumno;

class CursoAlumno extends Pivot
{
    protected $table = 'curso_alumnos';

    protected $fillable = [
        'id_curso',
        'id_alumno',
        //Aqui la idea seria generar la calificacion del alumno en el curso
        'calificacion',
        'estado', // Puede ser 'activo', 'inactivo', etc.
        'fecha_inscripcion', // Fecha en que el alumno se inscribió al curso
    ];


    public function cursos(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    public function alumnos(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'id_alumno');
    }



}
