<?php

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

});



