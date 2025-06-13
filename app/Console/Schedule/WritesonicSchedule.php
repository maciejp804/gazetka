<?php

namespace App\Console\Schedule;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class WritesonicSchedule
{
    public function __invoke(Schedule $schedule): void
    {
        Log::info('[TEST] Start WritesonicSchedule::__invoke()');

        $schedule->call(function () {
            Log::info('[TEST] Wewnątrz schedule->call (czy wchodzi tutaj?)');
        })
            ->name('writesonic')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/writesonic.log'));
    }

//        $schedule->call(function () {
//            try {
//                Log::info('[TEST] Harmonogram Writesonic działa!');
//                $url = config('app.url') . '/admin/products/writesonic';
//                $response = Http::get($url);
//
//
//                if ($response->successful()) {
//                    $data = $response->json();
//                    $total = $data['total_processed'] ?? 0;
//                    Log::channel('writesonic')->info("Zarejestrowano {$total} jobów.");
//                } else {
//                    Log::channel('writesonic')->error('Błąd HTTP: ' . $response->status());
//                }
//            } catch (\Throwable $e) {
//                Log::channel('writesonic')->error('Błąd harmonogramu: ' . $e->getMessage());
//            }
//        })
//            ->name('writesonic')
//            ->everyMinute()
//            ->withoutOverlapping()
//            ->appendOutputTo(storage_path('logs/writesonic.log'));
//    }
}
