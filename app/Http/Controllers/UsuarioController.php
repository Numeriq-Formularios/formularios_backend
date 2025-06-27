<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Alumno;
use App\Models\Docente;
use GuzzleHttp\Psr7\Message;

class UsuarioController extends Controller
{
    //En este controlador se autentifica, y se cierra la sesion de los usuarios.

    //login y logout no estan implementados en este controlador, ya que se usan los de sanctum, yo quiero usar los mios 

    public function registerAlumno(Request $request)
    {
        //Recopilo los del formulario de registro  
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:usuarios',
            'clave' => 'required|string|min:8',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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
        $alumno->escolaridad = 'Primaria'; // Valor por defecto, se puede cambiar según la lógica de tu aplicación
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



    public function registerDocente(Request $request)
    {
        //Recopilo los del formulario de registro  
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:usuarios',
            'clave' => 'required|string|min:8',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'titulo_profesional'=> 'required|string|max:255',
            'linkedin'=>'required|string|max:255',
            'es_superusuario'=>'nullable|in:true,false,1,0,"1","0"',

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
    $esSuper = filter_var($data['es_superusuario'] ?? false, FILTER_VALIDATE_BOOLEAN);

        $docente = new Docente();
        $docente->id = $usuario->id;
        $docente->titulo_profesional = $data['titulo_profesional']; 
        $docente->linkedin = $data['linkedin'];
        $docente->es_superusuario= $esSuper ? 1 : 0;

        $docente->save();
    


        //Se genera el token de acceso para el usuario recién registrado
        $token = $usuario->createToken('auth_token')->plainTextToken;

        // Retornar una respuesta adecuada
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'usuario' => $usuario,
            'docente' =>$docente,
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

        //Si ese usuario es alumno o si es docente. Mostrarle sus datos 

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
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
        ]);


        //Busco el usuario
        $usuario = Usuario::find($id);

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

        $usuario->save();


        return response()->json([
            "message" => "Usuario actualizado correctamente",
            "usuario" => $usuario,
        ]);
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


//Significa que no se recibo imagen por lo que le asignamos una imagen por default para el usuario

        //Necesito que esta imagen la pueda ver nada mas agarrando el campo de 
        //foto_perfil osea que este dentro de la carpeta public
