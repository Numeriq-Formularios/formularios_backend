<?php

use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*This file contains all files of routing */
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        /*Web only have method get*/
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
         
    )
    ->withMiddleware(function (Middleware $middleware) {
       // $middleware->append(EnsureIsDocente::class);
       // $middleware->append(EnsureTokenIsAlumno::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
