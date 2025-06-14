<?php

use App\Services\ProductDescriptionService;
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

        $schedule->call(function (ProductDescriptionService $productDescriptionService) {
            try {
                $totalDispatched = $productDescriptionService->writesonicGeneral();
                Log::info("[Writesonic General] Wysłano {$totalDispatched} produktów do opisania.");
            } catch (\Throwable $e) {
                Log::error('[Writesonic General] Wyjątek: ' . $e->getMessage());
            }
        })
            ->name('Writesonic General')
            ->everyFifteenMinutes()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/writesonic.log'));

        $schedule->call(function (ProductDescriptionService $productDescriptionService) {
            try {
                $totalDispatched  = $productDescriptionService->writesonicShop();
                Log::info("[Writesonic Shop] Wysłano -  {$totalDispatched} produktów do opisania.");
            } catch (\Throwable $e) {
                Log::error('[Writesonic Shop] Wyjątek: ' . $e->getMessage());
            }
        })
            ->name('Writesonic Shop')
            ->everyFifteenMinutes()
            ->at('07')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/writesonic.log'));
    })
    ->create();
