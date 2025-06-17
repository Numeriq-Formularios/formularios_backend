<?php

/*Para hacer rutas necesito la clase Route, esta clase es creada por laravel*/
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BackendController;


/*Una ruta es la direccion en la cual el cliente tiene que apuntar para obetner un recurso en el servidor*/

Route::get("/test", function(){
    return "El backend funciona correctamente ";
});

/*El controlador es el que organiza la logica de la aplicacion 

Es el quue gestiona lo que se hace con una solicitud, si esta es valida 
si es necesario ir a la base de datos y buscamos que informacion.
y con ello con la respuesta 
le entregamos unos datos
  
*/

/*Ruta enlazada al controlador BackendController*/
Route::get("/data",[BackendController:: class, "get"]);