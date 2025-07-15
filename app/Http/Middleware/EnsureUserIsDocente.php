<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsDocente
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


     public function handle(Request $request, Closure $next): Response
{
    // Obtener el usuario autenticado
    $usuario = $request->user();  

    if (!$usuario) {
        return response()->json([
            'message' => 'No autenticado'
        ], 401);
    }

        //antes de comprobar si quiera si es un usuario, comprobar si es superusuario

    if($usuario->tieneRol('superusuario')){

         return $next($request);
    }

    // Verificar si es doente
    if (!$usuario->tieneRol('docente')) {
        return response()->json([
            'message' => 'Acceso denegado. Se requiere rol de docente',
            'tu_rol' => $usuario->getRol()
        ], 403);
    }

    return $next($request);
}
}