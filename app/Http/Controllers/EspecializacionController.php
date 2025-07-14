<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especializacion;

class EspecializacionController extends Controller
{
    //Aqui estan las funciones de Especialidad

    public function store(Request $request){

        //Validamos los datos del request para la creacion del curso
        $data = $request->validate([
            "nombre" => "required|string|max:255",
            "descripcion" => "required|string|max:1000",
        ]);

        $especialidad = new Especializacion();
        $especialidad->nombre = $data['nombre'];
        $especialidad->descripcion = $data['descripcion'];
        $especialidad->save();

        return response()->json([
            "message" => "Especialidad creada correctamente",
            "especialidad" => $especialidad
        ], 201);
    }


    public function index()
    {
        //Validamos que las especializaciones existan
        $especializaciones = Especializacion::all();

        //Si no existen especializaciones, retornamos un mensaje
        if ($especializaciones->isEmpty()) {
            return response()->json([
                "message" => "No existen especializaciones"
            ], 404);
        }

        //Retornamos la respuesta con las especializaciones
        return response()->json([
            "message" => "Lista de especializaciones obtenida correctamente",
            "especializaciones" => $especializaciones
        ]);
    }

    public function show($id)
    {
        $especialidad = Especializacion::find($id);

        if (!$especialidad) {
            return response()->json([
                "message" => "Especialidad no encontrada"
            ], 404);
        }

        return response()->json([
            "message" => "Especialidad obtenida correctamente",
            "especialidad" => $especialidad
        ]);
    }

    public function update(Request $request, $id)
    {
        $especialidad = Especializacion::find($id);

        if (!$especialidad) {
            return response()->json([
                "message" => "Especialidad no encontrada"
            ], 404);
        }

        $data = $request->validate([
            "nombre" => "sometimes|required|string|max:255",
            "descripcion" => "sometimes|required|string|max:1000",
        ]);

        $especialidad->update($data);

        return response()->json([
            "message" => "Especialidad actualizada correctamente",
            "especialidad" => $especialidad
        ]);
    }

    public function destroy($id)
    {
        $especialidad = Especializacion::find($id);

        if (!$especialidad) {
            return response()->json([
                "message" => "Especialidad no encontrada"
            ], 404);
        }

        $especialidad->delete();

        return response()->json([
            "message" => "Especialidad eliminada correctamente"
        ]);
    }
}
