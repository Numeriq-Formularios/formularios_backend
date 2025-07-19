<?php

namespace App\Policies;

use App\Models\Alumno;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class AlumnoPolicy
{


    /**     * CRUD Administrativo -Solo superusuario
     */
    public function viewAny(Usuario $usuario): bool
    {
        return $usuario->esSuperUsuario();
    }

    /**
     * Ver un alumno en especifico, solo el superUsuario o el mismo alumno
     */
    public function view(Usuario $usuario ): bool
    {
        if($usuario->esSuperUsuario()){
            return true;
        }
        return false;
    }

    /**
     * La creacion de usuarios alumnos solo la puede hacer con el register
     */
    public function create(Usuario $usuario): bool
    {
        return false;
    }


    public function update(Usuario $usuario): bool
    {
        return $usuario->esSuperUsuario();
    }

    /**
     * Eliminar un alumno en especifico, solo el superusuario puede
     */
    public function delete(Usuario $usuario): bool
    {
        return $usuario->esSuperUsuario();
    }



    //Solo el alumno puede
    public function meUser(Usuario $usuario): bool
    {

        return $usuario->esAlumno();
    }



    //Solo el alumno puede
    public function updateMe(Usuario $usuario): bool
    {

        return $usuario->esAlumno();
    }

    public function destroyMe(Usuario $usuario): bool
    {
        return $usuario->esAlumno();
    }


    public function incribirCurso(Usuario $usuario): bool
    {
        return $usuario->esAlumno();
    }


    public function misCursos(Usuario $usuario): bool
    {
        return $usuario->esAlumno();
    }


    public function restore(Usuario $usuario, Alumno $alumno): bool
    {
        return false;
    }


    public function forceDelete(Usuario $usuario, Alumno $alumno): bool
    {
        return false;
    }
}
