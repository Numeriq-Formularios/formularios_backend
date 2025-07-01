<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PreguntaActividadExamen;
use App\Models\ActividadExamen;
use App\Models\Pregunta;

class PreguntaActividadExamenController extends Controller
{
   
    public function index()
    {
        return response()->json(PreguntaActividadExamen::all());

    }

    public function store(Request $request)
    {
  $validated = $request->validate([
    'id_actividad_examen' => 'required|exists:actividad_examenes,id',
    'id_pregunta' => 'required|exists:preguntas,id',
    'orden' => 'nullable|integer',
]);

        $preguntaActividadExamen = new PreguntaActividadExamen($validated);
        $preguntaActividadExamen->save();
        return response()->json(['message' => 'Pregunta Actividad Examen creada exitosamente'], 201);
    }


public function show($id)
{
    $preguntaActividadExamen = PreguntaActividadExamen::findOrFail($id);
    return response()->json($preguntaActividadExamen);
}

    public function update(Request $request, $id)
    {
    // Validar que la pregunta actividad examen exista
    if (!PreguntaActividadExamen::where('id', $id)->exists()) {
        return response()->json(['message' => 'Pregunta Actividad Examen no encontrada'], 404);
    }
    $preguntaActividadExamen = PreguntaActividadExamen::findOrFail($id);
    // Validar los datos de entrada
    $validated = $request->validate([
    'id_actividad_examen' => 'required|exists:actividad_examenes,id',
    'id_pregunta' => 'required|exists:preguntas,id',
    'orden' => 'nullable|integer',
    ]);
    // Actualizar la pregunta actividad examen con los datos validados
    $preguntaActividadExamen->update($validated);
    // Devolver la pregunta actividad examen actualizada como respuesta
    return response()->json([
        'message' => 'Pregunta Actividad Examen actualizada correctamente',
        'pregunta' => $preguntaActividadExamen
    ]);
}

    public function destroy(string $id)
    {
        $preguntaActividadExamen = PreguntaActividadExamen::findOrFail($id);
        $preguntaActividadExamen->delete();
        return response()->json(['message' => 'Pregunta Actividad Examen eliminada correctamente']);

    }
}

