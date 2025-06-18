<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Docente extends Model
{

    protected $fillable = [
        'titulo_profesional',
        'linkedin',
        'es_superusuario'
    ];


    //Relacion con el modelo de Usuario de 1 a 1
    //Un docente tiene un usuario, y un usuario puede ser docente 
    public function usuario(): BelongsTo
    {
        return $this->BelongsTo(Usuario::class, 'id');
    }


    //Relacion con el modelo de Curso de 1 a n
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'id_docente');
    }


    // Relacion con la tabla intermedia docente_especializaciones de n a n

        public function especializaciones(): BelongsToMany
    {
        return $this->belongsToMany(Especializacion::class, 'docente_especializaciones', 'id_docente', 'id_especializacion');

    }

}