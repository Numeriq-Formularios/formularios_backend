<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno; // Assuming you have an Alumno model
use App\Models\Usuario; // Assuming you have a Usuario model

class AlumnoController extends Controller
{
    public function register(Request $request)
    {
        //Recopilo los del formulario de registro  
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:usuarios',
            'clave' => 'required|string|min:8',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'escolaridad' => 'required|string|max:255',
        ]);

        //Se crea una instancia del modelo Usuario
        $usuario = new Usuario();
        $usuario->nombre = $data['nombre'];
        $usuario->correo = $data['correo'];
        $usuario->clave = bcrypt($data['clave']); // Encriptar la contraseña
        $usuario->estado = true;
        $usuario->save();


        if ($request->hasfile('foto_perfil')) {

            $image = $data['foto_perfil'];

            //Extraer la extension de la imagen
            $extensionImage = $image->getClientOriginalExtension();


            //Nombre que tendra cada imagen
            $imagename = "UserImage_" . $usuario->id . "id" . "." . $extensionImage;

            //Se guarda la imagen con el id del usuario
            $path = $image->storeAs("images/", $imagename, 'public');

            //Se gurda la ruta en completa en la base de datos 
            $usuario->foto_perfil = asset("storage/images/{$imagename}");
        } else {
            //Se gurda la ruta en completa en la base de datos 
            $usuario->foto_perfil = asset("storage/images/user-default-Image.svg");
        }

        $usuario->save();

        //Aqui es importante manejar la logica si el usuario es alumno o es docente.
        //En este caso, vamos a suponer que el usuario es un alumno por defecto.

        $alumno = new Alumno();
        $alumno->id = $usuario->id;
        $alumno->escolaridad = $data["escolaridad"]; // Valor por defecto, se puede cambiar según la lógica de tu aplicación
        $alumno->save();


        //Se genera el token de acceso para el usuario recién registrado
        $token = $usuario->createToken('auth_token')->plainTextToken;

        // Retornar una respuesta adecuada
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'usuario' => $usuario,
            'token' => $token
        ], 201);
    }


    public function index()
    {
        // Usuarios que tienen relación con alumno y están activos
        $usuarios = Usuario::where('estado', true)
            ->has('alumno')  // Solo usuarios que tienen alumno
            ->with('alumno') // Incluir datos del alumno
            ->get();

        return response()->json([
            'usuarios' => $usuarios
        ], 200);
    }

    public function show($id)
    {
        // Buscar usuario por ID que esté activo y sea alumno
        $usuario = Usuario::where('id', $id)
            ->where('estado', true)
            ->has('alumno')
            ->with('alumno') // Incluir datos del alumno
            ->first();


        if (!$usuario) {
            return response()->json(['message' => 'Almuno no encontrado'], 404);
        }

        return response()->json([
            'usuario' => $usuario
        ], 200);
    }



    public function update(Request $request, $id)
    {

        //Primero recibo los datos  
        $data = $request->validate([
            'nombre' => 'nullable|string|max:255',
            'correo' => 'nullable|string|email|max:255|unique:usuarios,correo,' . $id,
            'clave' => 'nullable|string|min:8',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'escolaridad' => 'nullable|string|max:255',
        ]);

        // Buscar usuario por ID que esté activo y sea alumno
        $usuario = Usuario::where('id', $id)
            ->where('estado', true)
            ->has('alumno')
            ->with('alumno') // Incluir datos del alumno
            ->first();


        if (!$usuario) {
            return response()->json([
                "message" => "El usuario no existe",
            ], 404);
        }



        //El punto aqui es decir si recibes dato de un campo lo pones y guardas

        if (isset($data['nombre'])) {
            $usuario->nombre = $data['nombre'];
        }

        if (isset($data['correo'])) {
            $usuario->correo = $data['correo'];
        }

        if (isset($data['clave'])) {
            $usuario->clave = bcrypt($data['clave']);
        }

        if (isset($data['foto_perfil'])) {
            $image = $data['foto_perfil'];

            //Extraer la extension de la imagen
            $extensionImage = $image->getClientOriginalExtension();


            //Nombre que tendra cada imagen
            $imagename = "UserImage_" . $usuario->id . "id" . "." . $extensionImage;

            //Se guarda la imagen con el id del usuario
            $path = $image->storeAs("images/", $imagename, 'public');

            //Se gurda la ruta en completa en la base de datos 
            $usuario->foto_perfil = asset("storage/images/{$imagename}");
        }

        if(isset($data['escolaridad'])) {
            // Actualizar la escolaridad del alumno
            $usuario->alumno->escolaridad = $data['escolaridad'];
        }

        $usuario->save();


        return response()->json([
            "message" => "Usuario actualizado correctamente",
            "usuario" => $usuario,
        ]);
    }


    public function destroy($id)
    {
        // Buscar usuario por ID que esté activo y sea alumno
        $usuario = Usuario::where('id', $id)
            ->where('estado', true)
            ->has('alumno')
            ->first();

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Eliminar lógicamente al usuario
        $usuario->estado = false;
        $usuario->save();

        return response()->json([
            'message' => 'Usuario eliminado correctamente',
            'usuario' => $usuario
        ], 200);
    }


    public function incribirCurso(){

    }


    public function misCursos(){

    }

    public function intentoActividadExamen(){

    }

    public function intentoActividadPractica(){

    }



}
