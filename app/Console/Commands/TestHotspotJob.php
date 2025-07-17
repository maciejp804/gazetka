<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportHotspotsJob;

class TestHotspotJob extends Command
{
    protected $signature = 'test:hotspot {leafletId} {page} {url}';
    protected $description = 'Testuje wykonanie pojedynczego ImportHotspotsJob';

    public function handle()
    {
        $leafletId = (int) $this->argument('leafletId');
        $page = (int) $this->argument('page');
        $url = $this->argument('url');

        // Można uruchomić bez kolejki:
        (new ImportHotspotsJob($leafletId, $page, $url))->handle();

        $this->info("Job uruchomiony lokalnie dla strony $page");
    }
}
