<?php

namespace App\Http\Controllers\Intento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntentoAlumnoActividadExamen;

class IntentoExamenController extends Controller
{
    public function index()
    {
        $intentos = IntentoAlumnoActividadExamen::with(['alumno', 'actividadExamen'])->get();
        return response()->json(['intentos' => $intentos], 200);
    }

    public function show($id)
    {
        $intento = IntentoAlumnoActividadExamen::with(['alumno', 'actividadExamen'])->find($id);
        if (!$intento) {
            return response()->json(['message' => 'Intento no encontrado'], 404);
        }
        return response()->json(['intento' => $intento], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_alumno' => 'required|exists:alumnos,id',
            'id_actividad_examen' => 'required|exists:actividad_examenes,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'puntaje_total' => 'nullable|numeric',
            'completado' => 'nullable|boolean',
        ]);
        $intento = IntentoAlumnoActividadExamen::create($data);
        return response()->json(['intento' => $intento], 201);
    }

    public function update(Request $request, $id)
    {
        $intento = IntentoAlumnoActividadExamen::find($id);
        if (!$intento) {
            return response()->json(['message' => 'Intento no encontrado'], 404);
        }
        $data = $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'puntaje_total' => 'nullable|numeric',
            'completado' => 'nullable|boolean',
        ]);
        $intento->update($data);
        return response()->json(['intento' => $intento], 200);
    }

    public function destroy($id)
    {
        $intento = IntentoAlumnoActividadExamen::find($id);
        if (!$intento) {
            return response()->json(['message' => 'Intento no encontrado'], 404);
        }
        $intento->delete();
        return response()->json(['message' => 'Intento eliminado correctamente'], 200);
    }
}
