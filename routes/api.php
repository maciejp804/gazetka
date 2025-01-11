<?php

use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\Route;

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
