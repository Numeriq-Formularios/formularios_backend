<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActividadExamen;
use App\Models\Curso;
use App\Models\Docente;


class ActividadExamenController extends Controller
{

    public function index()
    {
        return response()->json(ActividadExamen::all());

    }

    public function store(Request $request)
    {
  $validated = $request->validate([
    'id_curso' => 'required|exists:cursos,id',
    'id_docente' => 'required|exists:docentes,id',
    'nombre' => 'required|string|max:100',
    'descripcion' => 'nullable|string|max:255',
    'modo' => 'nullable|string|max:50',
    'cantidad_reactivos' => 'required|integer',
    'tiempo_limite' => 'nullable|integer',
    'intentos_permitidos' => 'required|integer',
    'aleatorizar_preguntas' => 'required|boolean',
    'aleatorizar_opciones' => 'required|boolean',
    'umbral_aprobacion' => 'required|numeric',
    'estado' => 'required|boolean',
]);
     
        $actividadExamen = new ActividadExamen($validated);
        $actividadExamen->save();
        return response()->json(['message' => 'Actividad Examen creada exitosamente'], 201);
    }


public function show($id)
{
    $actividad = ActividadExamen::findOrFail($id);
        return response()->json($actividad);
    }

    public function update(Request $request, $id)
    {
    // Validar que la actividad exista
    if (!ActividadExamen::where('id', $id)->exists()) {
        return response()->json(['message' => 'Actividad Examen no encontrada'], 404);
    }
    // Buscar la actividad por ID
    $actividad = ActividadExamen::findOrFail($id);
    // Validar los datos de entrada
    $validated = $request->validate([
        'id_curso' => 'required|exists:cursos,id',
        'id_docente' => 'required|exists:docentes,id',
        'nombre' => 'required|string|max:100',
        'descripcion' => 'nullable|string|max:255',
        'modo' => 'nullable|string|max:50',
        'cantidad_reactivos' => 'required|integer',
        'tiempo_limite' => 'nullable|integer',
        'intentos_permitidos' => 'required|integer',
        'aleatorizar_preguntas' => 'required|boolean',
        'aleatorizar_opciones' => 'required|boolean',
        'umbral_aprobacion' => 'required|numeric',
        'estado' => 'required|boolean',
    ]);
    // Actualizar la actividad con los datos validados
    $actividad->update($validated);
    // Devolver la actividad actualizada como respuesta
    return response()->json([
        'message' => 'Actividad Examen actualizada correctamente',
        'actividad' => $actividad
    ]);
}

    public function destroy(string $id)
    {
        $actividadExamen = ActividadExamen::findOrFail($id);
        $actividadExamen->estado = false;
        $actividadExamen->save();
        return response()->json(['message' => 'Actividad Examen eliminada correctamente']);

    }
}

