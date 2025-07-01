<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dificultad;

class DificultadController extends Controller
{
  
    public function index()
    {
        return response()->json(Dificultad::all());

    }

    public function store(Request $request)
    {
  $validated = $request->validate([

    'nivel' => 'required|string|max:50',
 
]);

        $dificultad = new Dificultad($validated);
        $dificultad->save();
        return response()->json(['message' => 'Dificultad creada exitosamente'], 201);
    }


public function show($id)
{
    $dificultad = Dificultad::findOrFail($id);
    return response()->json($dificultad);
}

    public function update(Request $request, $id)
    {
    // Validar que la dificultad exista
    if (!Dificultad::where('id', $id)->exists()) {
        return response()->json(['message' => 'Dificultad no encontrada'], 404);
    }
    // Buscar la dificultad por ID
    $dificultad = Dificultad::findOrFail($id);
    // Validar los datos de entrada
    $validated = $request->validate([
    'nivel' => 'required|string|max:50',

    ]);
    // Actualizar la dificultad con los datos validados
    $dificultad->update($validated);
    // Devolver la dificultad actualizada como respuesta
    return response()->json([
        'message' => 'Dificultad actualizada correctamente',
        'dificultad' => $dificultad
    ]);
}

    public function destroy(string $id)
    {
        $dificultad = Dificultad::findOrFail($id);
        $dificultad->delete();
        return response()->json(['message' => 'Dificultad eliminada correctamente']);

    }
}

