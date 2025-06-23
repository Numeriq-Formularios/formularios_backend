<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Curso;
use App\Models\Tema;

class Asignatura extends Model
{
    protected $table = 'asignaturas';

    // Definimos los campos que se pu

 protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];
    
    // Relación: Un curso puede pertenecer a una asignatura
    public function cursosAsignatura()
    {
        return $this->hasMany(Curso::class, 'id_asignatura');
    }
    
  // Relación: Una asignatura puede tener muchos temas
    public function temasAsignatura()
    {
        return $this->hasMany(Tema::class, 'id_asignatura');
    }

}
