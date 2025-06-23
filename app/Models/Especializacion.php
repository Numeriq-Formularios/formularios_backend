<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Especializacion extends Model
{
    protected $table = 'especializaciones';
    
        protected $fillable = [
        'nombre',
        'descripcion',
    ];



    // Relacion con la tabla intermedia doecente_especializaciones de n a n

        // Relacion con la tabla intermedia docente_especializaciones de n a n

        public function especializaciones(): BelongsToMany
    {
        return $this->belongsToMany(Especializacion::class, 'docente_especializaciones','id_especializacion', 'id_docente');

    }

}
