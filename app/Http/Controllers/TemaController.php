<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tema;
use App\Models\Asignatura;


class TemaController extends Controller
{
  
    public function index()
    {
        return response()->json(Tema::all());

    }

    public function store(Request $request)
    {
  $validated = $request->validate([
    'id_asignatura' => 'required|exists:asignaturas,id',
    'nombre' => 'required|string|max:100',
    'estado' => 'required|boolean',
]);

        $tema = new Tema($validated);
        $tema->save();
        return response()->json(['message' => 'Tema creado exitosamente'], 201);
    }


public function show($id)
{
    $tema = Tema::findOrFail($id);
    return response()->json($tema);
}

    public function update(Request $request, $id)
    {
    // Validar que la actividad exista
    if (!Tema::where('id', $id)->exists()) {
        return response()->json(['message' => 'Tema no encontrado'], 404);
    }
    // Buscar la actividad por ID
    $tema = Tema::findOrFail($id);
    // Validar los datos de entrada
    $validated = $request->validate([
    'id_asignatura' => 'required|exists:asignaturas,id',
    'nombre' => 'required|string|max:100',
    'estado' => 'required|boolean',
    ]);
    // Actualizar la actividad con los datos validados
    $tema->update($validated);
    // Devolver la actividad actualizada como respuesta
    return response()->json([
        'message' => 'Tema actualizado correctamente',
        'tema' => $tema
    ]);
}

    public function destroy(string $id)
    {
        $tema = Tema::findOrFail($id);
        $tema->estado = false;
        $tema->save();
        return response()->json(['message' => 'Tema eliminado correctamente']);

    }
}

