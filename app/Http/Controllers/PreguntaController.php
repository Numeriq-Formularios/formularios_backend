<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Docente;
use App\Models\Tema;
use App\Models\NivelBloom;
use App\Models\Dificultad;
use App\Models\TipoPregunta;

class PreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Obtener todas las preguntas
        $preguntas = Pregunta::all();

        if (!$preguntas) {
            return response()->json([
                'message' => 'No hay preguntas disponibles'
            ], 404);
        }
        return response()->json([
            'message' => 'Lista de preguntas obtenida correctamente',
            'preguntas' => $preguntas
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = $request->user();

        $validated = $request->validate([
            'id_tema' => 'required|exists:temas,id',
            'id_nivel_bloom' => 'required|exists:nivel_blooms,id',
            'id_dificultad' => 'required|exists:dificultades,id',
            'id_tipo_pregunta' => 'required|exists:tipo_preguntas,id',
            'texto_pregunta' => 'required|string|max:255',
            'explicacion' => 'nullable|string|max:255',
            'estado' => 'required|boolean',
        ]);

        $pregunta = new Pregunta($validated);
        $pregunta->id_docente = $usuario->id; // Asignar el ID del docente autenticado
        $pregunta->save();
        return response()->json(['message' => 'Pregunta creada exitosamente'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pregunta = Pregunta::findOrFail($id);
        return response()->json($pregunta);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar que la pregunta exista
        if (!Pregunta::where('id', $id)->exists()) {
            return response()->json(['message' => 'Pregunta no encontrada'], 404);
        }
        // Buscar la pregunta por ID
        $pregunta = Pregunta::findOrFail($id);
        // Validar los datos de entrada
        $validated = $request->validate([
            'id_tema' => 'required|exists:temas,id',
            'id_nivel_bloom' => 'required|exists:nivel_blooms,id',
            'id_dificultad' => 'required|exists:dificultades,id',
            'id_tipo_pregunta' => 'required|exists:tipo_preguntas,id',
            'texto_pregunta' => 'required|string|max:255',
            'explicacion' => 'nullable|string|max:255',
            'estado' => 'required|boolean',
        ]);
            // el docente autenticado sea el que actualiza:
    $usuario = $request->user();
    $pregunta->id_docente = $usuario->id;
        // Actualizar la pregunta con los datos validados
        $pregunta->update($validated);
        // Devolver la pregunta actualizada como respuesta
        return response()->json([
            'message' => 'Pregunta actualizada correctamente',
            'pregunta' => $pregunta
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pregunta = Pregunta::findOrFail($id);
        $pregunta->estado = false;
        $pregunta->save();
        return response()->json(['message' => 'Pregunta eliminada correctamente']);
    }
}
