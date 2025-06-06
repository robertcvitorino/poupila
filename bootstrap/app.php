<?php

use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\VerificarExpiracaoToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api([
            ForceJsonResponse::class,
            'token.expiration' => \App\Http\Middleware\VerificarExpiracaoToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
