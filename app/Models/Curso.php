<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Curso extends Model
{
     protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',       
        'fecha_inicio',
        'fecha_fin',
        'estado',
     ];


//Relacion de curso con cursos_alumno n: n 
public function alumnos():BelongsToMany
{
    return $this->belongsToMany(Alumno::class, 'curso_alumno', 'id_curso', 'id_alumno');

}

//Relaciones de curso de n : 1 con docente 
public function docentes(): BelongsTo
{
    return $this->belongsTo(Docente::class, 'id_docente');

}

//Relacion de curso con asignatura


}
