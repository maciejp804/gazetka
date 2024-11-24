<?php

use App\Http\Controllers\BackController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;


$mainDomain = env('MAIN_DOMAIN', 'gazetkapromocyjna.local');

$leaflets = [
    ['name' => 'Biedronka', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://biedronka.gazetkapromocyjna.com.pl/1907/1.jpg'],
    ['name' => 'Delikatesy Centrum', 'category' => 'dom', 'create' => '2024-11-07', 'start' => '2024-11-15',  'end' => '2024-11-25', 'logo' => 'https://delikatesy-centrum.gazetkapromocyjna.com.pl/613/1.jpg'],
    ['name' => 'Biedronka', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-11',  'end' => '2024-11-30', 'logo' => 'https://biedronka.gazetkapromocyjna.com.pl/1906/1.jpg'],
    ['name' => 'Biedronka', 'category' => 'dom', 'create' => '2024-11-06', 'start' => '2024-11-10',  'end' => '2024-11-25', 'logo' => 'https://biedronka.gazetkapromocyjna.com.pl/1905/1.jpg'],
    ['name' => 'Delikatesy Centrum', 'category' => 'zbawki', 'create' => '2024-11-05', 'start' => '2024-11-28',  'end' => '2024-12-31', 'logo' => 'https://delikatesy-centrum.gazetkapromocyjna.com.pl/616/1.jpg'],
    ['name' => 'Biedronka', 'category' => 'zabawki', 'create' => '2024-10-08', 'start' => '2024-10-15',  'end' => '2024-11-09', 'logo' => 'https://biedronka.gazetkapromocyjna.com.pl/1904/1.jpg'],
    ['name' => 'Biedronka', 'category' => 'zabawki', 'create' => '2024-11-08', 'start' => '2024-11-15',  'end' => '2025-03-20', 'logo' => 'https://biedronka.gazetkapromocyjna.com.pl/1903/1.jpg'],
    ['name' => 'Netto', 'category' => 'spozywcze', 'create' => '2024-11-08', 'start' => '2024-11-15',  'end' => '2024-11-30', 'logo' => 'https://netto.gazetkapromocyjna.com.pl/1193/1.jpg'],
    ['name' => 'Netto', 'category' => 'spozywcze', 'create' => '2024-10-31', 'start' => '2024-11-01',  'end' => '2024-11-29', 'logo' => 'https://netto.gazetkapromocyjna.com.pl/1192/1.jpg'],
    ['name' => 'Aldi', 'category' => 'spozywcze', 'create' => '2024-11-08', 'start' => '2024-12-15',  'end' => '2024-12-31', 'logo' => 'https://aldi.gazetkapromocyjna.com.pl/1222/1.jpg'],
    ['name' => 'Aldi', 'category' => 'spozywcze', 'create' => '2024-11-08', 'start' => '2024-11-29',  'end' => '2024-12-02', 'logo' => 'https://aldi.gazetkapromocyjna.com.pl/1221/1.jpg'],
    ['name' => 'Biedronka', 'category' => 'spozywcze', 'create' => '2024-10-18', 'start' => '2024-10-25',  'end' => '2024-11-25', 'logo' => 'https://biedronka.gazetkapromocyjna.com.pl/1902/1.jpg'],
    ['name' => 'Lidl', 'category' => 'dom', 'create' => '2024-11-07', 'start' => '2024-11-15',  'end' => '2024-11-25', 'logo' => 'https://lidl.gazetkapromocyjna.com.pl/1668/1.jpg'],
    ['name' => 'Lidl', 'category' => 'spozywcze', 'create' => '2024-11-07', 'start' => '2024-11-15',  'end' => '2024-11-25', 'logo' => 'https://lidl.gazetkapromocyjna.com.pl/1667/1.jpg']
];

$retailers = [
    ['name' => 'Biedronka', 'category' => 'dom', 'create' => '2024-11-08', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg', 'offers' => 6],
    ['name' => 'Lidl', 'category' => 'dom', 'create' => '2024-11-07', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_1.jpg', 'offers' => 7],
    ['name' => 'Netto', 'category' => 'dom', 'create' => '2024-11-08', 'logo' => 'https://img.blix.pl/image/brand/009a4e69e0832285e5f754b1c2890f1e.jpeg', 'offers' => 5],
    ['name' => 'Delikatesy Centrum', 'category' => 'zbawki', 'create' => '2024-11-05', 'logo' => 'https://img.blix.pl/image/brand/eb13a764611a871d9d004f2bb23aec85.jpeg', 'offers' => 3],
    ['name' => 'Aldi', 'category' => 'spozywcze', 'create' => '2024-11-08', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_66.jpg', 'offers' => 8],
    ['name' => 'Auchan', 'category' => 'spozywcze', 'create' => '2024-10-18', 'logo' => 'https://img.blix.pl/image/brand/f1497864fd7e717193074b0c710960f0.jpg', 'offers' => 4],
    ['name' => 'Carrefour', 'category' => 'dom', 'create' => '2024-11-07', 'logo' => 'https://img.blix.pl/image/brand/dcbfe157c7908a3b4903e7610fb8a704.jpeg', 'offers' => 10],
    ['name' => 'Dino', 'category' => 'spozywcze', 'create' => '2024-11-07', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_71.jpg', 'offers' => 3],
];

$products = [
    ['name' => 'Pomidory malinowe', 'category' => 'spozywcze', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-24 23:59:59', 'logo' => 'https://www.carrefour.pl/images/product/180x180/pomidory-malinowe-wazone-g99e8v.jpg', 'price' => '5,99', ],
    ['name' => 'Chleb baltonowski krojony', 'category' => 'spozywcze', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-19 23:59:59', 'logo' => 'https://www.carrefour.pl/images/product/350x350/chleb-tradycyjny-Cgx4Nf.jpg', 'price' => '7,99'],
    ['name' => 'Mleko UHT 3,2%', 'category' => 'spozywcze', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-17 23:59:59', 'logo' => 'https://www.carrefour.pl/images/product/350x350/laciate-mleko-swieze-32-1-l-7bflld.jpg', 'price' => '2,99'],
    ['name' => 'Wiadro do mopa', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-12-01 23:59:59', 'logo' => 'https://www.carrefour.pl/images/product/350x350/vileda-zestaw-mop-ultramax-box-d0t54q.jpg','price' => '79,99'],
    ['name' => 'Płyn do mycia naczyń', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2025-01-16 23:59:59','logo' => 'https://www.carrefour.pl/images/product/350x350/fairy-extra-lilac-washing-up-liquid-fairys-1-formula-for-fast-tough-grease-cleaning-650ml-llDYxQ.jpg', 'price' => '6,99'],
    ['name' => 'Banany', 'category' => 'owoce', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2028-11-16 23:59:59', 'logo' => 'https://www.carrefour.pl/images/product/350x350/banany-bio-wazone-opakowanie-1f6fdi.jpg', 'price' => '7,49'],
    ['name' => 'Marchew', 'category' => 'warzywa', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-30 23:59:59', 'logo' => 'https://www.carrefour.pl/images/product/350x350/marchew-wazona-46nnrg.jpg', 'price' => '1,99'],
    ['name' => 'Kawa rozpuszczalna Tchibo', 'category' => 'spozywcze', 'create' => '2024-11-08', 'start' => '2024-11-08', 'end' => '2024-11-16 23:59:59', 'logo' => 'https://www.carrefour.pl/images/product/350x350/jacobs-kronung-kawa-mielona-500-g-I0yNTr.jpg', 'price' => '15,99'],
    ['name' => 'Sofa', 'category' => 'spozywcze', 'create' => '2024-11-08', 'start' => '2024-11-08', 'end' => '2024-11-18 23:59:59', 'logo' => 'https://www.carrefour.pl/images/product/350x350/jacobs-kronung-kawa-mielona-500-g-I0yNTr.jpg', 'price' => '1500,99'],
];

$vouchers = [
    ['name' => 'Kruk', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/logo/20096_45x100.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
    ['name' => 'Apart', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/logo/20096_45x100.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
    ['name' => 'Lidl', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_1.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
    ['name' => 'Biedronka', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
    ['name' => 'Kruk', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/logo/20096_45x100.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
    ['name' => 'Kruk', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/logo/20096_45x100.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
    ['name' => 'Kruk', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/logo/20096_45x100.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
    ['name' => 'Kruk', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/logo/20096_45x100.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
    ['name' => 'Kruk', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/logo/20096_45x100.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
    ['name' => 'Kruk', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/logo/20096_45x100.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
    ['name' => 'Kruk', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-08',  'end' => '2024-11-16', 'logo' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/logo/20096_45x100.jpg', 'image' => 'https://gazetkapromocyjna.com.pl/static/images/vouchers/offers/offer-2023-11-21-9157.png', 'uri' => 'https://tc.tradetracker.net/?c=20096&amp;m=1183634&amp;a=222077&amp;r=&amp;u=https%3A%2F%2Fwkruk.pl%2F', 'description' => '15% zniżki na biżuterię ze srebra w sklepie W.KRUK!'],
];

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

$leaflets_category = $retailers_category = [
    ['name' => 'Dom', 'value' => 'dom'],
    ['name' => 'Moda', 'value' => 'moda'],
    ['name' => 'Zabawki', 'value' => 'zabawki'],
    ['name' => 'Art.Spożywcze', 'value' => 'spozywcze'],
    ['name' => 'Ogród', 'value' => 'ogrod'],
];

$leaflets_time = $retailers_time = [
    ['name' => 'Ostatnio dodane', 'value' => 'last'],
    ['name' => 'Kończą się', 'value' => 'ending'],
    ['name' => 'Najnowsze', 'value' => 'newest'],
];



Route::domain('{subdomain}.'.$mainDomain)->group(function () use ($pages, $ads, $inserts, $insertData, $leaflets_category, $leaflets_time, $leaflets, $vouchers, $retailers, $products) {

    Route::get('/godziny-otwarcia/wielen-os-przytorze-36' ,function ($subdomain) use ($leaflets, $leaflets_time, $leaflets_category, $vouchers){

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Dino Wieleń', 'url' => route('subdomain.index_gps', ['subdomain' => $subdomain])],
            ['label' => 'os. Przytorze 36', 'url' => ''],
        ];
        $subdomain = 'lidl';

        // Filtrowanie według nazwy
        $leaflets = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });

        return view('subdomain.shop', data:
            [
                'slug' => 'Wieleń',
                'h1Title'=> 'Dino Wieleń, os. Przytorze 36',
                'subdomain' => $subdomain,
                'breadcrumbs' => $breadcrumbs,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
            ]);
    })->name('subdomain.shop');

    Route::get('/w-gazetce/{product}' ,function ($subdomain, $product) use ($leaflets){
        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => $product, 'url' => ""]
        ];
        $subdomain = 'lidl';

        // Filtrowanie według nazwy
        $leaflets_filtred = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });

        return view('subdomain.product', data:
            [
                'slug' => 'Wieleń',
                'h1Title'=> $product.' w Dino',
                'subdomain' => $subdomain,
                "breadcrumbs" => $breadcrumbs,
                'leaflets' => $leaflets_filtred,
                "leaflets_others" => $leaflets,
            ]);
    })->name('subdomain.product');

    Route::get('/', function ($subdomain) use ($leaflets_category, $leaflets_time, $leaflets, $vouchers) {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => '']
        ];

        $subdomain = 'lidl';

        // Filtrowanie według nazwy
        $leaflets = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });


        return view('subdomain.index', data:
            [
                'slug' => 'Warszawa',
                'h1Title'=> 'Dino gazetka • najnowsze ulotki i aktualne oferty promocyjne w Dino od 1.10',
                'subdomain' => $subdomain,
                'breadcrumbs' => $breadcrumbs,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
            ]);
    })->name('subdomain.index');

    Route::get('/poznan', function ($subdomain) use ($leaflets_category, $leaflets_time, $leaflets, $vouchers) {
        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Dino Poznań', 'url' => ""]
        ];

        $subdomain = 'lidl';

        // Filtrowanie według nazwy
        $leaflets = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });

        return view('subdomain.index_gps', data:
            [
                'slug' => 'Poznań',
                'h1Title'=> 'Dino gazetka • najnowsze ulotki i aktualne oferty promocyjne w Dino od 1.10 - Poznań',
                'subdomain' => $subdomain,
                'breadcrumbs' => $breadcrumbs,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
            ]);
    })->name('subdomain.index_gps');

    Route::get('/gazetka-promocyjna-1', function ($subdomain) use ($pages, $inserts, $insertData, $ads, $leaflets) {

        $agent = new Agent();
        $isMobile = $agent->isMobile(); // Zwraca true, jeśli to urządzenie mobilne

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Dino', 'url' => route('subdomain.index', ['subdomain' => $subdomain])],
            ['label' => 'Gazetka promocyjna z Dino', 'url' => '']
        ];

        $subdomain = 'lidl';

        // Filtrowanie według nazwy
        $leaflets = array_filter($leaflets, function ($item) use ($subdomain) {
            return str_starts_with(strtolower($item['name']), strtolower($subdomain)) !== false;
        });

        return view('subdomain.leaflet', data:
            [
                'slug' => 'Poznań',
                'h1Title'=> 'Gazetka promocyjna z Dino "Najbliżej Ciebie" (ważna od 10-10 do 16-10-2024)',
                'isMobile' => $isMobile,
                'pages' => $pages,
                'inserts' => $inserts,
                'insertData' => $insertData,
                'ads' => $ads,
                'subdomain' => $subdomain,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets


            ]);
    })->name('subdomain.leaflet');


    Route::get('/search/single/dropdown', function(Request $request) {

        $query = $request->input('query');
        $searchType = $request->input('searchType');

        $products = $retailers = $places = [];

        if ($searchType === 'products-retailers') {

            // Tablice przykładowych danych
            $products = [
                ['name' => 'bibuła', 'logo' => 'https://zakupy.biedronka.pl/dw/image/v2/BKFJ_PRD/on/demandware.static/-/Sites-PL_Master_Catalog/default/dw86fc0dc7/images/hi-res/359277.jpg'],
                ['name' => 'biwak', 'logo' => 'https://zakupy.biedronka.pl/dw/image/v2/BKFJ_PRD/on/demandware.static/-/Sites-PL_Master_Catalog/default/dw86fc0dc7/images/hi-res/359277.jpg'],
                ['name' => 'pączek', 'logo' => 'https://zakupy.biedronka.pl/dw/image/v2/BKFJ_PRD/on/demandware.static/-/Sites-PL_Master_Catalog/default/dw86fc0dc7/images/hi-res/359277.jpg'],
            ];

            $retailers = [
                ['name' => 'Biedronka', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Lidl', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_1.jpg'],
                ['name' => 'Netto', 'logo' => 'https://img.blix.pl/image/brand/009a4e69e0832285e5f754b1c2890f1e.jpeg'],
            ];

            // Filtrowanie danych w obu tablicach
            $products = array_filter($products, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false;
            });

            $retailers = array_filter($retailers, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false;
            });

        } elseif ($searchType === 'places') {
            $places = [
                ['name' => 'Poznań', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Piła', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wieleń', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wisła', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wieluń', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wieliczka', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wiktoria', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Warszawa', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wrocław', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
            ];
            $places = array_filter($places, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false;
            });
        }
        // Zwrócenie wyników jako JSON z dwoma kategoriami
        return response()->json([
            'html' => view('components.search-results-dropdown', compact('products', 'retailers', 'places'))->render()
        ]);
    });

    Route::get('search/triple/swiper', function (Request $request) use ($leaflets) {
        $query = $request->input('query');
        if($query !== ''){
            $query = strtolower($query);
        }
        $searchType = $request->input('searchType');
        $category = $request->input('category');
        $time = $request->input('time');


        if ($searchType === 'leaflets') {
            // Filtrowanie według nazwy
            $leaflets = array_filter($leaflets, function ($item) use ($query) {
                return str_starts_with(strtolower($item['name']), strtolower($query)) !== false;
            });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $leaflets = array_filter($leaflets, function ($item) use ($category) {
                    return str_contains($item['category'], $category) !== false;
                });
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case 'ending': // Sortowanie po dacie zakończenia (end)
                        usort($leaflets, function ($a, $b) {
                            return $a['end'] <=> $b['end'];
                        });
                        break;

                    case 'last': // Sortowanie po dacie utworzenia (create)
                        usort($leaflets, function ($a, $b) {
                            return $a['create'] <=> $b['create'];
                        });
                        break;

                    case 'active': // Filtrowanie tylko aktywnych gazetek
                        $leaflets = array_filter($leaflets, function ($item) {
                            $today = date('Y-m-d');
                            return $item['start'] <= $today && $item['end'] >= $today;
                        });
                        break;
                }
            }

        }
        // Zwrócenie wyników jako JSON z widokiem
        return response()->json([
            'html' => view('components.search-results-swiper', compact('leaflets'))->render()
        ]);
    });

    Route::get('search/triple', function (Request $request) use ($leaflets, $retailers, $products, $vouchers) {
        $query = $request->input('query');
        if($query !== ''){
            $query = strtolower($query);
        }
        $searchType = $request->input('searchType');
        $category = $request->input('category');
        $time = $request->input('time');

        if ($searchType === 'leaflets') {

            // Filtrowanie według nazwy
            $leaflets = array_filter($leaflets, function ($item) use ($query) {
                return str_starts_with(strtolower($item['name']), strtolower($query)) !== false;
            });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $leaflets = array_filter($leaflets, function ($item) use ($category) {
                    return str_contains($item['category'], $category) !== false;
                });
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case 'ending': // Sortowanie po dacie zakończenia (end)
                        usort($leaflets, function ($a, $b) {
                            return $a['end'] <=> $b['end'];
                        });
                        break;

                    case 'last': // Sortowanie po dacie utworzenia (create)
                        usort($leaflets, function ($a, $b) {
                            return $a['create'] <=> $b['create'];
                        });
                        break;

                    case 'active': // Filtrowanie tylko aktywnych gazetek
                        $leaflets = array_filter($leaflets, function ($item) {
                            $today = date('Y-m-d');
                            return $item['start'] <= $today && $item['end'] >= $today;
                        });
                        break;
                }
            }
            $retailers = [];
            $products = [];
            $vouchers = [];
        } elseif ($searchType === 'retailers') {
            $retailers = array_filter($retailers, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false;
            });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $retailers = array_filter($retailers, function ($item) use ($category) {
                    return str_contains($item['category'], $category) !== false;
                });
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case 'ending': // Sortowanie po dacie zakończenia (end)
                        usort($retailers, function ($a, $b) {
                            return $a['end'] <=> $b['end'];
                        });
                        break;

                    case 'last': // Sortowanie po dacie utworzenia (create)
                        usort($retailers, function ($a, $b) {
                            return $a['create'] <=> $b['create'];
                        });
                        break;

                    case 'active': // Filtrowanie tylko aktywnych gazetek
                        $retailers = array_filter($retailers, function ($item) {
                            $today = date('Y-m-d');
                            return $item['start'] <= $today && $item['end'] >= $today;
                        });
                        break;
                }
            }

            $leaflets = [];
            $products = [];
            $vouchers = [];

        } elseif ($searchType === 'products'){

            $products = array_filter($products, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false;
            });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $products = array_filter($products, function ($item) use ($category) {
                    return str_contains($item['category'], $category) !== false;
                });
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case 'ending': // Sortowanie po dacie zakończenia (end)
                        usort($products, function ($a, $b) {
                            return $a['end'] <=> $b['end'];
                        });
                        break;

                    case 'last': // Sortowanie po dacie utworzenia (create)
                        usort($products, function ($a, $b) {
                            return $a['create'] <=> $b['create'];
                        });
                        break;

                    case 'active': // Filtrowanie tylko aktywnych gazetek
                        $products = array_filter($products, function ($item) {
                            $today = date('Y-m-d');
                            return $item['start'] <= $today && $item['end'] >= $today;
                        });
                        break;
                }
            }


            $retailers = [];
            $leaflets = [];
            $vouchers = [];
        } elseif ($searchType === 'vouchers') {

            // Filtrowanie według nazwy
            $vouchers = array_filter($vouchers, function ($item) use ($query) {
                return str_starts_with(strtolower($item['name']), strtolower($query)) !== false;
            });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $vouchers = array_filter($vouchers, function ($item) use ($category) {
                    return str_contains($item['category'], $category) !== false;
                });
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case 'ending': // Sortowanie po dacie zakończenia (end)
                        usort($vouchers, function ($a, $b) {
                            return $a['end'] <=> $b['end'];
                        });
                        break;

                    case 'last': // Sortowanie po dacie utworzenia (create)
                        usort($vouchers, function ($a, $b) {
                            return $a['create'] <=> $b['create'];
                        });
                        break;

                    case 'active': // Filtrowanie tylko aktywnych gazetek
                        $vouchers = array_filter($vouchers, function ($item) {
                            $today = date('Y-m-d');
                            return $item['start'] <= $today && $item['end'] >= $today;
                        });
                        break;
                }
            }
            $retailers = [];
            $leaflets = [];
            $products = [];
        }

        // Zwrócenie wyników jako JSON z widokiem
        return response()->json([
            'html' => view('components.search-results-container', compact('leaflets', 'retailers', 'products', 'vouchers'))->render()
        ]);
    });

});





Route::domain($mainDomain)->group(function () use ($descriptions, $blogCategory,  $leaflets_category, $leaflets_time, $retailers_category, $retailers_time, $leaflets, $retailers, $products, $vouchers) {

    Route::get('/gazetki-promocyjne', function () use ($descriptions, $leaflets_category, $leaflets_time, $leaflets, $products) {

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
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'products' => $products,
            ]);
    })->name('main.leaflets');

    Route::get('/gazetki-promocyjne/poznan', function () use ($descriptions, $leaflets_category, $leaflets_time, $leaflets, $products) {

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
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'products' => $products,
            ]);
    });

    Route::get('/sieci-handlowe', function () use ($descriptions, $retailers, $retailers_category, $retailers_time, $leaflets, $products) {

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
                'leaflets' => $leaflets,
                'retailers' => $retailers,
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'products' => $products,
            ]);
    })->name('main.retailers');

    Route::get('/sieci-handlowe/poznan', function () use ($descriptions, $retailers, $retailers_category, $retailers_time, $leaflets, $products){

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
                'leaflets' => $leaflets,
                'retailers' => $retailers,
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'products' => $products,
            ]);
    });

    Route::get('/kupony-rabatowe', function () use ($descriptions, $retailers_category, $retailers_time, $products, $vouchers) {

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
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'products' => $products,
                'vouchers' => $vouchers,
            ]);
    })->name('main.coupons');

    Route::get('/produkty', function () use ($descriptions, $retailers_category, $retailers_time, $products, $leaflets) {

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
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'products' => $products,
                'leaflets' => $leaflets,
            ]);
    })->name('main.products');

    Route::get('/produkty/{name}', function ($name) use ($descriptions, $products, $vouchers) {

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
                'breadcrumbs' => $breadcrumbs,
                'products' => $products,
                'vouchers' => $vouchers,
            ]);
    })->name('main.product');

    Route::get('/abc-zakupowicza', function () use ($descriptions, $blogCategory, $leaflets, $vouchers) {
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
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
            ]);
    })->name('main.blogs');

    Route::get('/abc-zakupowicza/porady', function () use ($descriptions, $blogCategory, $leaflets, $vouchers) {
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
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
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

    Route::get('/search/single/dropdown', function(Request $request) {

        $query = $request->input('query');
        $searchType = $request->input('searchType');

        $products = $retailers = $places = [];

        if ($searchType === 'products-retailers') {

            // Tablice przykładowych danych
            $products = [
                ['name' => 'bibuła', 'logo' => 'https://zakupy.biedronka.pl/dw/image/v2/BKFJ_PRD/on/demandware.static/-/Sites-PL_Master_Catalog/default/dw86fc0dc7/images/hi-res/359277.jpg'],
                ['name' => 'biwak', 'logo' => 'https://zakupy.biedronka.pl/dw/image/v2/BKFJ_PRD/on/demandware.static/-/Sites-PL_Master_Catalog/default/dw86fc0dc7/images/hi-res/359277.jpg'],
                ['name' => 'pączek', 'logo' => 'https://zakupy.biedronka.pl/dw/image/v2/BKFJ_PRD/on/demandware.static/-/Sites-PL_Master_Catalog/default/dw86fc0dc7/images/hi-res/359277.jpg'],
            ];

            $retailers = [
                ['name' => 'Biedronka', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Lidl', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_1.jpg'],
                ['name' => 'Netto', 'logo' => 'https://img.blix.pl/image/brand/009a4e69e0832285e5f754b1c2890f1e.jpeg'],
            ];

            // Filtrowanie danych w obu tablicach
            $products = array_filter($products, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false;
            });

            $retailers = array_filter($retailers, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false;
            });

        } elseif ($searchType === 'places') {
            $places = [
                ['name' => 'Poznań', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Piła', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wieleń', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wisła', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wieluń', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wieliczka', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wiktoria', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Warszawa', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
                ['name' => 'Wrocław', 'logo' => 'https://img.blix.pl/image/brand/thumbnail_23.jpg'],
            ];
            $places = array_filter($places, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false;
            });
        }
        // Zwrócenie wyników jako JSON z dwoma kategoriami
        return response()->json([
            'html' => view('components.search-results-dropdown', compact('products', 'retailers', 'places'))->render()
        ]);
    });

    Route::get('search/triple/swiper', function (Request $request) use ($leaflets) {
        $query = $request->input('query');
        if($query !== ''){
            $query = strtolower($query);
        }
        $searchType = $request->input('searchType');
        $category = $request->input('category');
        $time = $request->input('time');


        if ($searchType === 'leaflets') {
            // Filtrowanie według nazwy
            $leaflets = array_filter($leaflets, function ($item) use ($query) {
                return str_starts_with(strtolower($item['name']), strtolower($query)) !== false;
            });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $leaflets = array_filter($leaflets, function ($item) use ($category) {
                    return str_contains($item['category'], $category) !== false;
                });
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case 'ending': // Sortowanie po dacie zakończenia (end)
                        usort($leaflets, function ($a, $b) {
                            return $a['end'] <=> $b['end'];
                        });
                        break;

                    case 'last': // Sortowanie po dacie utworzenia (create)
                        usort($leaflets, function ($a, $b) {
                            return $a['create'] <=> $b['create'];
                        });
                        break;

                    case 'active': // Filtrowanie tylko aktywnych gazetek
                        $leaflets = array_filter($leaflets, function ($item) {
                            $today = date('Y-m-d');
                            return $item['start'] <= $today && $item['end'] >= $today;
                        });
                        break;
                }
            }

        }
        // Zwrócenie wyników jako JSON z widokiem
        return response()->json([
            'html' => view('components.search-results-swiper', compact('leaflets'))->render()
        ]);
    });

    Route::get('search/triple', function (Request $request) use ($leaflets, $retailers, $products, $vouchers) {
        $query = $request->input('query');
        if($query !== ''){
            $query = strtolower($query);
        }
        $searchType = $request->input('searchType');
        $category = $request->input('category');
        $time = $request->input('time');

        if ($searchType === 'leaflets') {

            // Filtrowanie według nazwy
            $leaflets = array_filter($leaflets, function ($item) use ($query) {
                return str_starts_with(strtolower($item['name']), strtolower($query)) !== false;
            });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $leaflets = array_filter($leaflets, function ($item) use ($category) {
                    return str_contains($item['category'], $category) !== false;
                });
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case 'ending': // Sortowanie po dacie zakończenia (end)
                        usort($leaflets, function ($a, $b) {
                            return $a['end'] <=> $b['end'];
                        });
                        break;

                    case 'last': // Sortowanie po dacie utworzenia (create)
                        usort($leaflets, function ($a, $b) {
                            return $a['create'] <=> $b['create'];
                        });
                        break;

                    case 'active': // Filtrowanie tylko aktywnych gazetek
                        $leaflets = array_filter($leaflets, function ($item) {
                            $today = date('Y-m-d');
                            return $item['start'] <= $today && $item['end'] >= $today;
                        });
                        break;
                }
            }
            $retailers = [];
            $products = [];
            $vouchers = [];
        } elseif ($searchType === 'retailers') {
            $retailers = array_filter($retailers, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false;
            });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $retailers = array_filter($retailers, function ($item) use ($category) {
                    return str_contains($item['category'], $category) !== false;
                });
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case 'ending': // Sortowanie po dacie zakończenia (end)
                        usort($retailers, function ($a, $b) {
                            return $a['end'] <=> $b['end'];
                        });
                        break;

                    case 'last': // Sortowanie po dacie utworzenia (create)
                        usort($retailers, function ($a, $b) {
                            return $a['create'] <=> $b['create'];
                        });
                        break;

                    case 'active': // Filtrowanie tylko aktywnych gazetek
                        $retailers = array_filter($retailers, function ($item) {
                            $today = date('Y-m-d');
                            return $item['start'] <= $today && $item['end'] >= $today;
                        });
                        break;
                }
            }

            $leaflets = [];
            $products = [];
            $vouchers = [];

        } elseif ($searchType === 'products'){

            $products = array_filter($products, function ($item) use ($query) {
                return stripos($item['name'], $query) !== false;
            });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $products = array_filter($products, function ($item) use ($category) {
                    return str_contains($item['category'], $category) !== false;
                });
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case 'ending': // Sortowanie po dacie zakończenia (end)
                        usort($products, function ($a, $b) {
                            return $a['end'] <=> $b['end'];
                        });
                        break;

                    case 'last': // Sortowanie po dacie utworzenia (create)
                        usort($products, function ($a, $b) {
                            return $a['create'] <=> $b['create'];
                        });
                        break;

                    case 'active': // Filtrowanie tylko aktywnych gazetek
                        $products = array_filter($products, function ($item) {
                            $today = date('Y-m-d');
                            return $item['start'] <= $today && $item['end'] >= $today;
                        });
                        break;
                }
            }


            $retailers = [];
            $leaflets = [];
            $vouchers = [];
        } elseif ($searchType === 'vouchers') {

            // Filtrowanie według nazwy
            $vouchers = array_filter($vouchers, function ($item) use ($query) {
                return str_starts_with(strtolower($item['name']), strtolower($query)) !== false;
            });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $vouchers = array_filter($vouchers, function ($item) use ($category) {
                    return str_contains($item['category'], $category) !== false;
                });
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case 'ending': // Sortowanie po dacie zakończenia (end)
                        usort($vouchers, function ($a, $b) {
                            return $a['end'] <=> $b['end'];
                        });
                        break;

                    case 'last': // Sortowanie po dacie utworzenia (create)
                        usort($vouchers, function ($a, $b) {
                            return $a['create'] <=> $b['create'];
                        });
                        break;

                    case 'active': // Filtrowanie tylko aktywnych gazetek
                        $vouchers = array_filter($vouchers, function ($item) {
                            $today = date('Y-m-d');
                            return $item['start'] <= $today && $item['end'] >= $today;
                        });
                        break;
                }
            }
            $retailers = [];
            $leaflets = [];
            $products = [];
        }

        // Zwrócenie wyników jako JSON z widokiem
        return response()->json([
            'html' => view('components.search-results-container', compact('leaflets', 'retailers', 'products', 'vouchers'))->render()
        ]);
    });



    Route::get('/', function () use ($descriptions, $leaflets_category, $leaflets_time, $leaflets, $products, $vouchers) {

        $breadcrumbs = [];

        return view('main.index', data:
            [
                'data' => '',
                'image' => '',
                'slug' => 'Warszawa',
                'h1Title'=> 'Wszystkie gazetki promocyjne <strong>w jednym miejscu</strong>',
                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'products' => $products,
                'vouchers' => $vouchers,
            ]);
    })->name('main.index');

    Route::get('/poznan', function () use ($descriptions, $leaflets_category, $leaflets_time, $leaflets, $products, $vouchers) {

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
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'leaflets_category' => $leaflets_category,
                'leaflets_time' => $leaflets_time,
                'products' => $products,
                'vouchers' => $vouchers,
            ]);
    });

    Route::get('/{slug}', function ($slug) use ($descriptions, $products) {

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
                'breadcrumbs' => $breadcrumbs,
                'products' => $products,
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
