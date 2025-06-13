<?php

namespace App\Console\Schedule;

use Illuminate\Console\Scheduling\Schedule;

class QueueSchedule
{
    public function __invoke(Schedule $schedule): void
    {
        $schedule->command('queue:work --stop-when-empty')
            ->name('queue-worker')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/queue.log'));
    }
}
