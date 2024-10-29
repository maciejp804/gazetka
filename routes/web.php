<?php

use App\Http\Controllers\BackController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;


$mainDomain = env('MAIN_DOMAIN', 'gazetkapromocyjna.local');

$blogCategory = [
    ['name' => 'Porady', 'id' => '1', 'qty' => 10, 'slug' => 'porady'],
    ['name' => 'Recenzje', 'id' => '2', 'qty' => 22, 'slug' => 'recenzje'],
    ['name' => 'Gazetki', 'id' => '3', 'qty' => 39, 'slug' => 'gazetki'],
    ['name' => 'Porównania', 'id' => '4', 'qty' => 39, 'slug' => 'porownania'],
];

$descriptions = [
    ['img' => 'http://165.232.144.14/static/assets/image/pro/Zrzut ekranu 2022-07-12 o 15.23 2.png',
        'h2Title' => 'Gazetki promocyjne - czy warto do nich<br> zaglądać?',
        'h3Title' => 'Gazetki promocyjne wydają wszystkie sieci handlowe. Znajdziesz je bezpośrednio
                    w sklepie, ale także w wygodniejszej formie w internecie.',
        'p' => ['Dzięki najnowszym ulotkom możesz w łatwy sposób dowiedzieć się o
                    aktualnych ofertach ulubionych miejsc. Warto zaglądać do gazetek promocyjnych w formacie pdf, bo to
                    właśnie w nich sieci handlowe informują o nowych produktach, które pojawią się w najbliższych
                    tygodniach. Są to zawsze rzeczy do znalezienia na półkach niezależnie od dnia, jak i wyjątkowe
                    produkty pojawiające się wyłącznie sezonowo.',
            'Aktualne gazetki są przede wszystkim źródłem wiedzy o cenach, więc
                    warto je regularnie sprawdzać. Przeglądając ofertę kilku sieci handlowych w ulotkach dostępnych w
                    formacie pdf, masz szansę na wybór najtańszego sklepu. Wybierzesz z nich zdrowe i pyszne artykuły
                    spożywcze, ale nie tylko. Znajdują się w nich także przedmioty potrzebne w domu, ogrodzie czy
                    warsztacie. Gazetki wydają bowiem nie tylko popularne dyskonty, ale również sklepy meblowe, drogerie
                    oraz sklepy odzieżowe.'],
    ],

    ['img' => 'http://165.232.144.14/static/assets/image/pro/Zrzut ekranu 2022-07-12 o 15.23 1.png',
        'h2Title' => 'Gazetki promocyjne - czy warto do nich<br> zaglądać?',
        'h3Title' => 'Gazetki promocyjne wydają wszystkie sieci handlowe. Znajdziesz je bezpośrednio
                    w sklepie, ale także w wygodniejszej formie w internecie.',
        'p' => ['Dzięki najnowszym ulotkom możesz w łatwy sposób dowiedzieć się o
                    aktualnych ofertach ulubionych miejsc. Warto zaglądać do gazetek promocyjnych w formacie pdf, bo to
                    właśnie w nich sieci handlowe informują o nowych produktach, które pojawią się w najbliższych
                    tygodniach. Są to zawsze rzeczy do znalezienia na półkach niezależnie od dnia, jak i wyjątkowe
                    produkty pojawiające się wyłącznie sezonowo.',
            'Aktualne gazetki są przede wszystkim źródłem wiedzy o cenach, więc
                    warto je regularnie sprawdzać. Przeglądając ofertę kilku sieci handlowych w ulotkach dostępnych w
                    formacie pdf, masz szansę na wybór najtańszego sklepu. Wybierzesz z nich zdrowe i pyszne artykuły
                    spożywcze, ale nie tylko. Znajdują się w nich także przedmioty potrzebne w domu, ogrodzie czy
                    warsztacie. Gazetki wydają bowiem nie tylko popularne dyskonty, ale również sklepy meblowe, drogerie
                    oraz sklepy odzieżowe.'],
    ],
    ['img' => 'http://165.232.144.14/static/assets/image/pro/Zrzut ekranu 2022-07-12 o 15.26 1.png',
        'h2Title' => 'Gazetki promocyjne - czy warto do nich<br> zaglądać?',
        'h3Title' => 'Gazetki promocyjne wydają wszystkie sieci handlowe. Znajdziesz je bezpośrednio
                    w sklepie, ale także w wygodniejszej formie w internecie.',
        'p' => ['Dzięki najnowszym ulotkom możesz w łatwy sposób dowiedzieć się o
                    aktualnych ofertach ulubionych miejsc. Warto zaglądać do gazetek promocyjnych w formacie pdf, bo to
                    właśnie w nich sieci handlowe informują o nowych produktach, które pojawią się w najbliższych
                    tygodniach. Są to zawsze rzeczy do znalezienia na półkach niezależnie od dnia, jak i wyjątkowe
                    produkty pojawiające się wyłącznie sezonowo.',
            'Aktualne gazetki są przede wszystkim źródłem wiedzy o cenach, więc
                    warto je regularnie sprawdzać. Przeglądając ofertę kilku sieci handlowych w ulotkach dostępnych w
                    formacie pdf, masz szansę na wybór najtańszego sklepu. Wybierzesz z nich zdrowe i pyszne artykuły
                    spożywcze, ale nie tylko. Znajdują się w nich także przedmioty potrzebne w domu, ogrodzie czy
                    warsztacie. Gazetki wydają bowiem nie tylko popularne dyskonty, ale również sklepy meblowe, drogerie
                    oraz sklepy odzieżowe.'],
    ],
    ['img' => 'http://165.232.144.14/static/assets/image/pro/Zrzut%20ekranu%202022-07-12%20o%2015.27%201.png',
        'h2Title' => 'Gazetki promocyjne - czy warto do nich<br> zaglądać?',
        'h3Title' => 'Gazetki promocyjne wydają wszystkie sieci handlowe. Znajdziesz je bezpośrednio
                    w sklepie, ale także w wygodniejszej formie w internecie.',
        'p' => ['Dzięki najnowszym ulotkom możesz w łatwy sposób dowiedzieć się o
                    aktualnych ofertach ulubionych miejsc. Warto zaglądać do gazetek promocyjnych w formacie pdf, bo to
                    właśnie w nich sieci handlowe informują o nowych produktach, które pojawią się w najbliższych
                    tygodniach. Są to zawsze rzeczy do znalezienia na półkach niezależnie od dnia, jak i wyjątkowe
                    produkty pojawiające się wyłącznie sezonowo.',
            'Aktualne gazetki są przede wszystkim źródłem wiedzy o cenach, więc
                    warto je regularnie sprawdzać. Przeglądając ofertę kilku sieci handlowych w ulotkach dostępnych w
                    formacie pdf, masz szansę na wybór najtańszego sklepu. Wybierzesz z nich zdrowe i pyszne artykuły
                    spożywcze, ale nie tylko. Znajdują się w nich także przedmioty potrzebne w domu, ogrodzie czy
                    warsztacie. Gazetki wydają bowiem nie tylko popularne dyskonty, ale również sklepy meblowe, drogerie
                    oraz sklepy odzieżowe.'],
    ]
];

$pages = [
    ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/1.jpg',
        'clicks' => [
            ['url' => 'https://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
            ['url' => 'https://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]

        ]
    ],
    ['img' => 'https://lidl.gazetkapromocyjna.com.pl/1653/pages/large/2.jpg',
        'clicks' => [
            ['url' => 'https://example1.com', 'x' => 2, 'y' => 38, 'width' => 46, 'height' => 19],
            ['url' => 'https://example1.com', 'x' => 51, 'y' => 58, 'width' => 44, 'height' => 19]

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

$ads = [15];
$inserts = [5,9];
$insertData = [
    ['after' => 5,'img' => 'https://placehold.co/449x750/gray/white?text=AD1+449+x+750', 'clicks' => [
        ['url' => 'http://example1.com', 'x' => 50, 'y' => 10, 'width' => 270, 'height' => 580],
        ['url' => 'http://example1.com', 'x' => 200, 'y' => 400, 'width' => 50, 'height' => 50]

    ]],
    ['after' => 9,'img' => 'https://placehold.co/718x1200/gray/white?text=AD1+488+x+800', 'clicks' => [
        ['url' => 'http://example1.com', 'x' => 100, 'y' => 200, 'width' => 50, 'height' => 50],
        ['url' => 'http://example1.com', 'x' => 200, 'y' => 400, 'width' => 50, 'height' => 50]

    ]],
];


Route::domain('{subdomain}.'.$mainDomain)->group(function () use ($pages, $ads, $inserts, $insertData) {

    Route::get('/godziny-otwarcia/wielen-os-przytorze-36' ,function ($subdomain){

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Dino Wieleń', 'url' => route('subdomain.index_gps', ['subdomain' => $subdomain])],
            ['label' => 'os. Przytorze 36', 'url' => ''],
        ];

        return view('subdomain.shop', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Wieleń',
                'h1Title'=> 'Dino Wieleń, os. Przytorze 36',
                'subdomain' => $subdomain,
                'breadcrumbs' => $breadcrumbs,
            ]);
    })->name('subdomain.shop');

    Route::get('/w-gazetce/{product}' ,function ($subdomain, $product){
        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => $product, 'url' => ""]
        ];

        return view('subdomain.product', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Wieleń',
                'h1Title'=> $product.' w Dino',
                'subdomain' => $subdomain,
                "breadcrumbs" => $breadcrumbs,
            ]);
    })->name('subdomain.product');

    Route::get('/', function ($subdomain) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Dino Poznań', 'url' => ""],
        ];

        return view('subdomain.index', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> 'Dino gazetka • najnowsze ulotki i aktualne oferty promocyjne w Dino od 1.10',
                'subdomain' => $subdomain,
                'breadcrumbs' => $breadcrumbs,
            ]);
    })->name('subdomain.index');

    Route::get('/poznan', function ($subdomain) {
        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Dino Pozna', 'url' => ""]
        ];

        return view('subdomain.index_gps', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Poznań',
                'h1Title'=> 'Dino gazetka • najnowsze ulotki i aktualne oferty promocyjne w Dino od 1.10 - Poznań',
                'subdomain' => $subdomain,
                'breadcrumbs' => $breadcrumbs,
            ]);
    })->name('subdomain.index_gps');

    Route::get('/gazetka-promocyjna-1', function ($subdomain) use ($pages, $inserts, $insertData, $ads) {

        $agent = new Agent();
        $isMobile = $agent->isMobile(); // Zwraca true, jeśli to urządzenie mobilne

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Gazetka promocyjna z Dino', 'url' => '']
        ];

        return view('subdomain.leaflet', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Poznań',
                'h1Title'=> 'Gazetka promocyjna z Dino "Najbliżej Ciebie" (ważna od 10-10 do 16-10-2024)',
                'isMobile' => $isMobile,
                'pages' => $pages,
                'inserts' => $inserts,
                'insertData' => $insertData,
                'ads' => $ads,
                'subdomain' => $subdomain,
                'breadcrumbs' => $breadcrumbs


            ]);
    })->name('subdomain.leaflet');
});





Route::domain($mainDomain)->group(function () use ($descriptions, $blogCategory) {

    Route::get('/gazetki-promocyjne', function () use ($descriptions) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki promocyjne', 'url' => ''],
        ];

        return view('main.leaflets', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> 'Gazetki <strong>promocyjne</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
            ]);
    })->name('main.leaflets');

    Route::get('/gazetki-promocyjne/poznan', function () use ($descriptions) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Gazetki Promocyjne', 'url' => route('main.leaflets')],
            ['label' => 'Poznań', 'url' => ''],
        ];

        return view('main.leaflets_gps', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Poznań',
                'h1Title'=> 'Gazetki <strong>promocyjne</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
            ]);
    });

    Route::get('/sieci-handlowe', function () use ($descriptions) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Sieci handlowe', 'url' => ''],
        ];

        return view('main.retailers', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Poznań',
                'h1Title'=> 'Sieci <strong>handlowe</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
            ]);
    })->name('main.retailers');

    Route::get('/sieci-handlowe/poznan', function () use ($descriptions){

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Sieci handlowe', 'url' => route('main.retailers')],
            ['label' => 'Poznań', 'url' => ''],
        ];

        return view('main.retailers_gps', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Poznań',
                'h1Title'=> 'Sieci <strong>handlowe</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
            ]);
    });

    Route::get('/kupony-rabatowe', function () use ($descriptions) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Kupony rabatowe', 'url' => ''],
        ];

        return view('main.coupons', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Poznań',
                'h1Title'=> '<strong>Kupony rabatowe</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
            ]);
    })->name('main.coupons');

    Route::get('/produkty', function () use ($descriptions) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => ''],
        ];

        return view('main.products', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> '<strong>Produkty - promocje w gazetkach</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
            ]);
    })->name('main.products');

    Route::get('/produkty/{name}', function ($name) use ($descriptions) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Produkty', 'url' => route('main.products')],
            ['label' => $name, 'url' => ''],
        ];

        return view('main.product', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> '<strong>Pomidory- promocje w gazetkach</strong>',
                'id' => 1,
                'name' => $name,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs
            ]);
    })->name('main.product');

    Route::get('/abc-zakupowicza', function () use ($descriptions, $blogCategory) {
        $sum = 0;
        foreach ($blogCategory as $item) {
            $sum += $item['qty'];
        }

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'ABC Zakupowicza', 'url' => ''],
        ];

        return view('main.blogs', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> 'ABC zakupowicza',
                'descriptions' => $descriptions,
                'blogCategory' => $blogCategory,
                'sum' => $sum,
                'breadcrumbs' => $breadcrumbs
            ]);
    })->name('main.blogs');

    Route::get('/abc-zakupowicza/porady', function () use ($descriptions, $blogCategory) {
        $sum = 0;
        foreach ($blogCategory as $item) {
            $sum += $item['qty'];
        }

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'ABC Zakupowicza', 'url' => route('main.blogs')],
            ['label' => 'Porady', 'url' => ''],
        ];

        return view('main.blogs_category', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> 'ABC zakupowicza',
                'descriptions' => $descriptions,
                'blogCategory' => $blogCategory,
                'sum' => $sum,
                'breadcrumbs' => $breadcrumbs
            ]);
    })->name('main.blogs_category');

    Route::get('/abc-zakupowicza/porady/{name}', function ($name) use ($descriptions, $blogCategory) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'ABC Zakupowicza', 'url' => route('main.blogs')],
            ['label' => 'Porady', 'url' =>  route('main.blogs_category')],
            ['label' => 'Artykuł', 'url' => ''],
        ];

        return view('main.blog_article', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> "Jak wywołać zdjęcia w Rossmannie i zaoszczędzić pieniądze?",
                'descriptions' => $descriptions,
                'blogCategory' => $blogCategory,
                'breadcrumbs' => $breadcrumbs
            ]);
    })->name('main.blog_article');


    Route::get('/', function () use ($descriptions) {

        $breadcrumbs = [];

        return view('main.index', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> 'Wszystkie gazetki promocyjne <strong>w jednym miejscu</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs
            ]);
    })->name('main.index');

    Route::get('/poznan', function () use ($descriptions) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Poznań', 'url' => ''],
        ];

        return view('main.index_gps', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Poznań',
                'h1Title'=> 'Wszystkie gazetki promocyjne <strong>w jednym miejscu - Poznań</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs
            ]);
    });



    Route::get('/{slug}', function ($slug) use ($descriptions) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino Wieleń', 'url' => ''],
            ['label' => 'os. Przytorze 36', 'url' => ''],
        ];

        return view('main.index', data:
            [
                'data' => '',
                'image' => '',
                'slug' => $slug,
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs
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
