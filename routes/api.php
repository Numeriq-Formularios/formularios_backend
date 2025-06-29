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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/singup/usuario/alumno', [AlumnoController::class, 'register']);



//Grupo de rutas autenticadas con Sanctum
Route::middleware('auth:sanctum')->group(function () {

Route::post('/singup/usuario/docente', [DocenteController::class, 'register']);

//Rutas del usuario que es Alumno
Route::get('/usuarios/alumnos', [AlumnoController::class, 'index']); //Mostrar varios usuarios en concreto 
Route::get('/usuario/alumno/{id}', [AlumnoController::class, 'show']); //Mostar un alumno en concreto
Route::post('/usuario/alumno/{id}', [AlumnoController::class, 'update']); //Actualizar un registro, utilizamos post porque en postman no permite subir imagenes
Route::delete('/usuario/alumno/{id}', [AlumnoController::class, 'destroy']); //Eliminado logico en el id del usuario
//Route::post('/usuario/alumno/curso/{id}', [AlumnoController::class, 'incribirCurso']);
//Route::get('/usuario/alumno/{id}/curso', [AlumnoController::class, 'misCursos']); 

//Rutas del usuario que es Docente
Route::get('/usuarios/docentes/', [DocenteController::class, 'index']); 
Route::get('/usuario/docente/{id}', [DocenteController::class, 'show']); 
Route::post('/usuario/docente/{id}', [DocenteController::class, 'update']); //Actualizar un registro, utilizamos post porque en postman no permite subir imagenes
Route::delete('/usuario/docente/{id}', [DocenteController::class, 'destroy']);

//Aqui van las rutas que solo pueden acceder los usuarios autenticados
Route::post('/logout',[AuthController::class, 'logout']);

// RUTAS PARA ACTIVIDAD PRACTICA
Route::get('/actividades/practicas', [ActividadPracticaController::class, 'index']);//Si funciona
Route::get('/actividad/practica/{id}', [ActividadPracticaController::class, 'show']);//Si funciona
Route::post('/actividad/practica', [ActividadPracticaController::class, 'store']);//No funciona porque se necesita que en tabla de cursos y docentes existan campos llenos con id's correspondientes
Route::post('/actividad/practica/{id}', [ActividadPracticaController::class, 'update']);//Si funciona
Route::delete('/actividad/practica/{id}', [ActividadPracticaController::class, 'destroy']);//Si funciona

// RUTAS PARA PREGUNTA ACTIVIDAD PRACTICA
Route::get('/preguntas/actividad-practica', [PreguntaActividadPracticaController::class, 'index']);//Si funciona
Route::get('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'show']);//Si funciona
Route::post('/pregunta/actividad-practica', [PreguntaActividadPracticaController::class, 'store']);// No funciona porque se necesita que en tabla de activcidad_practica y preguntas existan campos llenos con id´s correspondientes
Route::post('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'update']);//Si funciona
Route::delete('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'destroy']);//Si funciona

// RUTAS PARA INTENTO PRACTICA
Route::get('/intentos/practica', [IntentoPracticaController::class, 'index']);// si funciona
Route::get('/intento/practica/{id}', [IntentoPracticaController::class, 'show']);// Si funciona
Route::post('/intento/practica', [IntentoPracticaController::class, 'store']);// No funciona porque se necesita que en sus tablas con FK (alumnos y actividad_practica) existan campos llenos con id´s correspondientes
Route::post('/intento/practica/{id}', [IntentoPracticaController::class, 'update']);// Si funciona
Route::delete('/intento/practica/{id}', [IntentoPracticaController::class, 'destroy']);// Si funciona

// RUTAS PARA INTENTO EXAMEN
Route::get('/intentos/examen', [IntentoExamenController::class, 'index']);// Si funciona
Route::get('/intento/examen/{id}', [IntentoExamenController::class, 'show']);// Si funciona
Route::post('/intento/examen', [IntentoExamenController::class, 'store']);// No funciona porque se necesita que en sus tablas con FK (alumnos y actividad_examen) existan campos llenos con id´s correspondientes
Route::post('/intento/examen/{id}', [IntentoExamenController::class, 'update']);// Si funciona
Route::delete('/intento/examen/{id}', [IntentoExamenController::class, 'destroy']);// Si funciona

// RUTAS PARA RESULTADO PRACTICA
Route::get('/resultados/practica', [ResultadoPracticaController::class, 'index']);// Si funciona
Route::get('/resultado/practica/{id}', [ResultadoPracticaController::class, 'show']);// Si funciona
Route::post('/resultado/practica', [ResultadoPracticaController::class, 'store']);// No funciona porque se necesita que en sus tablas con FK (intento_alumno_actividad_practica, preguntas, opcion respuesta) existan campos llenos con id´s correspondientes
Route::post('/resultado/practica/{id}', [ResultadoPracticaController::class, 'update']);// Si funciona
Route::delete('/resultado/practica/{id}', [ResultadoPracticaController::class, 'destroy']);// Si funciona

// RUTAS PARA RESULTADO EXAMEN
Route::get('/resultados/examen', [ResultadoExamenController::class, 'index']);// Si funciona
Route::get('/resultado/examen/{id}', [ResultadoExamenController::class, 'show']);// Si funciona
Route::post('/resultado/examen', [ResultadoExamenController::class, 'store']);// No funciona porque se necesita que en sus tablas con FK (intento_alumno_actividad_practica, preguntas, opcion respuesta) existan campos llenos con id´s correspondientes
Route::post('/resultado/examen/{id}', [ResultadoExamenController::class, 'update']);// Si funciona
Route::delete('/resultado/examen/{id}', [ResultadoExamenController::class, 'destroy']);// Si funciona

});



