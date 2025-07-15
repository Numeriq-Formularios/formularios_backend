<?php

use App\Http\Controllers\Actividad\ActividadPracticaController;
use App\Http\Controllers\Actividad\PreguntaActividadPracticaController;
use App\Http\Controllers\Intento\IntentoExamenController;
use App\Http\Controllers\Intento\IntentoPracticaController;
use App\Http\Controllers\Intento\ResultadoExamenController;
use App\Http\Controllers\Intento\ResultadoPracticaController;

use App\Http\Controllers\AlumnoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\ActividadExamenController;
use App\Http\Controllers\NivelBloomController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\DificultadController;
use App\Http\Controllers\TipoPreguntaController;
use App\Http\Controllers\PreguntaActividadExamenController;
use App\Http\Controllers\OpcionRespuestaController;
use App\Http\Controllers\EspecializacionController;
use App\Models\Curso;

//Jerarquia de roles 

// rol.alumno es el rol de estudiante,
// rol.docente es el rol de profesor base, 
//y rol.superusuario es el administrador del sistema completo

Route::post('/login', [AuthController::class, 'login']);
Route::post('/singup/usuario/alumno', [AlumnoController::class, 'register']);


//Aqui van todas las funciones del usuario Alumno
Route::middleware(['auth:sanctum', 'rol.alumno'])->group(function () {

    //Rutas de perfil para el usuario alumno
    //Rutas solo accesibles para el usuario alumno, solo puede acceder el alumno validado por policies
    Route::get('/usuario/alumno', [AlumnoController::class, 'meUser']); //Mostrar el perfil del alumno
    Route::post('/usuario/alumno', [AlumnoController::class, 'updateMe']); //Actualizar el perfil del alumno
    Route::delete('/usuario/alumno', [AlumnoController::class, 'destroyMe']); //Eliminado logico del alumno

    //Rutas para los cursos del alumno
    Route::post('/usuario/alumno/curso/{id}', [AlumnoController::class, 'incribirCurso']); // Aqui esta la posibilidad en inscribir un alumno a un curso
    Route::get('/usuario/alumno/cursos', [AlumnoController::class, 'misCursos']); //Los cusos a los que esta inscrito el alumno 

    //Rutas para contestar una actividad examen
    //Rutas para contestar una actividad practica

    //Ver resultados de act examen por id.
    //Ver resultados de act practica por id


});


Route::middleware(['auth:sanctum'])->group(function () {
    //Ruta para hacer logout, esta disponible para todos los usuarios autenticados
    Route::post('/logout', [AuthController::class, 'logout']);
});




//Aqui van todas las funciones del usuario Docente
Route::middleware(['auth:sanctum', 'rol.docente'])->group(function () {
    Route::get('/usuario/docente', [DocenteController::class, 'meUser']);
    Route::post('/usuario/docente', [DocenteController::class, 'updateMe']);
    Route::delete('/usuario/docente', [DocenteController::class, 'destroyMe']);

    //Aqui van las funciones que son exclusivas del docente *****

    //Por ejemplo, listar los cursos que tiene asignado el docente
    //Listar los alumnos en un curso que esta asignado el docente
    //Crear una actividad examen
    //Crear una actividad practica
    //Crear pregunta
    //Crear las opciones de las preguntas
    //Crear cursos/ editar solo sus curso  (aqui aplicaremos policies)

    //Agregar una especialidad a  el docente
    Route::get('/especializaciones/docente', [DocenteController::class, 'Especialidades']); //Listar especializaciones de un docente
    Route::post('/especializacion/docente/{id}', [DocenteController::class, 'PonerEspecialidad']); //Poner una especialidad a un docente
    Route::delete('/especializacion/docente/{id}', [DocenteController::class, 'EliminarEspecialidad']); //Eliminar una especialidad a  el docente



    /*Recordemos que un superusuario es un docente, por lo tanto, las rutas que estan
    debajo de este middleware son exclusivas para el superusuario
    Estas rutas son las que se encargan de gestionar los usuarios, alumnos y docentes,
    ademas de las rutas que se encargan de gestionar los cursos, especializaciones,
    actividades, preguntas, intentos, etc.
    */
    Route::middleware('rol.superusuario')->group(function () {


        //Rutas solo accesibles para el superusuario CRUD de los alumnos
        Route::get('/usuarios/alumnos', [AlumnoController::class, 'index']); //Mostrar varios usuarios en concreto 
        Route::get('/usuario/alumno/{id}', [AlumnoController::class, 'show']); //Mostar un alumno en concreto
        Route::put('/usuario/alumno/{id}', [AlumnoController::class, 'update']); //Actualizar un usuario en concreto
        Route::delete('/usuario/alumno/{id}', [AlumnoController::class, 'destroy']); //Eliminado logico de un usaurio en concreto
        //Route::post('/usuario/alumno/curso/{id}', [AlumnoController::class, 'incribirCurso']); //Inscribir a un alumno en cincreto
        //Route::get('/usuario/alumno/{id}/cursos', [AlumnoController::class, 'misCursos']); //Los cursos a los que esta inscrito un alumno en concreto


        //Rutas solo accesibles para el superusuario CRUD de los docentes
        Route::post('/singup/usuario/docente', [DocenteController::class, 'register']);
        Route::get('/usuarios/docentes/', [DocenteController::class, 'index']);
        Route::get('/usuario/docente/{id}', [DocenteController::class, 'show']);
        Route::put('/usuario/docente/{id}', [DocenteController::class, 'update']);
        Route::delete('/usuario/docente/{id}', [DocenteController::class, 'destroy']);


        //Ruta para cursos
        Route::get('/cursos', [CursoController::class, 'index']); //Lista de cursos
        Route::post('/curso', [CursoController::class, 'store']); //Creacion de un curso
        Route::get('/curso/{id}', [CursoController::class, 'show']); //Muestra un curso en especifico
        Route::put('/curso/{id}', [CursoController::class, 'update']); //Actualiza un curso en especifico
        Route::delete('/curso/{id}', [CursoController::class, 'destroy']); //Elimina un curso en especifico

        //Rutas para agregar la especialidad
        Route::get('/especializaciones', [EspecializacionController::class, 'index']); //Listar especializaciones
        Route::post('/especializacion', [EspecializacionController::class, 'store']); //Crear una especializacion
        Route::get('/especializacion/{id}', [EspecializacionController::class, 'show']); //Mostrar una especializacion en concreto por id
        Route::put('/especializacion/{id}', [EspecializacionController::class, 'update']); //Actualizar una especializacion
        Route::delete('/especializacion/{id}', [EspecializacionController::class, 'destroy']); //Eliminar una especializacion

        // RUTAS PARA ACTIVIDAD PRACTICA
        Route::get('/actividades/practicas', [ActividadPracticaController::class, 'index']); //Si funciona
        Route::get('/actividad/practica/{id}', [ActividadPracticaController::class, 'show']); //Si funciona
        Route::post('/actividad/practica', [ActividadPracticaController::class, 'store']); //Si funciona
        Route::post('/actividad/practica/{id}', [ActividadPracticaController::class, 'update']); //Si funciona
        Route::delete('/actividad/practica/{id}', [ActividadPracticaController::class, 'destroy']); //Si funciona

        // RUTAS PARA PREGUNTA ACTIVIDAD PRACTICA
        Route::get('/preguntas/actividad-practica', [PreguntaActividadPracticaController::class, 'index']); //Si funciona
        Route::get('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'show']); //Si funciona
        Route::post('/pregunta/actividad-practica', [PreguntaActividadPracticaController::class, 'store']); // Si funciona
        Route::post('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'update']); //Si funciona
        Route::delete('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'destroy']); //Si funciona

        // RUTAS PARA INTENTO PRACTICA
        Route::get('/intentos/practica', [IntentoPracticaController::class, 'index']); // si funciona
        Route::get('/intento/practica/{id}', [IntentoPracticaController::class, 'show']); // Si funciona
        Route::post('/intento/practica', [IntentoPracticaController::class, 'store']); // Si funciona
        Route::post('/intento/practica/{id}', [IntentoPracticaController::class, 'update']); // Si funciona
        Route::delete('/intento/practica/{id}', [IntentoPracticaController::class, 'destroy']); // Si funciona

        // RUTAS PARA INTENTO EXAMEN
        Route::get('/intentos/examen', [IntentoExamenController::class, 'index']); // Si funciona
        Route::get('/intento/examen/{id}', [IntentoExamenController::class, 'show']); // Si funciona
        Route::post('/intento/examen', [IntentoExamenController::class, 'store']); // Si funciona
        Route::post('/intento/examen/{id}', [IntentoExamenController::class, 'update']); // Si funciona
        Route::delete('/intento/examen/{id}', [IntentoExamenController::class, 'destroy']); // Si funciona

        // RUTAS PARA RESULTADO PRACTICA
        Route::get('/resultados/practica', [ResultadoPracticaController::class, 'index']); // Si funciona
        Route::get('/resultado/practica/{id}', [ResultadoPracticaController::class, 'show']); // Si funciona
        Route::post('/resultado/practica', [ResultadoPracticaController::class, 'store']); // Si funciona
        Route::post('/resultado/practica/{id}', [ResultadoPracticaController::class, 'update']); // Si funciona
        Route::delete('/resultado/practica/{id}', [ResultadoPracticaController::class, 'destroy']); // Si funciona

        // RUTAS PARA RESULTADO EXAMEN
        Route::get('/resultados/examen', [ResultadoExamenController::class, 'index']); // Si funciona
        Route::get('/resultado/examen/{id}', [ResultadoExamenController::class, 'show']); // Si funciona
        Route::post('/resultado/examen', [ResultadoExamenController::class, 'store']); // Si funciona
        Route::post('/resultado/examen/{id}', [ResultadoExamenController::class, 'update']); // Si funciona
        Route::delete('/resultado/examen/{id}', [ResultadoExamenController::class, 'destroy']); // Si funciona

        // Rutas para Actividad Examen
        Route::get('/actividad-examenes', [ActividadExamenController::class, 'index']);
        Route::post('/actividad-examenes', [ActividadExamenController::class, 'store']);
        Route::get('/actividad-examenes/{id}', [ActividadExamenController::class, 'show']);
        Route::put('/actividad-examenes/{id}', [ActividadExamenController::class, 'update']);
        Route::delete('/actividad-examenes/{id}', [ActividadExamenController::class, 'destroy']);

        // Rutas para Nivel Bloom
        Route::get('/nivel-blooms', [NivelBloomController::class, 'index']);
        Route::post('/nivel-blooms', [NivelBloomController::class, 'store']);
        Route::get('/nivel-blooms/{id}', [NivelBloomController::class, 'show']);
        Route::put('/nivel-blooms/{id}', [NivelBloomController::class, 'update']);
        Route::delete('/nivel-blooms/{id}', [NivelBloomController::class, 'destroy']);

        // Rutas para Asignaturas
        Route::get('/asignaturas', [AsignaturaController::class, 'index']);
        Route::post('/asignaturas', [AsignaturaController::class, 'store']);
        Route::get('/asignaturas/{id}', [AsignaturaController::class, 'show']);
        Route::put('/asignaturas/{id}', [AsignaturaController::class, 'update']);
        Route::delete('/asignaturas/{id}', [AsignaturaController::class, 'destroy']);

        // Rutas para Temas
        Route::get('/temas', [TemaController::class, 'index']);
        Route::post('/temas', [TemaController::class, 'store']);
        Route::get('/temas/{id}', [TemaController::class, 'show']);
        Route::put('/temas/{id}', [TemaController::class, 'update']);
        Route::delete('/temas/{id}', [TemaController::class, 'destroy']);

        // Rutas para Preguntas
        Route::get('/preguntas', [PreguntaController::class, 'index']);
        Route::post('/preguntas', [PreguntaController::class, 'store']);
        Route::get('/preguntas/{id}', [PreguntaController::class, 'show']);
        Route::put('/preguntas/{id}', [PreguntaController::class, 'update']);
        Route::delete('/preguntas/{id}', [PreguntaController::class, 'destroy']);

        // Rutas para Dificultades
        Route::get('/dificultades', [DificultadController::class, 'index']);
        Route::post('/dificultades', [DificultadController::class, 'store']);
        Route::get('/dificultades/{id}', [DificultadController::class, 'show']);
        Route::put('/dificultades/{id}', [DificultadController::class, 'update']);
        Route::delete('/dificultades/{id}', [DificultadController::class, 'destroy']);

        // Rutas para Tipo de Pregunta
        Route::get('/tipo-preguntas', [TipoPreguntaController::class, 'index']);
        Route::post('/tipo-preguntas', [TipoPreguntaController::class, 'store']);
        Route::get('/tipo-preguntas/{id}', [TipoPreguntaController::class, 'show']);
        Route::put('/tipo-preguntas/{id}', [TipoPreguntaController::class, 'update']);
        Route::delete('/tipo-preguntas/{id}', [TipoPreguntaController::class, 'destroy']);

        // Rutas para Pregunta Actividad Examen
        Route::get('/pregunta-actividad-examenes', [PreguntaActividadExamenController::class, 'index']);
        Route::post('/pregunta-actividad-examenes', [PreguntaActividadExamenController::class, 'store']);
        Route::get('/pregunta-actividad-examenes/{id}', [PreguntaActividadExamenController::class, 'show']);
        Route::put('/pregunta-actividad-examenes/{id}', [PreguntaActividadExamenController::class, 'update']);
        Route::delete('/pregunta-actividad-examenes/{id}', [PreguntaActividadExamenController::class, 'destroy']);

        // Rutas para Opción Respuesta
        Route::get('/opcion-respuestas', [OpcionRespuestaController::class, 'index']);
        Route::post('/opcion-respuestas', [OpcionRespuestaController::class, 'store']);
        Route::get('/opcion-respuestas/{id}', [OpcionRespuestaController::class, 'show']);
        Route::put('/opcion-respuestas/{id}', [OpcionRespuestaController::class, 'update']);
        Route::delete('/opcion-respuestas/{id}', [OpcionRespuestaController::class, 'destroy']);
    });
});
