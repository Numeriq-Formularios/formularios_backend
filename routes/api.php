<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/singup', [UsuarioController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
//Aqui van las rutas que solo pueden acceder los usuarios autenticados

Route::post('/logout',[AuthController::class, 'logout']);

Route::get('/usuarios', [UsuarioController::class, 'showAll']);
Route::get('/usuario/{id}', [UsuarioController::class, 'show']);
//Route::PUT('/usuario/{id}', [UsuarioController::class, 'update']);
Route::delete('/usuario/{id}', [UsuarioController::class, 'destroy']);


});



