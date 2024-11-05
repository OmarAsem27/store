<?php

use App\Http\Middleware\MarkNotificationAsRead;
use App\Http\Middleware\UpdateUserLastActiveAt;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(UpdateUserLastActiveAt::class);
        $middleware->web(MarkNotificationAsRead::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
