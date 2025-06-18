<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asignatura;

class Tema extends Model
{

 protected $fillable = [
        'id_asignatura',
        'nombre',
        'estado',
    ];
    
    // Relación: Un tema pertenece a una asignatura
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'id_asignatura');    
    }

}
