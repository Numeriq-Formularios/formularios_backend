<?php

namespace App\Models;
//Use hasfactory para usar factories para pruebas y seeding 
//Use hasApiTokens para usar tokens de API con santum

//Las relaciones entre modelos se definen en los modelos correspondientes
use Illuminate\Database\Eloquent\Model;
use App\Models\Alumno;
use App\Models\Docente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    protected $table = 'usuarios';
    
    protected $fillable = [
        'nombre',
        'email',
        'clave',
        'foto_perfil',
        'estado',
    ];

    //Decir que el campo clave es el de password. Para el tema de la autentiticacion


    //Relacion con el modelo de Alumno
        public function alumno(): HasOne {
        return $this->hasOne(Alumno::class, 'id');
    }

    //Relacion con el modelo de Docente
    public function docente(): HasOne {
        return $this->hasOne(Docente::class, 'id'); 
    }



}
