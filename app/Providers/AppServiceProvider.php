<?php

namespace App\Providers;

use App\Services\Ocr\AbstractOcrService;
use App\Services\Ocr\Parsers\AuchanBlockParser;
use App\Services\Ocr\Parsers\BiedronkaBlockParser;
use App\Services\Ocr\Parsers\CarrefourBlockParser;
use App\Services\Ocr\Parsers\ChataPolskaBlockParser;
use App\Services\Ocr\RetailerContext;
use App\Services\Ocr\Retailers\AuchanOcrService;
use App\Services\Ocr\Retailers\BiedronkaOcrService;
use App\Services\Ocr\Retailers\CarrefourOcrService;
use App\Services\Ocr\Retailers\ChataPolskaOcrService;
use App\Services\Scrapers\LidlScraper;
use App\Services\Scrapers\MediaMarktScraper;
use App\Services\ScraperService;
use App\Services\WritesonicService;
use Illuminate\Pagination\Paginator;
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

        $this->app->bind(AbstractOcrService::class, function ($app) {

            return match (RetailerContext::current()) {
                'chata-polska'  => new ChataPolskaOcrService($app->make(ChataPolskaBlockParser::class)),
                'carrefour'     => new CarrefourOcrService($app->make(CarrefourBlockParser::class)),
                'auchan'        => new AuchanOcrService($app->make(AuchanBlockParser::class)),
                default         => new BiedronkaOcrService($app->make(BiedronkaBlockParser::class)),
            };
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
