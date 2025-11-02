<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add CORS middleware at the very beginning
        $middleware->prepend(\App\Http\Middleware\CorsMiddleware::class);
        
        // Disable CSRF for login/register during testing
        $middleware->validateCsrfTokens(except: [
            'login',
            'register',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();