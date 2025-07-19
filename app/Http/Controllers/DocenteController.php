<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente; // Assuming you have a Docente model
use App\Models\Usuario; // Assuming you have a Usuario model
use App\Models\Especializacion;

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
        $usuario->estado = true; // Por defecto, el usuario está activo
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
            'titulo_profesional' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
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

        if (isset($data['titulo_profesional'])) {
            // Actualizar el titulo profesional del docente
            $usuario->docente->titulo_profesional = $data['titulo_profesional'];
        }

        if (isset($data['linkedin'])) {
            // Actualizar el linkedin del docente
            $usuario->docente->linkedin = $data['linkedin'];
        }

        if (isset($data['es_superusuario'])) {
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

        //Eliminar el docente asociado
        $usuario->docente->estado = false; // Cambiar el estado del docente a inactivo
        $usuario->docente->save();

        return response()->json([
            'message' => 'Usuario eliminado correctamente',
            'usuario' => $usuario,
        ], 200);
    }


    public function meUser(Request $request)
    {

        $usuario = $request->user(); // Obtener el usuario autenticado


        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        //Aqui busco el usuairo y su alumno asociado
        $usuario = Usuario::where('id', $usuario->id)
            ->where('estado', true) // Asegurarse de que el usuario esté activo
            ->has('docente') // Asegurarse de que el usuario tenga un docente asociado
            ->with('docente') // Incluir los datos del docente
            ->first();


        return response()->json([
            'usuario' => $usuario
        ], 200);
    }




    public function updateMe(Request $request)
    {


        $usuario = $request->user(); // Obtener el usuario autenticado


        //Recibo los datos
        $data = $request->validate([
            'nombre' => 'nullable|string|max:255',
            'correo' => 'nullable|string|email|max:255|unique:usuarios,correo,',
            'clave' => 'nullable|string|min:8',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'titulo_profesional' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'es_superusuario' => 'nullable|in:true,false,1,0,"1","0"',
        ]);

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

        if (isset($data['titulo_profesional'])) {
            // Actualizar el titulo profesional del docente
            $usuario->docente->titulo_profesional = $data['titulo_profesional'];
        }

        if (isset($data['linkedin'])) {
            // Actualizar el linkedin del docente
            $usuario->docente->linkedin = $data['linkedin'];
        }

        if (isset($data['es_superusuario'])) {
            // Actualizar si es superusuario
            $usuario->docente->es_superusuario = filter_var($data['es_superusuario'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        $usuario->save();


        return response()->json([
            "message" => "Usuario actualizado correctamente",
            "usuario" => $usuario,
        ]);
    }

    //Listar las especializaciones que tiene un docente
    public function Especialidades(Request $request)
    {

        $usuario = $request->user();

        if (!$usuario || !$usuario->docente) {
            return response()->json([
                'message' => 'Usuario no autenticado o no es un docente activo',
            ], 401);
        }

        $docente = Docente::where('id', $usuario->docente->id)
            ->where('estado', true)
            ->with('especializaciones')
            ->first();

        if (!$docente) {
            return response()->json([
                'message' => 'Usuario no es un docente activo',
            ], 403);
        }

        //Busco las especilizaciones del docente
        if ($docente->especializaciones->isEmpty()) {
            return response()->json([
                'message' => 'El docente no tiene especializaciones asignadas',
            ], 404);
        }

        return response()->json([
            'especializaciones' => $docente->especializaciones,
        ], 200);
    }


    public function PonerEspecialidad(Request $request, $id)
    {
        $usuario = $request->user();

        if (!$usuario || !$usuario->docente) {
            return response()->json([
                'message' => 'Usuario no autenticado o no es un docente activo',
            ], 401);
        }

        //Obtener el id del usuario autenticado que es alumno
        $idUsuarioDocente = $usuario->docente->id;


        //Verifica si el usuario autenticado es docente y esta activo
        $docente = Docente::where('id', $idUsuarioDocente)->where('estado', true)->first();


        if (!$docente) {
            return response()->json([
                'message' => 'Usuario no es un docente activo',
            ], 403);
        }

        //Busco la especialidad por id que se le haya pasado
        $especilizacion = Especializacion::where('id', $id)->first();


        if (!$especilizacion) {
            return response()->json([
                'message' => 'Especializacion no encontrada o no disponible',
            ], 404);
        }

        //Verificar si el usuario ya tiene esta especilizacion
        $tieneEspecilizacion = $docente->especializaciones()->where('id_especializacion', $id)->exists();


        if ($tieneEspecilizacion) {
            return response()->json([
                'message' => 'El docente ya tiene esta especialización',
            ], 400);
        }

        //Se agrega la especializacion al docente
        $docente->especializaciones()->attach($id);

        return response()->json([
            'message' => 'Especialización asignada correctamente al docente',
            'especializacion' => $especilizacion
        ], 200);
    }


    public function EliminarEspecialidad(Request $request, $id)
    {
        $usuario = $request->user();

        if (!$usuario || !$usuario->docente) {
            return response()->json([
                'message' => 'Usuario no autenticado o no es un docente activo',
            ], 401);
        }

        $docente = Docente::where('id', $usuario->docente->id)
            ->where('estado', true)
            ->first();

        if (!$docente) {
            return response()->json([
                'message' => 'Usuario no es un docente activo',
            ], 403);
        }

        // Verificar si el docente tiene esta especialización
        $especilizacion = $docente->especializaciones()->where('id_especializacion', $id)->first();

        if (!$especilizacion) {
            return response()->json([
                'message' => 'El docente no tiene esta especialización',
            ], 404);
        }

        // Eliminar la especialización usando detach
        $docente->especializaciones()->detach($id);

        return response()->json([
            'message' => 'Especialización eliminada correctamente',
            'especilizacion_eliminada' => $especilizacion,
        ], 200);
    }

    public function destroyMe(Request $request)
    {
        //Me traigo el usuario autenticado
        $usuario = $request->user();

        // Buscar usuarioDocente por ID que esté activo y sea docente
        $usuarioDocente = Usuario::where('id', $usuario->id)
            ->where('estado', true)
            ->whereHas('docente', function ($query) {
                $query->where('estado', true); // Solo docentes activos
            })
            ->with('docente') // Incluir datos del docente
            ->first();

        if (!$usuarioDocente) {
            return response()->json([
                'message' => 'Usuario no encontrado o ya está eliminado'
            ], 404);
        }

        // Eliminar lógicamente al usuario
        $usuario->estado = false;
        $usuario->save();

        // Eliminar lógicamente al docente asociado
        $usuario->docente->estado = false;
        $usuario->docente->save();

        return response()->json([
            'message' => 'Usuario eliminado correctamente',
            'usuario' => $usuario,
        ], 200);
    }
}
