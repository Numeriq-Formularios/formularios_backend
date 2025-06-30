<?php

namespace App\Http\Controllers\Actividad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PreguntaActividadPractica;

class PreguntaActividadPracticaController extends Controller
{
    public function index()
    {
        $preguntas = PreguntaActividadPractica::all();
        return response()->json(['preguntas' => $preguntas], 200);
    }

    public function show($id)
    {
        $pregunta = PreguntaActividadPractica::find($id);
        if (!$pregunta) {
            return response()->json(['message' => 'Pregunta no encontrada'], 404);
        }
        return response()->json(['pregunta' => $pregunta], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_actividad_practica' => 'required|exists:actividad_practica,id',
            'id_pregunta' => 'required|exists:preguntas,id',
            'orden' => 'nullable|integer',
        ]);
        $pregunta = PreguntaActividadPractica::create($data);
        return response()->json(['pregunta' => $pregunta], 201);
    }

    public function update(Request $request, $id)
    {
        $pregunta = PreguntaActividadPractica::find($id);
        if (!$pregunta) {
            return response()->json(['message' => 'Pregunta no encontrada'], 404);
        }
        $data = $request->validate([
            'orden' => 'nullable|integer',
        ]);
        $pregunta->update($data);
        return response()->json(['pregunta' => $pregunta], 200);
    }

    public function destroy($id)
    {
        $pregunta = PreguntaActividadPractica::find($id);
        if (!$pregunta) {
            return response()->json(['message' => 'Pregunta no encontrada'], 404);
        }
        $pregunta->delete();
        return response()->json(['message' => 'Pregunta eliminada correctamente'], 200);
    }
}
