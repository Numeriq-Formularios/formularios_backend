<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente; // Assuming you have a Docente model
use App\Models\Usuario; // Assuming you have a Usuario model

class DocenteController extends Controller
{
    public function register(Request $request)
    {
        //Recopilo los del formulario de registro  
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:usuarios',
            'clave' => 'required|string|min:8',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'titulo_profesional' => 'required|string|max:255',
            'linkedin' => 'required|string|max:255',
            'es_superusuario' => 'nullable|in:true,false,1,0,"1","0"',

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
        $docente->estado = true;
        $docente->es_superusuario = $esSuper ? 1 : 0;

        $docente->save();



        //Se genera el token de acceso para el usuario recién registrado
        $token = $usuario->createToken('auth_token')->plainTextToken;

        // Retornar una respuesta adecuada
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'usuario' => $usuario,
            'docente' => $docente,
            'token' => $token
        ], 201);
    }


    public function index()
    {
        // Usuario que tienen relación con usuario y están activos
        $docentes = Docente::with('usuario') // Incluir datos del usuario
            ->whereHas('usuario', function ($query) {
                $query->where('estado', true);
            })->get();

        return response()->json([
            'usuarios' => $docentes
        ], 200);
    }

    public function show($id)
    {
        // Buscar docente por ID con su usuario relacionado
        $docente = Docente::with('usuario')
            ->whereHas('usuario', function ($query) use ($id) {
                $query->where('id', $id)
                    ->where('estado', true);
            })
            ->first();

        if (!$docente) {
            return response()->json(['message' => 'Docente no encontrado'], 404);
        }

        return response()->json([
            'docente' => $docente
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
            'titulo_profesional' => 'required|string|max:255',
            'linkedin' => 'required|string|max:255',
            'es_superusuario' => 'nullable|in:true,false,1,0,"1","0"',
        ]);

        // Buscar usuario por ID que esté activo y sea DOCENTE
        $usuario = Usuario::where('id', $id)
            ->where('estado', true)
            ->has('docente')
            ->with('docente') // Incluir datos del alumno
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

        if(isset($data['titulo_profesional'])) {
            // Actualizar el titulo profesional del docente
            $usuario->docente->titulo_profesional = $data['titulo_profesional'];
        }

        if(isset($data['linkedin'])) {
            // Actualizar el linkedin del docente
            $usuario->docente->linkedin = $data['linkedin'];
        }

        if(isset($data['es_superusuario'])) {
            // Actualizar si es superusuario
            $usuario->docente->es_superusuario = filter_var($data['es_superusuario'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        $usuario->save();


        return response()->json([
            "message" => "Usuario actualizado correctamente",
            "usuario" => $usuario,
        ]);
    }


        public function destroy($id)
    {
        // Buscar usuario por ID que esté activo y sea docente
        $usuario = Usuario::where('id', $id)
            ->where('estado', true)
            ->has('docente')
            ->first();

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Eliminar lógicamente al usuario
        $usuario->estado = false;
        $usuario->save();

        return response()->json([
            'message' => 'Usuario eliminado correctamente',
            'usuario' => $usuario->docente,
        ], 200);
    }



}
