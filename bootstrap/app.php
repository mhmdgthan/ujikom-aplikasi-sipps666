<?php

// =====================================================
// FILE 1: bootstrap/app.php (FIXED untuk Laravel 11)
// =====================================================

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan middleware alias
        $middleware->alias([
            'check.role' => \App\Http\Middleware\CheckRole::class,
            'prevent.back' => \App\Http\Middleware\PreventBackHistory::class,
        ]);
        
        // Tambahkan middleware guest untuk route login
        $middleware->redirectGuestsTo('/login');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();