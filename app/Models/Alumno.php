<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alumno extends Model
{
    
        protected $fillable = [
        'escolaridad',

    ];


    //Alumno con la relacion de usuario

    public function usuario(): BelongsTo {
        return $this->BelongsTo(Usuario::class, 'id');
    }

    // Alumno con la relacion de curso alumno n : n 
    
    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'curso_alumno', 'id_alumno', 'id_curso');

    }







}
