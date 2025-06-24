<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Alumno;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    //En este controlador se autentifica, y se cierra la sesion de los usuarios.

    //login y logout no estan implementados en este controlador, ya que se usan los de sanctum, yo quiero usar los mios 


    public function login (Request $request ){

        $data = $request->validate([
            'correo' => 'required|string|email|max:255',
            'clave' => 'required|string|min:8|max:255',
        ]);
        //Validar que los campos correo y clave esten presentes
        //Si no estan presentes, se retorna un error 400 Bad Request

        if(!isset($data['correo']) || !isset($data['clave'])) {
            return response()->json(['message' => 'Correo y clave son requeridos'], 400);
        }

        $usuario = Usuario::where('correo', $data['correo'])->where('estado', true)->first();

        if(!$usuario || !Hash::check($data['clave'], $usuario->clave)) {
            return response()->json(['message' => 'Correo o clave incorrectos'], 401);
        }

        //Si el usuario existe y la clave es correcta, se genera el token de acceso
        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario autenticado correctamente',
            'usuario' => $usuario,
            'token' => $token
        ], 200);



    }


    public function logout(Request $request) {

        //Usuario actual que sera desconectado
        $usuario = $request->user();
         //Aqui seria invalidar el token de acceso del usuario que se esta desconectando
        $usuario->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesion cerrada correctamente',
        ], 200);


        

    }


}