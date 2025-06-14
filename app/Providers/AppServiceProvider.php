<?php

namespace App\Providers;

use App\Services\Scrapers\LidlScraper;
use App\Services\Scrapers\MediaMarktScraper;
use App\Services\ScraperService;
use App\Services\WritesonicService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ScraperService::class, function () {
            return new ScraperService([
                new LidlScraper(),
                new MediaMarktScraper()
                // Dodaj inne scraper strategie tutaj
            ]);
        });

        $this->app->singleton(WritesonicService::class, function ($app) {
            return new WritesonicService();
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('custom-paginator');

        Paginator::defaultSimpleView('custom-paginator');

        if (app()->environment('production') && file_exists(config_path('admanager.production.php'))) {
            config(['admanager' => require config_path('admanager.production.php')]);
        }


    }
}
