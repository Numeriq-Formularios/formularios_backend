<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NivelBloom;

class NivelBloomController extends Controller
{
    public function index()
    {
        return response()->json(NivelBloom::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|boolean',
        ]);

        $nivelBloom = NivelBloom::create($validated);
        $nivelBloom->save();
        return response()->json(['message' => 'Nivel de Bloom creado exitosamente'], 201);
    }

    public function show($id)
    {
        $nivelBloom = NivelBloom::findOrFail($id);
        return response()->json($nivelBloom);
    }

    public function update(Request $request, $id)
    {
// Validar que el nivel de Bloom exista
    if (!NivelBloom::where('id', $id)->exists()) {
        return response()->json(['message' => 'Nivel de Bloom no encontrado'], 404);
    }
    // Buscar el nivel de Bloom por ID
    $nivelBloom = NivelBloom::findOrFail($id);
    // Validar los datos de entrada
    $validated = $request->validate([
    'nombre' => 'required|string|max:100',
    'descripcion' => 'nullable|string|max:255',
    'estado' => 'required|boolean',
    ]);
    // Actualizar el nivel de Bloom con los datos validados
    $nivelBloom->update($validated);
    // Devolver el nivel de Bloom actualizado como respuesta
    return response()->json([
        'message' => 'Nivel de Bloom actualizado correctamente',
        'nivelBloom' => $nivelBloom
    ]);
}

    public function destroy(string $id)
    {
        $nivelBloom = NivelBloom::findOrFail($id);
        $nivelBloom->estado = false;
        $nivelBloom->save();
        return response()->json(['message' => 'Nivel de Bloom eliminado correctamente']);
    }
}