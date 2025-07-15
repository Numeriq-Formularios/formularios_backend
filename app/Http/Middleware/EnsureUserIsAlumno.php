<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAlumno
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

    
    // Verificar si es alumno   
    if (!$usuario->tieneRol('alumno')) {
        return response()->json([
            'message' => 'Acceso denegado. Se requiere rol de alumno.',
            'tu_rol' => $usuario->getRol()
        ], 403);
    }

    return $next($request);
}
}