<?php

namespace App\Http\Controllers\Intento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntentoAlumnoActividadExamen;
use App\Models\Alumno;
use App\Models\ActividadExamen;
use App\Models\CursoAlumno;
use App\Models\ResultadoPreguntaActividadExamen;
use Illuminate\Support\Facades\DB;

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
        // El usuario que hace la petición es el alumno
        $usuario = $request->user();

        // Validar datos de entrada
        $data = $request->validate([
            'id_actividad_examen' => 'required|exists:actividad_examenes,id',
        ]);

        DB::beginTransaction();
        try {
            // VALIDAR que el usuario sea un alumno válido
            $alumno = Alumno::where('id', $usuario->id)->first();
            if (!$alumno) {
                return response()->json([
                    'message' => 'Usuario no es un alumno válido'
                ], 403);
            }

            // OBTENER la actividad examen con sus preguntas enlazadas
            $actividadExamen = ActividadExamen::with(['preguntas' => function ($query) {
                $query->orderBy('pregunta_actividad_examenes.orden')
                    ->with('opcionesRespuesta');
            }])->find($data['id_actividad_examen']);

            if (!$actividadExamen || !$actividadExamen->estado) {
                return response()->json([
                    'message' => 'Actividad examen no disponible'
                ], 404);
            }

            // VERIFICAR que el alumno esté inscrito en el curso
            $inscripcion = CursoAlumno::where('id_alumno', $alumno->id)
                ->where('id_curso', $actividadExamen->id_curso)
                ->where('estado', 1)
                ->first();

            if (!$inscripcion) {
                return response()->json([
                    'message' => 'No estás inscrito en el curso de esta actividad'
                ], 403);
            }

            // VERIFICAR límite de intentos
            $intentosRealizados = IntentoAlumnoActividadExamen::where('id_alumno', $alumno->id)
                ->where('id_actividad_examen', $actividadExamen->id)
                ->count();

            if ($intentosRealizados >= $actividadExamen->intentos_permitidos) {
                return response()->json([
                    'message' => 'Has excedido el límite de intentos permitidos'
                ], 403);
            }

            // CREAR el IntentoAlumnoActividadExamen
            $intento = IntentoAlumnoActividadExamen::create([
                'id_alumno' => $alumno->id,
                'id_actividad_examen' => $actividadExamen->id,
                'fecha_inicio' => now(),
                'fecha_fin' => null,
                'puntaje_total' => 0,
                'completado' => false,
            ]);

            // CREAR ResultadoPreguntaActividadExamen para cada pregunta
            foreach ($actividadExamen->preguntas as $pregunta) {
                ResultadoPreguntaActividadExamen::create([
                    'id_intento' => $intento->id,
                    'id_pregunta' => $pregunta->id,
                    'id_opcion_res' => null,
                    'respuesta_texto' => null,
                    'es_correcta' => false,
                    'puntaje_obtenido' => 0,
                    'explicacion_docente' => null,
                    'estado' => 1
                ]);
            }

            DB::commit();

            // PREPARAR respuesta solo con las preguntas
            $preguntas = $actividadExamen->preguntas->map(function ($pregunta) {
                return [
                    'id' => $pregunta->id,
                    'texto_pregunta' => $pregunta->texto_pregunta,
                    'orden' => $pregunta->pivot->orden,
                    'opciones' => $pregunta->opcionesRespuesta->map(function ($opcion) {
                        return [
                            'id' => $opcion->id,
                            'texto' => $opcion->texto_opcion,
                        ];
                    })
                ];
            });

            return response()->json([
                'message' => 'Intento iniciado exitosamente',
                'intento_id' => $intento->id,
                'preguntas' => $preguntas
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear el intento',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function responderPregunta(Request $request, $intentoId)
    {
        $data = $request->validate([
            'id_pregunta' => 'required|exists:preguntas,id',
            'id_opcion_res' => 'required|exists:opcion_respuestas,id',
            'respuesta_texto' => 'nullable|string|max:1000'
        ]);

        $usuario = $request->user();

        DB::beginTransaction();
        try {
            //VERIFICAR que el intento pertenece al usuario
            $intento = IntentoAlumnoActividadExamen::where('id', $intentoId)
                ->where('id_alumno', $usuario->id)
                ->first();

            if (!$intento) {
                return response()->json([
                    'message' => 'Intento no encontrado o no autorizado'
                ], 404);
            }

            if ($intento->completado) {
                return response()->json([
                    'message' => 'El intento ya está completado'
                ], 403);
            }

            // VERIFICAR que la pregunta pertenece a esta actividad examen
            $actividadExamen = ActividadExamen::with('preguntas')
                ->find($intento->id_actividad_examen);

            $preguntaEnActividad = $actividadExamen->preguntas
                ->where('id', $data['id_pregunta'])
                ->first();

            if (!$preguntaEnActividad) {
                return response()->json([
                    'message' => 'La pregunta no pertenece a esta actividad examen'
                ], 400);
            }

            // VERIFICAR que la opción pertenece a la pregunta
            $opcionSeleccionada = \App\Models\OpcionRespuesta::where('id', $data['id_opcion_res'])
                ->where('id_pregunta', $data['id_pregunta'])
                ->first();

            if (!$opcionSeleccionada) {
                return response()->json([
                    'message' => 'La opción de respuesta no pertenece a esta pregunta'
                ], 400);
            }

            // BUSCAR el resultado de la pregunta
            $resultado = ResultadoPreguntaActividadExamen::where('id_intento', $intento->id)
                ->where('id_pregunta', $data['id_pregunta'])
                ->first();

            if (!$resultado) {
                return response()->json([
                    'message' => 'Resultado de pregunta no encontrado'
                ], 404);
            }

            // VERIFICAR si la opción seleccionada es correcta
            $esCorrecta = $opcionSeleccionada->es_correcta;
            $puntajeObtenido = $esCorrecta ? 1 : 0;

            // ACTUALIZAR el resultado
            $resultado->update([
                'id_opcion_res' => $data['id_opcion_res'],
                'respuesta_texto' => $data['respuesta_texto'],
                'es_correcta' => $esCorrecta,
                'puntaje_obtenido' => $puntajeObtenido,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Respuesta guardada exitosamente',
                'resultado' => [
                    'id' => $resultado->id,
                    'id_pregunta' => $resultado->id_pregunta,
                    'id_opcion_res' => $resultado->id_opcion_res,
                    'respuesta_texto' => $resultado->respuesta_texto,
                    'puntaje_obtenido' => $resultado->puntaje_obtenido,
                    'es_correcta' => $resultado->es_correcta,
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al guardar la respuesta',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function finalizarIntento(Request $request, $intentoId)
    {
        $usuario = $request->user();

        DB::beginTransaction();
        try {
            //VERIFICAR que el intento pertenece al usuario
            $intento = IntentoAlumnoActividadExamen::where('id', $intentoId)
                ->where('id_alumno', $usuario->id)
                ->with(['resultados', 'actividadExamen'])
                ->first();

            if (!$intento) {
                return response()->json([
                    'message' => 'Intento no encontrado o no autorizado'
                ], 404);
            }

            if ($intento->completado) {
                return response()->json([
                    'message' => 'El intento ya está completado'
                ], 403);
            }

            // VERIFICAR que todas las preguntas han sido respondidas
            $preguntasSinResponder = $intento->resultados()
                ->whereNull('id_opcion_res')
                ->count();

            if ($preguntasSinResponder > 0) {
                return response()->json([
                    'message' => 'Aún hay preguntas sin responder',
                    'preguntas_sin_responder' => $preguntasSinResponder
                ], 400);
            }

            // CALCULAR puntaje total
            $respuestasCorrectas = $intento->resultados->where('es_correcta', true)->count();
            $totalPreguntas = $intento->resultados->count();
            $puntajeTotal = ($totalPreguntas > 0) ? ($respuestasCorrectas / $totalPreguntas) * 100 : 0;

            // FINALIZAR intento
            $intento->update([
                'fecha_fin' => now(),
                'puntaje_total' => $puntajeTotal,
                'completado' => true,
            ]);

            DB::commit();

            // DETERMINAR si aprobó
            $umbralAprobacion = $intento->actividadExamen->umbral_aprobacion;
            $aprobado = $puntajeTotal >= $umbralAprobacion;

            //PREPARAR respuesta con resultados detallados
            $resultadosDetallados = $intento->resultados->map(function ($resultado) {
                return [
                    'id_pregunta' => $resultado->id_pregunta,
                    'id_opcion_seleccionada' => $resultado->id_opcion_res,
                    'respuesta_texto' => $resultado->respuesta_texto,
                    'es_correcta' => $resultado->es_correcta,
                    'puntaje_obtenido' => $resultado->puntaje_obtenido,
                ];
            });

            return response()->json([
                'message' => 'Intento finalizado exitosamente',
                'intento' => [
                    'id' => $intento->id,
                    'fecha_inicio' => $intento->fecha_inicio,
                    'fecha_fin' => $intento->fecha_fin,
                    'completado' => $intento->completado,
                    'puntaje_total' => round($puntajeTotal, 2),
                ],
                'actividad_examen' => [
                    'id' => $intento->actividadExamen->id,
                    'nombre' => $intento->actividadExamen->nombre,
                    'umbral_aprobacion' => floatval($umbralAprobacion),
                ],
                'resultados' => [
                    'respuestas_correctas' => $respuestasCorrectas,
                    'total_preguntas' => $totalPreguntas,
                    'porcentaje' => round($puntajeTotal, 2),
                    'aprobado' => $aprobado,
                    'calificacion' => $aprobado ? 'APROBADO' : 'REPROBADO',
                ],
                'detalle_respuestas' => $resultadosDetallados
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al finalizar el intento',
                'error' => $e->getMessage()
            ], 500);
        }
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


    public function misIntentos(Request $request)
    {
        $usuario = $request->user();
        $intentos = IntentoAlumnoActividadExamen::with(['actividadExamen'])
            ->where('id_alumno', $usuario->id)
            ->get();

        if ($intentos->isEmpty()) {
            return response()->json(['message' => 'No tienes intentos registrados'], 404);
        }

        return response()->json(['intentos' => $intentos], 200);
    }
}
