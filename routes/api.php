<?php

use App\Http\Controllers\AlumnoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;




Route::post('/login', [AuthController::class, 'login']);
Route::post('/singup/usuario/alumno', [UsuarioController::class, 'registerAlumno']);



//Grupo de rutas autenticadas con Sanctum
Route::middleware('auth:sanctum')->group(function () {

//Esta accion la hace un SuperUsuario
Route::post('/singup/usuario/docente', [UsuarioController::class, 'registerDocente']);

//Aqui van las rutas que solo pueden acceder los usuarios autenticados
Route::post('/logout',[AuthController::class, 'logout']);





Route::get('/usuarios', [UsuarioController::class, 'showAll']); //Mostrar varios usuarios en concreto 
Route::get('/usuario/{id}', [UsuarioController::class, 'show']); //Mostrar un usuario en concreto
Route::post('/usuario/{id}', [UsuarioController::class, 'update']); //Actualizar un registro, utilizamos post porque en postman no permite subir imagenes
Route::delete('/usuario/{id}', [UsuarioController::class, 'destroy']); //Eliminado logico 


Route::get('/usuarios/alumnos/',[AlumnoController::class, 'showAll']); //Mostrar todos los usuarios que son alumnos
//Mostarr el usuario que este enlazado a un alumno

//Objetivo crear el controlador de alumno




});



