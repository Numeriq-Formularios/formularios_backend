<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpcionRespuesta;
use App\Models\Pregunta;

class OpcionRespuestaController extends Controller
{
    
    public function index()
    {
        return response()->json(OpcionRespuesta::all());

    }

    public function store(Request $request)
    {
  $validated = $request->validate([
    'id_pregunta' => 'required|exists:preguntas,id',
    'texto_opcion' => 'required|string|max:255',
    'es_correcta' => 'required|boolean',
]);

        $opcionRespuesta = new OpcionRespuesta($validated);
        $opcionRespuesta->save();
        return response()->json(['message' => 'Opción de respuesta creada exitosamente'], 201);
    }


public function show($id)
{
    $opcionRespuesta = OpcionRespuesta::findOrFail($id);
    return response()->json($opcionRespuesta);
}

    public function update(Request $request, $id)
    {
    // Validar que la opción de respuesta exista
    if (!OpcionRespuesta::where('id', $id)->exists()) {
        return response()->json(['message' => 'Opción de respuesta no encontrada'], 404);
    }
    // Buscar la opción de respuesta por ID
    $opcionRespuesta = OpcionRespuesta::findOrFail($id);
    // Validar los datos de entrada
    $validated = $request->validate([
    'id_pregunta' => 'required|exists:preguntas,id',
    'texto_opcion' => 'required|string|max:255',
    'es_correcta' => 'required|boolean',
    ]);
    // Actualizar la opción de respuesta con los datos validados
    $opcionRespuesta->update($validated);
    // Devolver la opción de respuesta actualizada como respuesta
    return response()->json([
        'message' => 'Opción de respuesta actualizada correctamente',
        'opcion_respuesta' => $opcionRespuesta
    ]);
}

    public function destroy(string $id)
    {
        $opcionRespuesta = OpcionRespuesta::findOrFail($id);
        $opcionRespuesta->delete();
        return response()->json(['message' => 'Opción de respuesta eliminada correctamente']);

    }
}

