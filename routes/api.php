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


//Jerarquia de roles 

// rol.alumno es el rol de estudiante,
// rol.docente es el rol de profesor base, 
//y rol.superusuario es el administrador del sistema completo

Route::post('/login', [AuthController::class, 'login']);
Route::post('/singup/usuario/alumno', [AlumnoController::class, 'register']); //Crear cuenta usaurio tipo alumno


//Aqui van todas las funciones del usuario Alumno
Route::middleware(['auth:sanctum', 'rol.alumno'])->group(function () {

    //Rutas de perfil para el usuario alumno
    //Rutas solo accesibles para el usuario alumno, solo puede acceder el alumno validado por policies
    Route::get('/usuario/alumno', [AlumnoController::class, 'meUser']); //Mostrar el perfil del alumno
    Route::post('/usuario/alumno', [AlumnoController::class, 'updateMe']); //Actualizar el perfil del alumno
    Route::delete('/usuario/alumno', [AlumnoController::class, 'destroyMe']); //Eliminado logico del alumno

    //Rutas para la interaccion del alumno con los cursos
    Route::post('/usuario/alumno/curso/{id}', [AlumnoController::class, 'incribirCurso']); // Aqui esta la posibilidad en inscribir un alumno a un curso
    Route::get('/usuario/alumno/cursos', [AlumnoController::class, 'misCursos']); //Los cusos a los que esta inscrito el alumno 
    //Darse de baja de un curso

    //Rutas para contestar una actividad examen
    //Rutas para contestar una actividad practica

    //Ver resultados de act examen por id.
    //Ver resultados de act practica por id.

});


//Rutas disponibles para todos los usuarios autenticados
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/cursos', [CursoController::class, 'index']); //Lista de cursos que esten activos disponibles para todos los usuarios autenticados
    Route::get('/curso/{id}', [CursoController::class, 'show']); //Muestra un curso en especifico
});




//Aqui van todas las funciones del usuario Docente
Route::middleware(['auth:sanctum', 'rol.docente'])->group(function () {

    //Rutas de perfil para el usuario docente
    Route::get('/usuario/docente', [DocenteController::class, 'meUser']);
    Route::post('/usuario/docente', [DocenteController::class, 'updateMe']);
    Route::delete('/usuario/docente', [DocenteController::class, 'destroyMe']);

    //Rutas de especializaciones para el docente
    Route::get('/especializaciones/docente', [DocenteController::class, 'Especialidades']); //Listar especializaciones de un docente
    Route::post('/especializacion/docente/{id}', [DocenteController::class, 'PonerEspecialidad']); //Poner una especialidad a un docente
    Route::delete('/especializacion/docente/{id}', [DocenteController::class, 'EliminarEspecialidad']); //Eliminar una especialidad a  el docente

    //Rutas para la interacccion del docente con las preguntas
    Route::get('/preguntas', [PreguntaController::class, 'index']); //Listar todas las preguntas
    Route::post('/preguntas', [PreguntaController::class, 'store']); //Crear pregunta
    Route::get('/preguntas/{id}', [PreguntaController::class, 'show']); //Mostrar una pregunta en concreto por id
    Route::put('/preguntas/{id}', [PreguntaController::class, 'update']); //Actualizar una pregunta en concreto por id

    //Rutas para las opciones de respuesta de las preguntas
    Route::get('/opcion-respuestas', [OpcionRespuestaController::class, 'index']); //Listen todas las opciones de respuesta existentes
    Route::post('/opcion-respuestas', [OpcionRespuestaController::class, 'store']); //Crea una opcion de respuesta 
    Route::get('/opcion-respuestas/{id}', [OpcionRespuestaController::class, 'show']); //Se trae una opcion de respuesta en concreto por id
    Route::put('/opcion-respuestas/{id}', [OpcionRespuestaController::class, 'update']); //Se actualiza una opcion de respuesta en concreto por id
    //Traer todas las opciones de respuesta por id_pregunta
    //Traer una opcion de respuesta por id_pregunta y id_opcion_respuesta

    //Rutas para cursos
    Route::post('/curso', [CursoController::class, 'store']); //Creacion de un curso
    Route::put('/curso/{id}', [CursoController::class, 'update']); //Actualiza un curso en especifico


    //Rutas para actividad examen
    Route::get('/actividad-examenes', [ActividadExamenController::class, 'index']); //Listar todas las actividades examen  
    Route::post('/actividad-examenes', [ActividadExamenController::class, 'store']); //Crear una actividad examen
    Route::get('/actividad-examenes/{id}', [ActividadExamenController::class, 'show']); //Mostrar una actividad examen en concreto
    Route::put('/actividad-examenes/{id}', [ActividadExamenController::class, 'update']); //Actualizar una actividad examen en concreto

    //Rutas para  actividad practica
    Route::get('/actividades/practicas', [ActividadPracticaController::class, 'index']); //Listar todas las actividades practicas
    Route::get('/actividad/practica/{id}', [ActividadPracticaController::class, 'show']); //Listar una actividad practica en concreto por id
    Route::post('/actividad/practica', [ActividadPracticaController::class, 'store']); //Crear una actividad practica
    Route::post('/actividad/practica/{id}', [ActividadPracticaController::class, 'update']); //Actualizar una actividad practica

    //Rutas para pregunta actividad tipo practica
    Route::get('/preguntas/actividad-practica', [PreguntaActividadPracticaController::class, 'index']); //Listar todas las preguntas de actividades practicas
    Route::get('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'show']); //Listar una pregunta de actividad practica en concreto por id
    Route::post('/pregunta/actividad-practica', [PreguntaActividadPracticaController::class, 'store']); //
    Route::post('/pregunta/actividad-practica/{id}', [PreguntaActividadPracticaController::class, 'update']); //Si funciona

    //Rutas para pregunta actividad tipo examen
    Route::get('/pregunta-actividad-examenes', [PreguntaActividadExamenController::class, 'index']);
    Route::post('/pregunta-actividad-examenes', [PreguntaActividadExamenController::class, 'store']);
    Route::get('/pregunta-actividad-examenes/{id}', [PreguntaActividadExamenController::class, 'show']);
    Route::put('/pregunta-actividad-examenes/{id}', [PreguntaActividadExamenController::class, 'update']);

    //Rutas para los resultados de las actividades tipo examen y tipo practica


    //Rutas para nivel de bloom
    Route::get('/nivel-blooms', [NivelBloomController::class, 'index']); //Listar todos los niveles de bloom
    Route::post('/nivel-blooms', [NivelBloomController::class, 'store']); // Crear nivel de bloom 
    Route::get('/nivel-blooms/{id}', [NivelBloomController::class, 'show']); //Mostrar un nivel de bloom en concreto por id
    Route::put('/nivel-blooms/{id}', [NivelBloomController::class, 'update']); //Actualizar un nivel de bloom en concreto por id

    //Rutas para asignaturas
    Route::get('/asignaturas', [AsignaturaController::class, 'index']); // listar asignaturas
    Route::post('/asignaturas', [AsignaturaController::class, 'store']); // crear una asignatura
    Route::get('/asignaturas/{id}', [AsignaturaController::class, 'show']); //mostrar una asignatura en concreto por id
    Route::put('/asignaturas/{id}', [AsignaturaController::class, 'update']); // Actualizar una asignatura en concreto por id

    //Ruta para temas
    Route::get('/temas', [TemaController::class, 'index']); // listar temas  
    Route::post('/temas', [TemaController::class, 'store']); // crear un tema
    Route::get('/temas/{id}', [TemaController::class, 'show']); // mostrar un tema en concreto por id
    Route::put('/temas/{id}', [TemaController::class, 'update']); // Actualizar un tema en concreto por id

    //Rutas para Dificultad
    Route::get('/dificultades', [DificultadController::class, 'index']); // Listar todas las dificultades
    Route::post('/dificultades', [DificultadController::class, 'store']); // Crear una dificultad
    Route::get('/dificultades/{id}', [DificultadController::class, 'show']); // Mostrar una dificultad en concreto por id
    Route::put('/dificultades/{id}', [DificultadController::class, 'update']); // Actualizar una dificultad en concreto por id

    //Tipo de pregunta
    Route::get('/tipo-preguntas', [TipoPreguntaController::class, 'index']); // Listar todos los tipos de preguntas
    Route::post('/tipo-preguntas', [TipoPreguntaController::class, 'store']); // Crear un tipo de pregunta
    Route::get('/tipo-preguntas/{id}', [TipoPreguntaController::class, 'show']); // Mostrar un tipo de pregunta en concreto por id
    Route::put('/tipo-preguntas/{id}', [TipoPreguntaController::class, 'update']); // Actualizar un tipo de pregunta en concreto por id

    /*Recordemos que un superusuario es un docente, por lo tanto, las rutas que estan
    debajo de este middleware son exclusivas para el superusuario
    Estas rutas son las que se encargan de gestionar los usuarios, alumnos y docentes,
    ademas de las rutas que se encargan de gestionar los cursos, especializaciones,
    actividades, preguntas, intentos, etc.
    */
    Route::middleware('rol.superusuario')->group(function () {

        //Rutas solo accesibles para el superusuario CRUD de los alumnos
        Route::get('/usuarios/alumnos', [AlumnoController::class, 'index']); //Listar todos los usuarios alumnos
        Route::get('/usuario/alumno/{id}', [AlumnoController::class, 'show']); //Mostar un alumno en concreto
        Route::put('/usuario/alumno/{id}', [AlumnoController::class, 'update']); //Actualizar un usuario en concreto
        Route::delete('/usuario/alumno/{id}', [AlumnoController::class, 'destroy']); //Eliminado logico de un usaurio en concreto
        //Route::post('/usuario/alumno/curso/{id}', [AlumnoController::class, 'incribirCurso']); //Inscribir a un alumno en cincreto
        //Route::get('/usuario/alumno/{id}/cursos', [AlumnoController::class, 'misCursos']); //Los cursos a los que esta inscrito un alumno en concreto
        //Route::post('/usuario/alumno/curso/{id}', [AlumnoController::class, 'DesincribirCurso']);                                                                           //Desincribir a un alumno de un curso en concreto


        //Rutas solo accesibles para el superusuario CRUD de los docentes
        Route::post('/singup/usuario/docente', [DocenteController::class, 'register']);  //Solo el superusuario puede crear un docente o un superusuario
        Route::get('/usuarios/docentes/', [DocenteController::class, 'index']); //Lista de docentes
        Route::get('/usuario/docente/{id}', [DocenteController::class, 'show']); //Muestra un docente en especifico
        Route::put('/usuario/docente/{id}', [DocenteController::class, 'update']); //Actualiza un docente en especifico
        Route::delete('/usuario/docente/{id}', [DocenteController::class, 'destroy']); //Elimina un docente en especifico


        //Ruta para cursos
        Route::delete('/curso/{id}', [CursoController::class, 'destroy']); //Elimina un curso en especifico

        //Rutas para agregar la especialidad
        Route::get('/especializaciones', [EspecializacionController::class, 'index']); //Listar especializaciones
        Route::post('/especializacion', [EspecializacionController::class, 'store']); //Crear una especializacion
        Route::get('/especializacion/{id}', [EspecializacionController::class, 'show']); //Mostrar una especializacion en concreto por id
        Route::put('/especializacion/{id}', [EspecializacionController::class, 'update']); //Actualizar una especializacion
        Route::delete('/especializacion/{id}', [EspecializacionController::class, 'destroy']); //Eliminar una especializacion

        // RUTAS PARA ACTIVIDAD PRACTICA
        Route::delete('/actividad/practica/{id}', [ActividadPracticaController::class, 'destroy']); //Eliminar una actividad practica

        // RUTAS PARA PREGUNTA ACTIVIDAD PRACTICA
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

        // RUTAS PARA RESULTADO actividad tipo PRACTICA
        Route::get('/resultados/practica', [ResultadoPracticaController::class, 'index']); // Si funciona
        Route::get('/resultado/practica/{id}', [ResultadoPracticaController::class, 'show']); // Si funciona
        Route::post('/resultado/practica', [ResultadoPracticaController::class, 'store']); // Si funciona
        Route::post('/resultado/practica/{id}', [ResultadoPracticaController::class, 'update']); // Si funciona
        Route::delete('/resultado/practica/{id}', [ResultadoPracticaController::class, 'destroy']); // Si funciona

        // RUTAS PARA RESULTADO actividad tipo  EXAMEN
        Route::get('/resultados/examen', [ResultadoExamenController::class, 'index']); // Si funciona
        Route::get('/resultado/examen/{id}', [ResultadoExamenController::class, 'show']); // Si funciona
        Route::post('/resultado/examen', [ResultadoExamenController::class, 'store']); // Si funciona
        Route::post('/resultado/examen/{id}', [ResultadoExamenController::class, 'update']); // Si funciona
        Route::delete('/resultado/examen/{id}', [ResultadoExamenController::class, 'destroy']); // Si funciona

        // Rutas para Actividad Examen
        Route::delete('/actividad-examenes/{id}', [ActividadExamenController::class, 'destroy']);

        // Rutas para Nivel Bloom
        Route::delete('/nivel-blooms/{id}', [NivelBloomController::class, 'destroy']);

        // Rutas para Asignaturas
        Route::delete('/asignaturas/{id}', [AsignaturaController::class, 'destroy']);

        // Rutas para Temas
        Route::delete('/temas/{id}', [TemaController::class, 'destroy']);

        // Rutas para Preguntas
        Route::delete('/preguntas/{id}', [PreguntaController::class, 'destroy']);

        // Rutas para Dificultades
        Route::delete('/dificultades/{id}', [DificultadController::class, 'destroy']);

        // Rutas para Tipo de Pregunta
        Route::delete('/tipo-preguntas/{id}', [TipoPreguntaController::class, 'destroy']);

        // Rutas para Pregunta Actividad tipo Examen
        Route::delete('/pregunta-actividad-examenes/{id}', [PreguntaActividadExamenController::class, 'destroy']);

        //Rutas para Opcion Respuesta
        Route::delete('/opcion-respuestas/{id}', [OpcionRespuestaController::class, 'destroy']); //Se elimina una opcion de respuesta en concreto por id


    });
});
