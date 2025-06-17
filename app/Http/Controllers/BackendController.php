<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendController extends Controller
{
    //Vamos a crear un metodo

    public function get(){
        return response()->json([
            'succes' => true,
            'message' => 'Hola', 
        ]);
    } 
}
