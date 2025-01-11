<?php

use App\Http\Middleware\TrailingSlashMiddleware;
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
        $middleware->encryptCookies(except: [
            'user_location',
        ]);
//        $middleware->prependToGroup('web', Illuminatech\UrlTrailingSlash\Middleware\RedirectTrailingSlash::class); // enable automatic redirection on incorrect URL trailing slashes
        // probably you do not need trailing slash redirection anywhere besides public web routes,
        // thus there is no reason for addition its middleware to other groups, like API
        // ...
       //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

//$app->register(new Illuminatech\UrlTrailingSlash\RoutingServiceProvider($app)); // register trailing slashes routing
//
//return $app;
