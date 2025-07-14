<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Asignatura;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CursoController extends Controller
{
    //Funcion para listar todos los cursos
    public function index()
    {

        //Validamos que los cursos existan
        $cursos = Curso::where('estado', true)->with(['docentes', 'asignaturas'])->get();

        //Si no existen cursos, retornamos un mensaje
        if (!$cursos) {
            return response()->json([
                "message" => "No existen cursos activos"
            ], 404);
        }


        //Retornamos la respuesta con los cursos
        return response()->json([
            "message" => "Lista de cursos obtenida correctamente",
            "cursos" => $cursos
        ]);
    }




    //Funcion para crear un curso/ Aqui solo puede crear un curso el docente 
    public function store(Request $request)
    {


        //Validamos los datos del request para la creacion del curso
        $data = $request->validate([
            "nombre" => "required|string|max:255",
            "descripcion" => "required|string|max:1000",
            "fecha_inicio" => "required|date|date_format:Y-m-d", // Formato específico
            "fecha_fin" => "required|date|after:fecha_inicio",
            "id_asignatura" => "required|exists:asignaturas,id,estado,1", // Validar estado true
            "id_docente" => "required|exists:docentes,id,estado,1" // Validar estado true
        ]);


        $curso = new Curso();
        $curso->id_docente = $data['id_docente'];
        $curso->nombre = $data['nombre'];
        $curso->descripcion = $data['descripcion'];
        $curso->fecha_inicio = $data['fecha_inicio'];
        $curso->fecha_fin = $data['fecha_fin'];
        $curso->id_asignatura = $data['id_asignatura'];
        $curso->estado = true;
        $curso->save();


        //Retornamos la respuesta de la creacion del curso
        return response()->json([
            "message" => "Curso creado correctamente",
            "curso" => $curso
        ], 201);
    }


    public function show($id)
    {

        //Validamos que el curso exista
        $curso = Curso::where('id', $id)->where('estado', true)->with(['docentes', 'asignaturas'])->first();

        if (!$curso) {
            return response()->json([
                "message" => "Curso no encontrado"
            ], 404);
        }

        //Retornamos la respuesta con el curso
        return response()->json([
            "message" => "Curso encontrado correctamente",
            "curso" => $curso
        ], 200);
    }


    public function update(Request $request, $id)
    {
        //Buscamos el curso por ID, validamos que exista y que este activo|
        $curso = Curso::where('id', $id)->where('estado', true)->first();

        if (!$curso) {
            return response()->json([
                "message" => "Curso no encontrado"
            ], 404);
        }

        //Validamos los datos del request para la creacion del curso
        $data = $request->validate([
            "nombre" => "nullable|string|max:255",
            "descripcion" => "nullable|string|max:1000",
            "fecha_inicio" => "nullable|date|date_format:Y-m-d", // Formato específico
            "fecha_fin" => "nullable|date|after:fecha_inicio",
            "id_asignatura" => "nullable|exists:asignaturas,id,estado,1",
            "id_docente" => "nullable|exists:docentes,id,estado,1" 
        ]);

        //Actualizamos los datos del curso
        if (isset($data['nombre'])) {
            $curso->nombre = $data['nombre'];
        }

        if (isset($data['descripcion'])) {
            $curso->descripcion = $data['descripcion'];
        }

        if (isset($data['fecha_inicio'])) {
            $curso->fecha_inicio = $data['fecha_inicio'];
        }

        if (isset($data['fecha_fin'])) {
            $curso->fecha_fin = $data['fecha_fin'];
        }

        if (isset($data['id_asignatura'])) {
            $curso->id_asignatura = $data['id_asignatura'];
        }



        if (isset($data['id_docente'])) {
            $curso->id_docente = $data['id_docente'];
        }

        $curso->save();


        return response()->json([
            "message" => "Curso actualizado correctamente",
            "curso" => $curso
        ], 200);
    }


    public function destroy($id)
    {
        //Buscamos el curso por ID, validamos que exista y que este activo
        $curso = Curso::where('id', $id)->where('estado', true)->first();

        if (!$curso) {
            return response()->json([
                "message" => "Curso no encontrado"
            ], 404);
        }

        //Eliminamos el curso lógicamente
        $curso->estado = false;
        $curso->save();

        return response()->json([
            "message" => "Curso eliminado correctamente",
            "curso" => $curso
        ], 200);
    }
}
