<?php

use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

$mainDomain = config('app.main_domain');

Route::get('/robots.txt', function ()  use ($mainDomain) {
    $host = request()->getHost();

    $isMain = $host === $mainDomain || $host === 'www.' . $mainDomain;

    $sitemapUrl = $isMain
        ? url('/sitemaps/sitemap-main.xml')
        : url('/sitemaps/sitemap-' . explode('.', $host)[0] . '.xml');

    $robots = App::environment('production')
        ? "User-agent: *\nDisallow:\n\nSitemap: {$sitemapUrl}"
        : "User-agent: *\nDisallow: /\n\nSitemap: {$sitemapUrl}";

    return response($robots, 200)->header('Content-Type', 'text/plain');
});

Route::post('/api/nearest-location',[LocationController::class,'findNearestLocation'])->name('api.nearest-location')  ;

Route::get('/api/inserts', function() {
    $insertsData = [
        [
            'after' => 5,
            'img' => 'http://gazetkapromocyjna.local/images/templates/home-you.png',
            'clicks' => json_decode(file_get_contents(public_path('reklama/1.json'))),
        ],
        [
            'after' => 9,
            'img' => 'http://gazetkapromocyjna.local/images/templates/home-you.png',
            'clicks' => json_decode(file_get_contents(public_path('reklama/2.json'))),
        ]
    ];

    return response()->json($insertsData);
});
