<?php

use App\Http\Controllers\Actividad\ActividadPracticaController;
use App\Http\Controllers\Actividad\PreguntaActividadPracticaController;
use App\Http\Controllers\Intento\IntentoExamenController;
use App\Http\Controllers\Intento\IntentoPracticaController;
use App\Http\Controllers\Intento\ResultadoExamenController;
use App\Http\Controllers\Intento\ResultadoPracticaController;       

use App\Http\Controllers\AlumnoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Controllers\ActividadExamenController;
use App\Http\Controllers\NivelBloomController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\DificultadController;
use App\Http\Controllers\TipoPreguntaController;
use App\Http\Controllers\PreguntaActividadExamenController;
use App\Http\Controllers\OpcionRespuestaController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/singup/usuario/alumno', [AlumnoController::class, 'register']);



//Grupo de rutas autenticadas con Sanctum, solo usuarios autenticados pueden acceder
// Esto es para que no se pueda acceder a las rutas de usuario sin estar autenticado
Route::middleware('auth:sanctum')->group(function () {

Route::post('/singup/usuario/docente', [DocenteController::class, 'register']);

//Rutas del usuario que es Alumno
//Tienen el middleware para  restringir el acceso a quien no tenga el permiso para acceder a el recurso
Route::get('/usuarios/alumnos', [AlumnoController::class, 'index']); //Mostrar varios usuarios en concreto 
Route::get('/usuario/alumno/{id}', [AlumnoController::class, 'show']); //Mostar un alumno en concreto
Route::post('/usuario/alumno/{id}', [AlumnoController::class, 'update']); //Actualizar un registro, utilizamos post porque en postman no permite subir imagenes
Route::delete('/usuario/alumno/{id}', [AlumnoController::class, 'destroy']); //Eliminado logico en el id del usuario
//Route::post('/usuario/alumno/curso/{id}', [AlumnoController::class, 'incribirCurso']);
//Route::get('/usuario/alumno/{id}/curso', [AlumnoController::class, 'misCursos']); 



//Rutas del usuario que es Docente
//Tienen el middleware para  restringir el acceso a quien no tenga el permiso para acceder a el recurso
Route::get('/usuarios/docentes/', [DocenteController::class, 'index']); 
Route::get('/usuario/docente/{id}', [DocenteController::class, 'show']); 
Route::post('/usuario/docente/{id}', [DocenteController::class, 'update']); //Actualizar un registro, utilizamos post porque en postman no permite subir imagenes
Route::delete('/usuario/docente/{id}', [DocenteController::class, 'destroy']);

//Rutas para cursos





//Ruta para hacver logout
Route::post('/logout',[AuthController::class, 'logout']);



// RUTAS PARA ACTIVIDAD PRACTICA
Route::get('/actividades/practicas', [ActividadPracticaController::class, 'index']);//Si funciona
Route::get('/actividad/practica/{id}', [ActividadPracticaController::class, 'show']);//Si funciona
Route::post('/actividad/practica', [ActividadPracticaController::class, 'store']);//Si funciona
Route::post('/actividad/practica/{id}', [ActividadPracticaController::class, 'update']);//Si funciona
Route::delete('/actividad/practica/{id}', [ActividadPracticaController::class, 'destroy']);//Si funciona

// RUTAS PARA PREGUNTA ACTIVIDAD PRACTICA
Route::get('/preguntas/actividad-practica', [PreguntaActividadPracticaController::class, 'index']);//Si funciona
Route::get('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'show']);//Si funciona
Route::post('/pregunta/actividad-practica', [PreguntaActividadPracticaController::class, 'store']);// Si funciona
Route::post('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'update']);//Si funciona
Route::delete('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'destroy']);//Si funciona

// RUTAS PARA INTENTO PRACTICA
Route::get('/intentos/practica', [IntentoPracticaController::class, 'index']);// si funciona
Route::get('/intento/practica/{id}', [IntentoPracticaController::class, 'show']);// Si funciona
Route::post('/intento/practica', [IntentoPracticaController::class, 'store']);// Si funciona
Route::post('/intento/practica/{id}', [IntentoPracticaController::class, 'update']);// Si funciona
Route::delete('/intento/practica/{id}', [IntentoPracticaController::class, 'destroy']);// Si funciona

// RUTAS PARA INTENTO EXAMEN
Route::get('/intentos/examen', [IntentoExamenController::class, 'index']);// Si funciona
Route::get('/intento/examen/{id}', [IntentoExamenController::class, 'show']);// Si funciona
Route::post('/intento/examen', [IntentoExamenController::class, 'store']);// Si funciona
Route::post('/intento/examen/{id}', [IntentoExamenController::class, 'update']);// Si funciona
Route::delete('/intento/examen/{id}', [IntentoExamenController::class, 'destroy']);// Si funciona

// RUTAS PARA RESULTADO PRACTICA
Route::get('/resultados/practica', [ResultadoPracticaController::class, 'index']);// Si funciona
Route::get('/resultado/practica/{id}', [ResultadoPracticaController::class, 'show']);// Si funciona
Route::post('/resultado/practica', [ResultadoPracticaController::class, 'store']);// Si funciona
Route::post('/resultado/practica/{id}', [ResultadoPracticaController::class, 'update']);// Si funciona
Route::delete('/resultado/practica/{id}', [ResultadoPracticaController::class, 'destroy']);// Si funciona

// RUTAS PARA RESULTADO EXAMEN
Route::get('/resultados/examen', [ResultadoExamenController::class, 'index']);// Si funciona
Route::get('/resultado/examen/{id}', [ResultadoExamenController::class, 'show']);// Si funciona
Route::post('/resultado/examen', [ResultadoExamenController::class, 'store']);// Si funciona
Route::post('/resultado/examen/{id}', [ResultadoExamenController::class, 'update']);// Si funciona
Route::delete('/resultado/examen/{id}', [ResultadoExamenController::class, 'destroy']);// Si funciona

// Rutas para Actividad Examen
Route::get('/actividad-examenes', [ActividadExamenController::class, 'index']);
Route::post('/actividad-examenes', [ActividadExamenController::class, 'store']);
Route::get('/actividad-examenes/{id}', [ActividadExamenController::class, 'show']);
Route::put('/actividad-examenes/{id}', [ActividadExamenController::class, 'update']);
Route::delete('/actividad-examenes/{id}', [ActividadExamenController::class, 'destroy']);

// Rutas para Nivel Bloom
Route::get('/nivel-blooms', [NivelBloomController::class, 'index']);
Route::post('/nivel-blooms', [NivelBloomController::class, 'store']);
Route::get('/nivel-blooms/{id}', [NivelBloomController::class, 'show']);
Route::put('/nivel-blooms/{id}', [NivelBloomController::class, 'update']);
Route::delete('/nivel-blooms/{id}', [NivelBloomController::class, 'destroy']);

// Rutas para Asignaturas
Route::get('/asignaturas', [AsignaturaController::class, 'index']);
Route::post('/asignaturas', [AsignaturaController::class, 'store']);
Route::get('/asignaturas/{id}', [AsignaturaController::class, 'show']);
Route::put('/asignaturas/{id}', [AsignaturaController::class, 'update']);
Route::delete('/asignaturas/{id}', [AsignaturaController::class, 'destroy']);

// Rutas para Temas
Route::get('/temas', [TemaController::class, 'index']);
Route::post('/temas', [TemaController::class, 'store']);
Route::get('/temas/{id}', [TemaController::class, 'show']);
Route::put('/temas/{id}', [TemaController::class, 'update']);
Route::delete('/temas/{id}', [TemaController::class, 'destroy']);

// Rutas para Preguntas
Route::get('/preguntas', [PreguntaController::class, 'index']);
Route::post('/preguntas', [PreguntaController::class, 'store']);
Route::get('/preguntas/{id}', [PreguntaController::class, 'show']);
Route::put('/preguntas/{id}', [PreguntaController::class, 'update']);
Route::delete('/preguntas/{id}', [PreguntaController::class, 'destroy']);

// Rutas para Dificultades
Route::get('/dificultades', [DificultadController::class, 'index']);
Route::post('/dificultades', [DificultadController::class, 'store']);
Route::get('/dificultades/{id}', [DificultadController::class, 'show']);
Route::put('/dificultades/{id}', [DificultadController::class, 'update']);
Route::delete('/dificultades/{id}', [DificultadController::class, 'destroy']);

// Rutas para Tipo de Pregunta
Route::get('/tipo-preguntas', [TipoPreguntaController::class, 'index']);
Route::post('/tipo-preguntas', [TipoPreguntaController::class, 'store']);
Route::get('/tipo-preguntas/{id}', [TipoPreguntaController::class, 'show']);
Route::put('/tipo-preguntas/{id}', [TipoPreguntaController::class, 'update']);
Route::delete('/tipo-preguntas/{id}', [TipoPreguntaController::class, 'destroy']);

// Rutas para Pregunta Actividad Examen
Route::get('/pregunta-actividad-examenes', [PreguntaActividadExamenController::class, 'index']);
Route::post('/pregunta-actividad-examenes', [PreguntaActividadExamenController::class, 'store']);
Route::get('/pregunta-actividad-examenes/{id}', [PreguntaActividadExamenController::class, 'show']);
Route::put('/pregunta-actividad-examenes/{id}', [PreguntaActividadExamenController::class, 'update']);
Route::delete('/pregunta-actividad-examenes/{id}', [PreguntaActividadExamenController::class, 'destroy']);

// Rutas para Opción Respuesta
Route::get('/opcion-respuestas', [OpcionRespuestaController::class, 'index']);
Route::post('/opcion-respuestas', [OpcionRespuestaController::class, 'store']);
Route::get('/opcion-respuestas/{id}', [OpcionRespuestaController::class, 'show']);
Route::put('/opcion-respuestas/{id}', [OpcionRespuestaController::class, 'update']);
Route::delete('/opcion-respuestas/{id}', [OpcionRespuestaController::class, 'destroy']);


});
