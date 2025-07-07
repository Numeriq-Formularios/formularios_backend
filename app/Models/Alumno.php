<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Usuario;
use App\Models\Curso;
use App\Models\CursoAlumno;
use App\Models\IntentoAlumnoActividadExamen;
use App\Models\IntentoAlumnoActividadPractica;

class Alumno extends Model
{
    protected $table = 'alumnos';

    protected $fillable = [
        'escolaridad',
        'estado',
    ];
    
    protected $primaryKey = 'id'; // Definir la clave primaria
    public $incrementing = false; // La clave primaria no es autoincremental


    //Un Alumno pertenece a un usuario
    public function usuario(): BelongsTo {
        return $this->BelongsTo(Usuario::class, 'id');
    }

    // Alumno con la relacion de curso alumno n : n 
    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'cursos_alumnos', 'id_alumno', 'id_curso')->using(CursoAlumno::class)->withPivot('calificacion', 'estado', 'fecha_inscripcion')->withTimestamps();

    }

    public function intentosActividadExamen() {
        return $this->hasMany(IntentoAlumnoActividadExamen::class, 'id_alumno');
    }

    public function intentosActividadPractica() {
        return $this->hasMany(IntentoAlumnoActividadPractica::class, 'id_alumno');
    }









}
