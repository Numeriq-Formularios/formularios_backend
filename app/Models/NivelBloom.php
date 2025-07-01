<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pregunta;

class NivelBloom extends Model
{

    protected $table = 'nivel_blooms';

 protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    // Relación: Un nivel de Bloom puede tener muchas preguntas
    public function preguntasNivelBloom()
    {
        return $this->hasMany(Pregunta::class, 'id_nivel_bloom');
    }



}
