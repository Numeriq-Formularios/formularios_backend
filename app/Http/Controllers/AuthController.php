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
    public function login (Request $request ){

        //Validar que los campos correo y clave esten presentes
        //Si no estan presentes, se retorna un error en el cual se indica que son requeridos
        $data = $request->validate([
            'correo' => 'required|string|email|max:255',
            'clave' => 'required|string|min:8|max:255',
        ]);

        //Se busca el usario por correo y  verificando que el estado sea activo == 1
        $usuario = Usuario::where('correo', $data['correo'])->where('estado', true)->first();

        if(!$usuario || !Hash::check($data['clave'], $usuario->clave)) {
            return response()->json(['message' => 'Correo o clave incorrectos'], 401);
        }

        //Si el usuario existe y la clave es correcta, se genera el token de acceso
        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario autenticado correctamente',
            'usuario' => $usuario,
            'token' => $token,
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