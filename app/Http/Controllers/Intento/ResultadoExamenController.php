<?php

namespace App\Http\Controllers\Intento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResultadoPreguntaActividadExamen;

class ResultadoExamenController extends Controller
{
    public function index()
    {
        $resultados = ResultadoPreguntaActividadExamen::with(['intento', 'opcionRespuesta', 'pregunta'])->get();
        return response()->json(['resultados' => $resultados], 200);
    }

    public function show($id)
    {
        $resultado = ResultadoPreguntaActividadExamen::with(['intento', 'opcionRespuesta', 'pregunta'])->find($id);
        if (!$resultado) {
            return response()->json(['message' => 'Resultado no encontrado'], 404);
        }
        return response()->json(['resultado' => $resultado], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_intento' => 'required|exists:intento_alumno_actividad_examen,id',
            'id_opcion_res' => 'nullable|exists:opcion_respuestas,id',
            'id_pregunta' => 'required|exists:preguntas,id',
            'respuesta_texto' => 'nullable|string',
            'es_correcta' => 'nullable|boolean',
            'puntaje_obtenido' => 'nullable|numeric',
            'explicacion_docente' => 'nullable|string',
            'estado' => 'nullable|boolean',
        ]);
        $resultado = ResultadoPreguntaActividadExamen::create($data);
        return response()->json(['resultado' => $resultado], 201);
    }

    public function update(Request $request, $id)
    {
        $resultado = ResultadoPreguntaActividadExamen::find($id);
        if (!$resultado) {
            return response()->json(['message' => 'Resultado no encontrado'], 404);
        }
        $data = $request->validate([
            'respuesta_texto' => 'nullable|string',
            'es_correcta' => 'nullable|boolean',
            'puntaje_obtenido' => 'nullable|numeric',
            'explicacion_docente' => 'nullable|string',
            'estado' => 'nullable|boolean',
        ]);
        $resultado->update($data);
        return response()->json(['resultado' => $resultado], 200);
    }

    public function destroy($id)
    {
        $resultado = ResultadoPreguntaActividadExamen::find($id);
        if (!$resultado) {
            return response()->json(['message' => 'Resultado no encontrado'], 404);
        }
        $resultado->delete();
        return response()->json(['message' => 'Resultado eliminado correctamente'], 200);
    }
}
