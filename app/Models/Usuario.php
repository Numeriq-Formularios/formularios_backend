<?php

namespace App\Models;
//Use hasfactory para usar factories para pruebas y seeding 
//Use hasApiTokens para usar tokens de API con santum

//Las relaciones entre modelos se definen en los modelos correspondientes
use Illuminate\Database\Eloquent\Model;
use App\Models\Alumno;
use App\Models\Docente;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens,HasFactory;

    //Definir la tabla que se va a usar
    //Por defecto laravel usa el plural del nombre del modelo en minusculas
    //Si no se define, se usara 'usuarios'
    //protected $table = 'usuarios';
    
    //Definir los campos que se pueden rellenar masivamente
    //Esto es para evitar el mass assignment vulnerability

    protected $table = 'usuarios';
    
    protected $fillable = [
        'nombre',
        'correo',
        'clave',
        'foto_perfil',
        'estado',
    ];

    //Decir que el campo clave es el de password. Para el tema de la autentiticacion


    protected $hidden = [
        'clave', // Este campo se ocultará en las respuestas JSON
    ];

    //Esta metodo le dice a Laravel cual es la clave
    public function getAuthPassword(){
        return $this->clave;
    }

    //Relacion con el modelo de Alumno
        public function alumno(): HasOne {
        return $this->hasOne(Alumno::class, 'id');
    }

    //Relacion con el modelo de Docente
    public function docente(): HasOne {
        return $this->hasOne(Docente::class, 'id'); 
    }

    // ========== MÉTODOS DE ROLES ==========
    
    /**
     * Verificar si el usuario es un alumno
     */
    public function esAlumno(): bool
    {
        return $this->alumno()->exists();
    }

    /**
     * Verificar si el usuario es un docente
     */
    public function esDocente(): bool
    {
        return $this->docente()->exists();
    }

    /**
     * Verificar si el usuario es un superusuario
     * Solo los docentes pueden ser superusuarios
     */
    public function esSuperusuario(): bool
    {
        return $this->esDocente() && $this->docente->es_superusuario == 1;
    }

    /**
     * Obtener el rol principal del usuario
     */
    public function getRol(): string
    {
        if ($this->esSuperusuario()) {
            return 'superusuario';
        }
        
        if ($this->esDocente()) {
            return 'docente';
        }
        
        if ($this->esAlumno()) {
            return 'alumno';
        }
        
        return 'sin_rol';
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function tieneRol(string $rol): bool
    {
        return match($rol) {
            'alumno' => $this->esAlumno(),
            'docente' => $this->esDocente(),
            'superusuario' => $this->esSuperusuario(),
            default => false
        };
    }
}
