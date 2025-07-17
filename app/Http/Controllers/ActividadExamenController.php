<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActividadExamen;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Pregunta;
use Illuminate\Support\Facades\DB;

class ActividadExamenController extends Controller
{
    public function index()
    {
        $actividades = ActividadExamen::with(['docente', 'curso'])->get();
        return response()->json(['actividades' => $actividades], 200);
    }

    public function store(Request $request)
    {
        $usuario = $request->user();

        $validated = $request->validate([
            'id_curso' => 'required|exists:cursos,id',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'modo' => 'nullable|string|max:50',
            'cantidad_reactivos' => 'required|integer|min:1',
            'tiempo_limite' => 'nullable|integer',
            'intentos_permitidos' => 'required|integer',
            'aleatorizar_preguntas' => 'required|boolean',
            'aleatorizar_opciones' => 'required|boolean',
            'umbral_aprobacion' => 'required|numeric',
            'estado' => 'required|boolean',
            // Filtros opcionales
            'id_tema' => 'nullable|exists:temas,id',
            'id_dificultad' => 'nullable|exists:dificultades,id',
            'id_nivel_bloom' => 'nullable|exists:nivel_blooms,id',
            'id_tipo_pregunta' => 'nullable|exists:tipo_preguntas,id',
        ]);

        DB::beginTransaction();
        try {
            // Asignar el docente actual
            $actividadExamen = new ActividadExamen($validated);
            $actividadExamen->id_docente = $usuario->id;
            $actividadExamen->save();

            // Selección de preguntas según los filtros
            $query = Pregunta::where('estado', true)
                ->where('id_docente', $usuario->id); // Solo preguntas del docente actual

            if (isset($validated['id_tema'])) {
                $query->where('id_tema', $validated['id_tema']);
            }
            if (isset($validated['id_dificultad'])) {
                $query->where('id_dificultad', $validated['id_dificultad']);
            }
            if (isset($validated['id_nivel_bloom'])) {
                $query->where('id_nivel_bloom', $validated['id_nivel_bloom']);
            }
            if (isset($validated['id_tipo_pregunta'])) {
                $query->where('id_tipo_pregunta', $validated['id_tipo_pregunta']);
            }

            if ($validated['aleatorizar_preguntas']) {
                $query->inRandomOrder();
            }

            $preguntas = $query->limit($validated['cantidad_reactivos'])->get();

            if ($preguntas->count() < $validated['cantidad_reactivos']) {
                throw new \Exception('No hay suficientes preguntas disponibles con los criterios especificados.');
            }

            // Asignar preguntas a la actividad examen con orden
            $orden = 1;
            $preguntasData = [];
            foreach ($preguntas as $pregunta) {
                $preguntasData[$pregunta->id] = [
                    'orden' => $orden,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $orden++;
            }
            $actividadExamen->preguntas()->attach($preguntasData);

            DB::commit();

            return response()->json([
                'message' => 'Actividad Examen creada exitosamente',
                'actividad' => $actividadExamen->load('preguntas'),
                'preguntas_asignadas' => $preguntas->count()
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear la actividad examen',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        $actividad = ActividadExamen::with(['preguntas' => function($query) {
            $query->orderBy('pregunta_actividad_examen.orden');
        }])->findOrFail($id);
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
    // el docente autenticado sea el que actualiza:
    $usuario = $request->user();
    $actividad->id_docente = $usuario->id;
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
