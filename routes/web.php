<?php

use App\Http\Controllers\BackController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;


Route::domain('{subdomain}.gazetkapromocyjna.local')->group(function () {
    Route::get('/', function ($subdomain) {

        return view('subdomain.index', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> 'Dino gazetka • najnowsze ulotki i aktualne oferty promocyjne w Dino od 1.10',
            ]);
    });

    Route::get('/poznan', function ($subdomain) {

        return view('subdomain.index_gps', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Poznań',
                'h1Title'=> 'Dino gazetka • najnowsze ulotki i aktualne oferty promocyjne w Dino od 1.10 - Poznań',
            ]);
    });

    Route::get('/gazetka-promocyjna-1', function ($subdomain) {
        function truncate($val, $f="0")
        {
            if(($p = strpos($val, '.')) !== false) {
                $val = floatval(substr($val, 0, $p + 1 + $f));
            }
            return $val;
        }


        $agent = new Agent();
        $isMobile = $agent->isMobile(); // Zwraca true, jeśli to urządzenie mobilne
        list($width, $height, $type, $attr) = getimagesize('https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/1.jpg');




        $pages = [
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/1.jpg',
                    'clicks' => [
                        ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                        ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]

                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/2.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]

                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/3.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]

                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/4.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/5.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/6.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/7.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/8.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/9.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/10.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/11.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/12.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/13.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/14.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/15.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/16.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/17.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ],
            ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/18.jpg',
                'clicks' => [
                    ['url' => 'http://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
                    ['url' => 'http://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]
                ]
            ]
            // Dodaj więcej stron
        ];
        $pagesCollection = collect($pages);
        $ads = [15];
        $inserts = [5,9];
        $insertData = [
            ['after' => 5,'img' => 'https://placehold.co/718x1200/gray/white?text=AD1+955+x+1200', 'clicks' => [
                ['url' => 'http://example1.com', 'x' => 50, 'y' => 10, 'width' => 270, 'height' => 580],
                ['url' => 'http://example1.com', 'x' => 200, 'y' => 400, 'width' => 50, 'height' => 50]

            ]],
            ['after' => 9,'img' => 'https://placehold.co/718x1200/gray/white?text=AD1+488+x+800', 'clicks' => [
                ['url' => 'http://example1.com', 'x' => 100, 'y' => 200, 'width' => 50, 'height' => 50],
                ['url' => 'http://example1.com', 'x' => 200, 'y' => 400, 'width' => 50, 'height' => 50]

            ]],
        ];


        return view('subdomain.leaflet', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Poznań',
                'h1Title'=> 'Gazetka promocyjna z Dino "Najbliżej Ciebie" (ważna od 10-10 do 16-10-2024)',
                'isMobile' => $isMobile,
                'pages' => $pages,
                'width' => $width,
                'height' => $height,
                'inserts' => $inserts,
                'insertData' => $insertData,
                'ads' => $ads,


            ]);
    });
});



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


Route::get('/gazetki-promocyjne-wszystkie,0', function () {

    return view('main.leaflets', data:
        [
            'data' => '',
            'image' => '',
            'slug' => 'Warszawa',
            'h1Title'=> 'Gazetki <strong>promocyjne</strong>',
        ]);
})->name('gazetki-promocyjne-wszystkie');

Route::get('/gazetki-promocyjne-wszystkie,0/poznan', function () {

    return view('main.leaflets_gps', data:
        [
            'data' => '',
            'image' => '',
            'slug' => 'Poznań',
            'h1Title'=> 'Gazetki <strong>promocyjne</strong>',
        ]);
});

Route::get('/sieci-handlowe-wszystkie,0', function () {

    return view('main.retailers', data:
        [
            'data' => '',
            'image' => '',
            'slug' => 'Poznań',
            'h1Title'=> 'Sieci <strong>handlowe</strong>',
        ]);
});

Route::get('/sieci-handlowe-wszystkie,0/poznan', function () {

    return view('main.retailers_gps', data:
        [
            'data' => '',
            'image' => '',
            'slug' => 'Poznań',
            'h1Title'=> 'Sieci <strong>handlowe</strong>',
        ]);
});

Route::get('/kupony-rabatowe-wszystkie,0', function () {

    return view('main.coupons', data:
        [
            'data' => '',
            'image' => '',
            'slug' => 'Poznań',
            'h1Title'=> '<strong>Kupony rabatowe</strong>',
        ]);
});


Route::get('/', function () {

    return view('main.index', data:
        [
            'data' => '',
            'image' => '',
            'slug' => 'Warszawa',
            'h1Title'=> 'Wszystkie gazetki promocyjne <strong>w jednym miejscu</strong>',
        ]);
});

Route::get('/poznan', function () {

    return view('main.index_gps', data:
        [
            'data' => '',
            'image' => '',
            'slug' => 'Poznań',
            'h1Title'=> 'Wszystkie gazetki promocyjne <strong>w jednym miejscu - Poznań</strong>',
        ]);
});



Route::get('/{slug}', function ($slug) {

    return view('main.index', data:
        [
            'data' => '',
            'image' => '',
            'slug' => $slug,
        ]);
});

Route::get('/panel/', [Backcontroller::class, 'index']);

Route::get('/panel/shops/{shop}/', [BackController::class, 'clickableIndex']);


Route::get('/shops/', function () {

    return view('shops.index', data:
        [
            'data' => '',
            'image' => '',
        ]);
});




Route::post('/generator', [BackController::class, 'generator']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
