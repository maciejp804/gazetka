<?php

use App\Http\Controllers\BackController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LeafletController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\VoucherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$mainDomain = env('MAIN_DOMAIN', 'gazetkapromocyjna.local');

$leaflets = [
    ['name' => 'Biedronka', 'category' => 'dom', 'create' => '2024-12-18 10:00:00', 'start' => '2024-12-24',  'end' => '2024-12-31', 'logo' => 'https://biedronka.gazetkapromocyjna.com.pl/1907/1.jpg'],
    ['name' => 'Delikatesy Centrum', 'category' => 'dom', 'create' => '2024-11-07', 'start' => '2024-11-15',  'end' => '2024-12-18 15:00:00', 'logo' => 'https://delikatesy-centrum.gazetkapromocyjna.com.pl/613/1.jpg'],
    ['name' => 'Biedronka', 'category' => 'dom', 'create' => '2024-11-08', 'start' => '2024-11-11',  'end' => '2024-11-30', 'logo' => 'https://biedronka.gazetkapromocyjna.com.pl/1906/1.jpg'],
    ['name' => 'Biedronka', 'category' => 'dom', 'create' => '2024-11-06', 'start' => '2024-11-10',  'end' => '2024-11-25', 'logo' => 'https://biedronka.gazetkapromocyjna.com.pl/1905/1.jpg'],
    ['name' => 'Delikatesy Centrum', 'category' => 'zbawki', 'create' => '2024-11-05', 'start' => '2024-11-28',  'end' => '2024-12-31', 'logo' => 'https://delikatesy-centrum.gazetkapromocyjna.com.pl/616/1.jpg'],
    ['name' => 'Dino', 'category' => 'zabawki', 'create' => '2024-10-08', 'start' => '2024-10-15',  'end' => '2024-11-09', 'logo' => 'https://biedronka.gazetkapromocyjna.com.pl/1904/1.jpg'],
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
    ['img' => 'assets/images/statics/1.png',
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

    ['img' => 'assets/images/statics/2.png',
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
    ['img' => 'assets/images/statics/3.png',
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
    ['img' => 'assets/images/statics/4.png',
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

$ads = [13];
$inserts = [5,9];
$insertData = [
    ['after' => 5,'img' => 'https://placehold.co/449x750/gray/white?text=AD1+449+x+750', 'clicks' => [
        ['url' => 'http://example1.com', 'x' => 50, 'y' => 10, 'width' => 270, 'height' => 580],
        ['url' => 'http://example1.com', 'x' => 200, 'y' => 400, 'width' => 50, 'height' => 50]

    ]],
    ['after' => 9,'img' => 'https://placehold.co/300x600/gray/white?text=AD1+300+x+600', 'clicks' => [
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



Route::domain('{subdomain}.'.$mainDomain)->group(function () use ($pages, $ads, $inserts, $insertData, $leaflets_category, $leaflets_time, $leaflets, $vouchers, $retailers, $products, $mainDomain) {





    Route::get('/w-gazetce/{slug}' ,function ($subdomain, $slug) use ($leaflets) {
        return app(ProductController::class)->showSubdomain($subdomain, $slug, $leaflets);
    })->name('subdomain.products.show');


    Route::get('/gazetka-promocyjna/{id}', function ($subdomain, $id) use ($pages, $inserts, $insertData, $ads, $leaflets) {
       return app(LeafletController::class)->subdomainLeaflet($subdomain, $id,  $insertData);
    })->name('subdomain.leaflet');

    Route::get('/{community}/{address}' ,function ($subdomain, $community, $address) use ($leaflets) {
        return app(ShopController::class)->subdomainShowAddress($subdomain, $community, $address, $leaflets);
    })->name('subdomain.shop_address');

    Route::get('/{community}', function ($subdomain, $community) use ($leaflets) {
        return app(MainController::class)->subdomainIndexGps($subdomain, $community, $leaflets);
    })->name('subdomain.index_gps');

    Route::get('/', function ($subdomain) use ($leaflets) {
        return app(MainController::class)->subdomainIndex($subdomain, $leaflets);
    })->name('subdomain.index');





    // Route::get('/search/single/dropdown',[SearchController::class,'single'])->name('search.single');

    Route::get('/search/single/dropdown', function(Request $request) {
        return app(SearchController::class)->single($request);
    })->name('search.single');

    Route::get('search/triple/swiper', function(Request $request) use ($leaflets) {
        return app(SearchController::class)->tripleSwiper($request, $leaflets);
    })->name('search.triple');

    Route::get('search/triple', function(Request $request) use ($leaflets, $retailers, $products, $vouchers) {
        return app(SearchController::class)->triple($request, $leaflets, $retailers, $products, $vouchers);
    });

});





Route::domain($mainDomain)->group(function () use ($descriptions, $blogCategory,  $leaflets_category, $leaflets_time, $retailers_category, $retailers_time, $leaflets, $retailers, $products, $vouchers, $mainDomain) {

    //    Route::get('/gazetki-promocyjne',[LeafletController::class,'index'])->name('main.leaflets');

    Route::get('/gazetki-promocyjne', function () use ($descriptions) {
        return app(LeafletController::class)->index($descriptions);
    })->name('main.leaflets');

    //    Route::get('/gazetki-promocyjne/{community}',[LeafletController::class,'indexGps'])->name('main.leaflets.gps');

    Route::get('/gazetki-promocyjne/{category}', function ($category) use ($descriptions) {
        return app(LeafletController::class)->indexCategory($category, $descriptions);
    })->name('main.leaflets.category');

    //    Route::get('/sieci-handlowe',[ShopController::class,'index'])->name('main.retailers');

    Route::get('/sieci-handlowe', function () use ($descriptions) {
        return app(ShopController::class)->index($descriptions);
    })->name('main.retailers');

    Route::get('/sieci-handlowe/{category}', function ($category) use ($descriptions) {
        return app(ShopController::class)->indexCategory($category, $descriptions);
    })->name('main.retailers.category');

    //    Route::get('/sieci-handlowe/{community}',[ShopController::class,'indexGps'])->name('main.retailers.gps');

    Route::get('/sieci-handlowe/{community}', function ($community) use ($descriptions, $retailers, $retailers_category, $retailers_time, $leaflets, $products) {
        return app(ShopController::class)->indexGps($community, $descriptions, $retailers, $retailers_category, $retailers_time, $leaflets, $products);
    })->name('main.retailers.gps');


    //    Route::get('/kupony-rabatowe',[ShopController::class,'indexGps'])->name('main.retailers.gps');

    Route::get('/kupony-rabatowe', function () use ($descriptions, $retailers_category, $retailers_time, $products) {
      return app(VoucherController::class)->index($descriptions, $retailers_category, $retailers_time, $products);
    })->name('main.vouchers');

    Route::get('/kupony-rabatowe/{category}', function ($category) use ($descriptions, $retailers_category, $retailers_time, $products) {
        return app(VoucherController::class)->indexCategory($category, $descriptions, $retailers_category, $retailers_time, $products);
    })->name('main.vouchers.category');

    //    Route::get('/produkty/{category}',[ProductController::class,'indexCategory'])->name('main.products.category');

    Route::get('/produkty/{category}', function ($category) use ( $descriptions) {
        return app(ProductController::class)->indexCategory($category, $descriptions);
    })->name('main.products.category');


    //    Route::get('/produkty/{category}/{subcategory}',[ProductController::class,'indexCategory'])->name('main.products.category');

    Route::get('/produkty/{category}/{subcategory}', function ($category, $subcategory) use ( $descriptions) {
        return app(ProductController::class)->indexSubCategory($category, $subcategory, $descriptions);
    })->name('main.products.subcategory');


//    Route::get('/produkty',[ProductController::class,'index'])->name('main.products');

    Route::get('/produkty', function () use ($descriptions) {
        return app(ProductController::class)->index($descriptions);
    })->name('main.products');

    //    Route::get('/produkt/{slug}',[ProductController::class,'show'])->name('main.product');

    Route::get('/produkt/{slug}', function ($slug) use  ($descriptions, $vouchers) {
        return app(ProductController::class)->show($slug, $descriptions);
    })->name('main.product');


   // Route::get('/abc-zakupowicza',[BlogController::class, 'index'])->name('main.blogs');

    Route::get('/abc-zakupowicza', function () use ($descriptions, $blogCategory, $leaflets) {
        return app(BlogController::class)->index($descriptions, $blogCategory, $leaflets);
    })->name('main.blogs');


    // Route::get('/abc-zakupowicza/{category}',[BlogController::class, 'indexCategory'])->name('main.blogs_category');

    Route::get('/abc-zakupowicza/{category}', function ($category) use ($descriptions, $blogCategory, $leaflets) {
        return app(BlogController::class)->indexCategory($category, $descriptions, $blogCategory, $leaflets);
    })->name('main.blogs_category');

    // Route::get('/abc-zakupowicza/{category}/{article}',[BlogController::class, 'show'])->name('main.blogs_article');
    Route::get('/abc-zakupowicza/{category}/{article}', function ($category, $article) use ($descriptions, $blogCategory) {
        return app(BlogController::class)->show($category, $article, $descriptions, $blogCategory);
    })->name('main.blogs_article');

    // Route::get('/lokalizacje', [PlaceController::class, 'index'])->name('main.map');

    Route::get('/lokalizacje/{category}', function ($category) use ($descriptions, $leaflets, $mainDomain){
        return app(PlaceController::class)->indexVoivodeship($category, $descriptions, $leaflets, $mainDomain);
    })->name('main.maps.voivodeship');


//    Route::get('/lokalizacje', [PlaceController::class, 'index'])->name('main.map');

    Route::get('lokalizacje', function () use ($descriptions, $leaflets, $mainDomain) {
        return app(PlaceController::class)->index($descriptions, $leaflets, $mainDomain);
    })->name('main.maps');


    Route::post('/ratings', [RatingController::class, 'store'])->middleware('auth')->name('ratings.store');

    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

    // Route::get('/search/single/dropdown',[SearchController::class,'single'])->name('search.single');

    Route::get('/search/single/dropdown', function(Request $request) {
        return app(SearchController::class)->single($request);
    })->name('search.single');

    Route::get('search/triple/swiper', function(Request $request) use ($leaflets) {
        return app(SearchController::class)->tripleSwiper($request, $leaflets);
    })->name('search.triple');

    Route::get('search/triple', function(Request $request) use ($leaflets, $retailers, $products, $vouchers) {
        return app(SearchController::class)->triple($request, $leaflets, $retailers, $products, $vouchers);
    });

    Route::get('search/quadruple', function(Request $request) use ($leaflets, $retailers, $products, $vouchers) {
        return app(SearchController::class)->quadruple($request, $leaflets, $retailers, $products, $vouchers);
    });


    Route::get('/test-test/{week}/{number}/{start}', [SearchController::class, 'test']);

    Route::get('/combination', [SearchController::class, 'combination'])
        ->middleware('auth')
        ->name('combination');



    require __DIR__.'/auth.php';

   // Route::get('/{community}',[MainController::class,'indexGps'])->name('main.index.gps');

    Route::get('/{community}', function ($community) use ($descriptions) {
        return app(MainController::class)->indexGps($community, $descriptions);
    })->name('main.index.gps');

    // Route::get('/',[MainController::class,'index'])->name('main.index');

    Route::get('/', function () use ($descriptions) {
        return app(MainController::class)->index($descriptions);
    })->name('main.index');

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



require __DIR__.'/api.php';
