<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Alumno;

class UsuarioController extends Controller
{
    //En este controlador se autentifica, y se cierra la sesion de los usuarios.

    //login y logout no estan implementados en este controlador, ya que se usan los de sanctum, yo quiero usar los mios 

    public function register(Request $request)
    {


        //Recopilo los del formulario de registro  
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:usuarios',
            'clave' => 'required|string|min:8',
            'foto_perfil' => 'required|string|max:255',
        ]);

        if(isset($data['nombre']) && isset($data['correo']) && isset($data['clave']) && isset($data['foto_perfil'])) {
            // Si todos los campos requeridos están presentes, continuar con el registro
        } else {
            return response()->json(['message' => 'Todos los campos son obligatorios'], 400);
        }


        

        //Se crea una instancia del modelo Usuario
        $usuario = new Usuario();
        $usuario->nombre = $data['nombre'];
        $usuario->correo = $data['correo'];
        $usuario->clave = bcrypt($data['clave']); // Encriptar la contraseña
        $usuario->foto_perfil = $data['foto_perfil'] ?? null; // Si no se proporciona una foto, se establece como null
        $usuario->estado = true;
        $usuario->save();

        //Aqui es importante manejar la logica si el usuario es alumno o es docente.
        //En este caso, vamos a suponer que el usuario es un alumno por defecto.

        $alumno = new Alumno();
        $alumno->id = $usuario->id;
        $alumno->escolaridad = 'Primaria'; // Valor por defecto, se puede cambiar según la lógica de tu aplicación
        $alumno->save();


        //Se genera el token de acceso para el usuario recién registrado
        $token = $usuario->createToken('auth_token')->plainTextToken;

        // Retornar una respuesta adecuada
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'usuario' => $usuario,
            'alumno' => $alumno,
            'token' => $token
        ], 201);
    }


    public function showAll()
    {

        $Usuarios = Usuario::all()->Where('estado', true);

        return response()->json([
            'usuarios' => $Usuarios
        ], 200);
    }


    public function show($id)
    {

        $usuario = Usuario::find($id)->Where('estado', true)->first();

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json([
            'usuario' => $usuario
        ], 200);
    }


    public function update() {

    }


    public function destroy($id)
    {

        $usuario = Usuario::find($id);

        //Verificar que se haga a la url

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->estado = false;
        $usuario->save();

        return response()->json([
            'message' => 'Usuario eliminado correctamente',
            'usuario' => $usuario
        ], 200);
    }
}
