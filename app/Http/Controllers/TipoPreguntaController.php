<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoPregunta;

class TipoPreguntaController extends Controller
{
 
    public function index()
    {
        return response()->json(TipoPregunta::all());

    }

    public function store(Request $request)
    {
  $validated = $request->validate([
    'tipo' => 'required|string|max:50',
    'estado' => 'required|boolean',
]);

        $tipoPregunta = new TipoPregunta($validated);
        $tipoPregunta->save();
        return response()->json(['message' => 'Tipo de Pregunta creado exitosamente'], 201);
    }


public function show($id)
{
    $tipoPregunta = TipoPregunta::find($id);

    if(!$tipoPregunta) {
        return response()->json(['message' => 'Tipo de Pregunta no encontrada'], 404);
    }
    return response()->json($tipoPregunta);
}

    public function update(Request $request, $id)
    {
    if (!TipoPregunta::where('id', $id)->exists()) {
        return response()->json(['message' => 'Tipo de Pregunta no encontrada'], 404);
    }
    // Buscar el tipo de pregunta por ID
    $tipoPregunta = TipoPregunta::findOrFail($id);
    // Validar los datos de entrada
    $validated = $request->validate([
     'tipo' => 'required|string|max:50',
    'estado' => 'required|boolean',
    ]);
    // Actualizar el tipo de pregunta con los datos validados
    $tipoPregunta->update($validated);
    // Devolver el tipo de pregunta actualizado como respuesta
    return response()->json([
        'message' => 'Tipo de Pregunta actualizada correctamente',
        'tipo_pregunta' => $tipoPregunta
    ]);
}

    public function destroy(string $id)
    {
        $tipoPregunta = TipoPregunta::findOrFail($id);
        $tipoPregunta->estado = false;
        $tipoPregunta->save();
        return response()->json(['message' => 'Tipo de Pregunta eliminada correctamente']);

    }
}

