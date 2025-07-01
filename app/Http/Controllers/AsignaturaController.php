<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asignatura;

class AsignaturaController extends Controller
{
    public function index()
    {
        return response()->json(Asignatura::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|boolean',
        ]);

        $asignatura = Asignatura::create($validated);
        $asignatura->save();
        return response()->json(['message' => 'Asignatura creada exitosamente'], 201);
    }

    public function show($id)
    {
        $asignatura = Asignatura::findOrFail($id);
        return response()->json($asignatura);
    }

    public function update(Request $request, $id)
    {
// Validar que la asignatura exista
    if (!Asignatura::where('id', $id)->exists()) {
        return response()->json(['message' => 'Asignatura no encontrada'], 404);
    }
    // Buscar la asignatura por ID
    $asignatura = Asignatura::findOrFail($id);
    // Validar los datos de entrada
    $validated = $request->validate([
    'nombre' => 'required|string|max:100',
    'descripcion' => 'nullable|string|max:255',
    'estado' => 'required|boolean',
    ]);
    // Actualizar la asignatura con los datos validados
    $asignatura->update($validated);
    // Devolver la asignatura actualizada como respuesta
    return response()->json([
        'message' => 'Asignatura actualizada correctamente',
        'asignatura' => $asignatura
    ]);
}

    public function destroy(string $id)
    {
        $asignatura = Asignatura::findOrFail($id);
        $asignatura->estado = false;
        $asignatura->save();
        return response()->json(['message' => 'Asignatura eliminada correctamente']);
    }
}