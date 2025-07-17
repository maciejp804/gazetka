<?php

use App\Http\Middleware\SetRetailerContextFromLeaflet;
use App\Services\ProductDescriptionService;
use App\Services\VoucherService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'retailer.from.leaflet' => SetRetailerContextFromLeaflet::class,
        ]);
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
            ->between('1:00', '23:59')
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
            ->everyFourMinutes()
            ->between('1:00', '23:59')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/writesonic.log'));

        $schedule->command('sitemap:generate-subdomain')
            ->name('sitemap-generate-subdomain')
            ->dailyAt('00:30')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/sitemap.log'));

        $schedule->command('sitemap:generate-main')
            ->name('sitemap-generate-main')
            ->dailyAt('00:10')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/sitemap.log'));

        $schedule->call(function (VoucherService $voucherService) {
            try {
                $totalDispatched = $voucherService->updateVouchersTradedoubler();
                Log::info("[Tradedoubler Vouchers] Wysłano -  {$totalDispatched} kuponów.");
            } catch (\Throwable $e) {
                Log::error('[Tradedoubler Vouchers] Wyjątek: ' . $e->getMessage());
            }
        })->name('Tradedoubler Vouchers')
            ->twiceDailyAt(1, 13, 15)
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/vouchers.log'));

        $schedule->call(function (VoucherService $voucherService) {
            try {
                $totalDispatched = $voucherService->updateVouchersTradetracker();
                Log::info("[Tradetracker Vouchers] Wysłano -  {$totalDispatched} kuponów.");
            } catch (\Throwable $e) {
                Log::error('[Tradetracker Vouchers] Wyjątek: ' . $e->getMessage());
            }
        })->name('Tradetracker Vouchers')
            ->twiceDailyAt(1, 13, 30)
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/vouchers.log'));

    })
    ->create();
