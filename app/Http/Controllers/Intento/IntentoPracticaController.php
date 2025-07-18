<?php

namespace App\Http\Controllers\Intento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntentoAlumnoActividadPractica;
use App\Models\Alumno;
use App\Models\ActividadPractica;
use App\Models\CursoAlumno;
use App\Models\ResultadoPreguntaActividadPractica;
use Illuminate\Support\Facades\DB;

class IntentoPracticaController extends Controller
{
    //Lista todos los intentos de actividades practica existetes
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
        // El usuario que hace la petición es el alumno
        $usuario = $request->user();

        // Validar datos de entrada
        $data = $request->validate([
            'id_actividad_practica' => 'required|exists:actividad_practica,id',
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

            // OBTENER la actividad práctica con sus preguntas enlazadas
            $actividadPractica = ActividadPractica::with(['preguntas' => function ($query) {
                $query->orderBy('pregunta_actividad_practica.orden')
                    ->with('opcionesRespuesta');
            }])->find($data['id_actividad_practica']);

            if (!$actividadPractica || !$actividadPractica->estado) {
                return response()->json([
                    'message' => 'Actividad práctica no disponible'
                ], 404);
            }

            // VERIFICAR que el alumno esté inscrito en el curso
            $inscripcion = CursoAlumno::where('id_alumno', $alumno->id)
                ->where('id_curso', $actividadPractica->id_curso)
                ->where('estado', 1)
                ->first();

            if (!$inscripcion) {
                return response()->json([
                    'message' => 'No estás inscrito en el curso de esta actividad'
                ], 403);
            }

            // VERIFICAR límite de intentos
            $intentosRealizados = IntentoAlumnoActividadPractica::where('id_alumno', $alumno->id)
                ->where('id_actividad_practica', $actividadPractica->id)
                ->count();

            if ($intentosRealizados >= $actividadPractica->intentos_permitidos) {
                return response()->json([
                    'message' => 'Has excedido el límite de intentos permitidos'
                ], 403);
            }

            // CREAR el IntentoAlumnoActividadPractica
            $intento = IntentoAlumnoActividadPractica::create([
                'id_alumno' => $alumno->id,
                'id_actividad_practica' => $actividadPractica->id,
                'fecha_inicio' => now(),
                'fecha_fin' => null,
                'puntaje_total' => 0,
                'completado' => false,
            ]);

            // CREAR ResultadoPreguntaActividadPractica para cada pregunta
            foreach ($actividadPractica->preguntas as $pregunta) {
                ResultadoPreguntaActividadPractica::create([
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
            $preguntas = $actividadPractica->preguntas->map(function ($pregunta) {
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
                'message' => 'Intento de práctica iniciado exitosamente',
                'intento_id' => $intento->id,
                'preguntas' => $preguntas
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear el intento de práctica',
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
            // VERIFICAR que el intento pertenece al usuario
            $intento = IntentoAlumnoActividadPractica::where('id', $intentoId)
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

            // VERIFICAR que la pregunta pertenece a esta actividad práctica
            $actividadPractica = ActividadPractica::with('preguntas')
                ->find($intento->id_actividad_practica);

            $preguntaEnActividad = $actividadPractica->preguntas
                ->where('id', $data['id_pregunta'])
                ->first();

            if (!$preguntaEnActividad) {
                return response()->json([
                    'message' => 'La pregunta no pertenece a esta actividad práctica'
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
            $resultado = ResultadoPreguntaActividadPractica::where('id_intento', $intento->id)
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
            // VERIFICAR que el intento pertenece al usuario
            $intento = IntentoAlumnoActividadPractica::where('id', $intentoId)
                ->where('id_alumno', $usuario->id)
                ->with(['resultados', 'actividadPractica'])
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
            $umbralAprobacion = $intento->actividadPractica->umbral_aprobacion;
            $aprobado = $puntajeTotal >= $umbralAprobacion;

            // PREPARAR respuesta con resultados detallados
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
                'message' => 'Intento de práctica finalizado exitosamente',
                'intento' => [
                    'id' => $intento->id,
                    'fecha_inicio' => $intento->fecha_inicio,
                    'fecha_fin' => $intento->fecha_fin,
                    'completado' => $intento->completado,
                    'puntaje_total' => round($puntajeTotal, 2),
                ],
                'actividad_practica' => [
                    'id' => $intento->actividadPractica->id,
                    'nombre' => $intento->actividadPractica->nombre,
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
                'message' => 'Error al finalizar el intento de práctica',
                'error' => $e->getMessage()
            ], 500);
        }
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


    public function misIntentos(Request $request)
    {
        $usuario = $request->user();
        $intentos = IntentoAlumnoActividadPractica::with(['actividadPractica'])
            ->where('id_alumno', $usuario->id)
            ->orderBy('created_at', 'desc') // Opcional: ordenar por más recientes
            ->get();

        if ($intentos->isEmpty()) {
            return response()->json(['message' => 'No tienes intentos de práctica registrados'], 404);
        }

        return response()->json(['intentos' => $intentos], 200);
    }
}
