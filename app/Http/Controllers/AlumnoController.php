<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //Objeto Request para manejar las peticiones HTTP
use App\Models\Alumno; //Modelo de Alumno
use App\Models\Usuario; //Modelo de Usuario
use App\Models\CursoAlumno;
use App\Models\Curso; //Modelo de Curso
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;  // Para manejar las respuestas JSON
use function Laravel\Prompts\error;

class AlumnoController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

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
        // Si el estado no se proporciona, se establece como true por defecto
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

        $alumno = new Alumno();
        $alumno->id = $usuario->id;
        $alumno->escolaridad = $data["escolaridad"]; // Valor por defecto, se puede cambiar según la lógica de tu aplicación
        $alumno->estado = true; // Por defecto, el alumno está activo
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


    //Funcion que retorna todos los usuarios que son alumnos
    public function index()
    {
        $this->authorize('viewAny', Alumno::class);
        

        $usuarios = Usuario::where('estado', true)
            ->whereHas('alumno', function ($query) {
                $query->where('estado', true); // Solo alumnos activos
            })
            ->with('alumno') // Incluir datos del alumno
            ->get();

        if ($usuarios->isempty()) {
            return response()->json([
                'message' => 'No hay usuarios activos',
            ], 404);
        }

        return response()->json([
            'usuarios' => $usuarios
        ], 200);
    }

    //Funcion que retorna un usuario por ID
    public function show($id)
    {

        $this->authorize('view', Alumno::class);
        // Buscar usuario por ID que esté activo y sea alumno
        $usuario = Usuario::where('id', $id)
            ->where('estado', true)
            ->whereHas('alumno', function ($query) {
                $query->where('estado', true); // Solo alumnos activos
            })
            ->with('alumno') // Incluir datos del alumno
            ->first();

        if (!$usuario) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }
    


        return response()->json([
            'usuario' => $usuario
        ], 200);
    }




    public function update(Request $request, $id)
    {
        $this->authorize('update', Alumno::class);

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
            ->whereHas('alumno', function ($query) {
                $query->where('estado', true); // Solo alumnos activos
            })
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

        if (isset($data['escolaridad'])) {
            // Actualizar la escolaridad del alumno
            $usuario->alumno->escolaridad = $data['escolaridad'];
            $usuario->alumno->save();
        }

        $usuario->save();


        return response()->json([
            "message" => "Usuario actualizado correctamente",
            "usuario" => $usuario,
        ]);
    }


    public function destroy($id)
    {

        $this->authorize('delete', Alumno::class);
        // Buscar usuario por ID que esté activo y sea alumno


        // Buscar usuario por ID que esté activo y sea alumno
        $usuario = Usuario::where('id', $id)
            ->where('estado', true)
            ->whereHas('alumno', function ($query) {
                $query->where('estado', true); // Solo alumnos activos
            })
            ->with('alumno') // Incluir datos del alumno
            ->first();

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado o ya esta eliminado'], 404);
        }

        // Eliminar lógicamente al usuario
        $usuario->estado = false;
        $usuario->save();
        // Eliminar lógicamente al alumno asociado
        $usuario->alumno->estado = false;
        $usuario->alumno->save();

        return response()->json([
            'message' => 'Usuario eliminado correctamente',
            'usuario' => $usuario,
        ], 200);
    }


    public function meUser(Request $request)
    {
        $this->authorize('meUser', Alumno::class);

        $usuario = $request->user(); // Obtener el usuario autenticado


        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        // Buscar usuario por ID que esté activo y sea alumno
        $usuario = Usuario::where('id', $usuario->id)
            ->where('estado', true)
            ->whereHas('alumno', function ($query) {
                $query->where('estado', true); // Solo alumnos activos
            })
            ->with('alumno') // Incluir datos del alumno
            ->first();



        return response()->json([
            'message' => 'Usuario autenticado correctamente',
            'usuario' => $usuario
        ], 200);
    }





    public function updateMe(Request $request)
    {

        $this->authorize('updateMe', Alumno::class);

        //Me traigo el usuario autenticado
        $usuario = $request->user();

        //Primero recibo los datos  
        $data = $request->validate([
            'nombre' => 'nullable|string|max:255',
            'correo' => 'nullable|string|email|max:255|unique:usuarios,correo,' . $usuario->id,
            'clave' => 'nullable|string|min:8',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'escolaridad' => 'nullable|string|max:255',
        ]);



        // Buscar usuario por ID que esté activo y sea alumno
        $usuario = Usuario::where('id', $usuario->id)
            ->where('estado', true)
            ->whereHas('alumno', function ($query) {
                $query->where('estado', true); // Solo alumnos activos
            })
            ->with('alumno') // Incluir datos del alumno
            ->first();



        if (!$usuario) {
            return response()->json([
                "message" => "El usuario no encontrado, o es inactivo",
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

        if (isset($data['escolaridad'])) {
            // Actualizar la escolaridad del alumno
            $usuario->alumno->escolaridad = $data['escolaridad'];
            $usuario->alumno->save();
        }

        $usuario->save();


        return response()->json([
            "message" => "Usuario actualizado correctamente",
            "usuario" => $usuario,
        ]);
    }



    public function destroyMe(Request $request)
    {
        //Me traigo el usuario autenticado
        $usuario = $request->user();

        $this->authorize('destroyMe', Alumno::class);


        // Buscar usuarioAlumno por ID que esté activo y sea alumno
        $usuarioAlumno = Usuario::where('id', $usuario->id)
            ->where('estado', true)
            ->whereHas('alumno', function ($query) {
                $query->where('estado', true); // Solo alumnos activos
            })
            ->with('alumno') // Incluir datos del alumno
            ->first();

        if (!$usuarioAlumno) {
            return response()->json(['message' => 'Usuario no encontrado o ya esta eliminado'], 404);
        }

        // Eliminar lógicamente al usuario
        $usuario->estado = false;
        $usuario->save();
        // Eliminar lógicamente al alumno asociado
        $usuario->alumno->estado = false;
        $usuario->alumno->save();

        return response()->json([
            'message' => 'Usuario eliminado correctamente',
            'usuario' => $usuario,
        ], 200);
    }



    //Solo se puede inscribir a un curso el propio alumno
    public function incribirCurso(Request $request, $id)
    {
        $this->authorize('incribirCurso', Alumno::class);

        //Me traigo el usuario autenticado
        $usuario = $request->user();

        if (!$usuario || !$usuario->alumno) {
            return response()->json([
                'message' => 'Usuario no autenticado o no es un alumno activo',
            ], 401);
        }

        //Obtener el id del usuario autenticado que es alumno
        $idUsuarioAlumno = $usuario->alumno->id; // Asumiendo que el

        //Verificar si el usuario autenticado es un alumno y esta activo
        $alumno = Alumno::where('id', $idUsuarioAlumno)->where('estado', true)->first();

        if (!$alumno) {
            return response()->json([
                'message' => 'Usuario no es un alumno activo',
            ], 403);
        }

        //Busco el curso por id al que se inscribira el alumno
        $curso = Curso::where('id', $id)->where('estado', true)->first();

        if (!$curso) {
            return response()->json([
                'message' => 'Curso no encontrado o no disponible',
            ], 404);
        }

        //Verificar si ya esta inscrito en el curso 
        $inscrito = CursoAlumno::where('id_alumno', $idUsuarioAlumno) // Usar el id del alumno
            ->where('id_curso', $id)
            ->where('estado', true) // Solo considerar inscripciones activas
            ->first();

        if ($inscrito) {
            return response()->json([
                'message' => 'Ya estás inscrito en este curso',
            ], 400);
        }


        //Aqui creo mi objeto CursoAlumno
        $cursoAlumno = new CursoAlumno();
        $cursoAlumno->id_alumno = $idUsuarioAlumno; // Asignar el id del usuario autenticado
        $cursoAlumno->id_curso = $id; // Asignar el id del curso al que se inscribe
        $cursoAlumno->estado = true; //
        $cursoAlumno->calificacion = null;
        $cursoAlumno->fecha_inscripcion = now()->format("Y-m-d"); // Fecha de inscripción actual
        $cursoAlumno->save();

        return response()->json([
            'message' => 'Inscripción exitosa al curso',
            'curso_alumno' => $cursoAlumno,
            'alumno' => $alumno,
        ]);
    }


    //Esta funcion solo esta disponible para los alumnos
    public function misCursos()
    {
        $this->authorize('misCursos', Alumno::class);

        //Me traigo el usuario autenticado
        $usuario = request()->user();

        $idUsuarioAlumno = $usuario->alumno->id; // Asumiendo que el usuario tiene un alumno asociado

        if (!$usuario || !$usuario->alumno) {
            return response()->json([
                'message' => 'Usuario no autenticado o no es alumno',
            ], 401);
        }

        //Obtener el id del usuario auten

        //Buscar los cursos usando el NOMBRE DE LA RELACIÓN (no de la tabla)
        $cursos = Curso::whereHas('alumnos', function ($query) use ($idUsuarioAlumno) {
            $query->where('cursos_alumnos.id_alumno', $idUsuarioAlumno)
                ->where('cursos_alumnos.estado', true); // Solo inscripciones activas
        })
            ->where('estado', true)->get();

        return response()->json([
            'cursos' => $cursos,
        ], 200);
    }
}
