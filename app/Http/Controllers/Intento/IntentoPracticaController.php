<?php

namespace App\Http\Controllers\Intento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntentoAlumnoActividadPractica;

class IntentoPracticaController extends Controller
{
    public function index()
    {
        $intentos = IntentoAlumnoActividadPractica::with(['alumno', 'actividadPractica'])->get();
        return response()->json(['intentos' => $intentos], 200);
    }

    public function show($id)
    {
        $intento = IntentoAlumnoActividadPractica::with(['alumno', 'actividadPractica'])->find($id);
        if (!$intento) {
            return response()->json(['message' => 'Intento no encontrado'], 404);
        }
        return response()->json(['intento' => $intento], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_alumno' => 'required|exists:alumnos,id',
            'id_actividad_practica' => 'required|exists:actividad_practica,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'puntaje_total' => 'nullable|numeric',
            'completado' => 'nullable|boolean',
        ]);
        $intento = IntentoAlumnoActividadPractica::create($data);
        return response()->json(['intento' => $intento], 201);
    }

    public function update(Request $request, $id)
    {
        $intento = IntentoAlumnoActividadPractica::find($id);
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
        $intento = IntentoAlumnoActividadPractica::find($id);
        if (!$intento) {
            return response()->json(['message' => 'Intento no encontrado'], 404);
        }
        $intento->delete();
        return response()->json(['message' => 'Intento eliminado correctamente'], 200);
    }
}
