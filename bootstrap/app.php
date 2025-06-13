<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;


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
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('queue:work --stop-when-empty')
            ->name('queue-worker')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/queue.log'));

        $schedule->call(function () {
            try {

                $response = Http::get(route('admin.products.writesonic'));

                if ($response->successful()) {
                    $data = $response->json();
                    $total = $data['processed'] ?? 0;

                    Log::info("[WritesonicSchedule] Wysłano {$total} produktów do opisania.");
                } else {
                    Log::error('[WritesonicSchedule] Błąd HTTP: ' . $response->status());
                }
            } catch (\Throwable $e) {
                Log::error('[WritesonicSchedule] Wyjątek: ' . $e->getMessage());
            }
        })
            ->name('Writesonic')
            ->everyFifteenMinutes()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/writesonic.log'));
    })
    ->create();

//$app->register(new Illuminatech\UrlTrailingSlash\RoutingServiceProvider($app)); // register trailing slashes routing
//
//return $app;
