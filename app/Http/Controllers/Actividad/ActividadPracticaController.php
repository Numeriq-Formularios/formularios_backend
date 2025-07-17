<?php

namespace App\Http\Controllers\Actividad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActividadPractica;
use Illuminate\Support\Facades\DB;

class ActividadPracticaController extends Controller
{
    public function index()
    {
        $actividades = ActividadPractica::with(['docente', 'curso'])->get();
        return response()->json(['actividades' => $actividades], 200);
    }

    public function show($id)
    {
        $actividad = ActividadPractica::with(['docente', 'curso'])->find($id);
        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }
        return response()->json(['actividad' => $actividad], 200);
    }

    public function store(Request $request)
    {
        $usuario = $request->user();

        $validated = $request->validate([
            'id_curso' => 'required|exists:cursos,id',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'cantidad_reactivos' => 'required|integer',
            'intentos_permitidos' => 'required|integer',
            'umbral_aprobacion' => 'required|numeric',
            // Filtros opcionales
            'id_tema' => 'nullable|exists:temas,id',
            'id_dificultad' => 'nullable|exists:dificultades,id',
            'id_nivel_bloom' => 'nullable|exists:nivel_blooms,id',
            'id_tipo_pregunta' => 'nullable|exists:tipo_preguntas,id',
        ]);

        DB::beginTransaction();
        try {
            // Asignar el docente actual
            $actividad = new \App\Models\ActividadPractica($validated);
            $actividad->id_docente = $usuario->id;
            $actividad->estado = true;
            $actividad->save();

            // Selección de preguntas según los filtros
            $query = \App\Models\Pregunta::where('estado', true)
                ->where('id_docente', $usuario->id);

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

            $preguntas = $query->inRandomOrder()->limit($validated['cantidad_reactivos'])->get();

            if ($preguntas->count() < $validated['cantidad_reactivos']) {
                throw new \Exception('No hay suficientes preguntas disponibles con los criterios especificados.');
            }

            // Asignar preguntas a la actividad práctica con orden
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
            $actividad->preguntas()->attach($preguntasData);

            DB::commit();

            return response()->json([
                'message' => 'Actividad Práctica creada exitosamente',
                'actividad' => $actividad->load('preguntas'),
                'preguntas_asignadas' => $preguntas->count()
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear la actividad práctica',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $actividad = ActividadPractica::find($id);
        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }
        $data = $request->validate([
            'nombre' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string',
            'cantidad_reactivos' => 'nullable|integer',
            'intentos_permitidos' => 'nullable|integer',
            'umbral_aprobacion' => 'nullable|numeric',
            'estado' => 'nullable|boolean',
        ]);
        $actividad->update($data);
        return response()->json(['actividad' => $actividad], 200);
    }

    public function destroy($id)
    {
        $actividad = ActividadPractica::find($id);
        if (!$actividad) {
            return response()->json(['message' => 'Actividad no encontrada'], 404);
        }
        $actividad->estado = false;
        $actividad->save();
        return response()->json(['message' => 'Actividad eliminada correctamente'], 200);
    }
}
