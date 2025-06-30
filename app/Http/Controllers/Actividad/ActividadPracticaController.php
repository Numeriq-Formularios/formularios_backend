<?php

namespace App\Http\Controllers\Actividad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActividadPractica;

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
        $data = $request->validate([
            'id_curso' => 'required|exists:cursos,id',
            'id_docente' => 'required|exists:docentes,id',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'cantidad_reactivos' => 'required|integer',
            'intentos_permitidos' => 'required|integer',
            'umbral_aprobacion' => 'required|numeric',
        ]);
        $actividad = ActividadPractica::create($data);
        return response()->json(['actividad' => $actividad], 201);
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
