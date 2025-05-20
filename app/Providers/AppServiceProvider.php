<?php

namespace App\Providers;

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
        //
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
