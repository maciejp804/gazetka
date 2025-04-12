<?php

use App\Http\Controllers\Admin\ProductDescriptionController;
use App\Http\Controllers\BackController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LeafletController;
use App\Http\Controllers\LeafletCoverController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VoucherController as AdminVoucherController;
use App\Http\Controllers\Admin\VoucherStoreController as AdminVoucherStoreController;
use App\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Http\Controllers\Admin\LeafletController as AdminLeafletController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductDescriptionController as AdminProductDescriptionController ;
use App\Http\Controllers\Admin\PageController as AdminPageController; ;
use App\Http\Controllers\Admin\PageClickController as AdminPageClickController;


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

Route::get('new', function ()
{
    \Illuminate\Support\Facades\Mail::to('biuro@hoian.pl')->send(
        new \App\Mail\ContactMail()
    );
    return 'Done';
});



//START SEARCH
Route::get('/search/single/dropdown',[SearchController::class,'single'])->name('search.single');
Route::get('/search/triple/swiper',[SearchController::class,'tripleSwiper'])->name('search.triple.swiper');
Route::get('/search/triple/',[SearchController::class,'triple'])->name('search.triple');
Route::get('search/quadruple',[SearchController::class,'quadruple'])->name('search.quadruple');
//END SEARCH

//VOUCHER

Route::get('/panel/vouchers', [AdminVoucherController::class, 'index'])->name('admin.vouchers.index');
Route::get('/panel/vouchers/create', [AdminVoucherController::class, 'create'])->name('admin.vouchers.create');
Route::post('/panel/vouchers/add', [AdminVoucherController::class, 'add'])->name('admin.vouchers.add');
Route::delete('/panel/vouchers/{voucher}/delete', [AdminVoucherController::class, 'destroy'])->name('admin.vouchers.destroy');
Route::get('/panel/vouchers/{voucher}/edit', [AdminVoucherController::class, 'edit'])->name('admin.vouchers.edit');
Route::put('/panel/vouchers/{voucher}/update', [AdminVoucherController::class, 'update'])->name('admin.vouchers.update');
Route::post('/panel/vouchers/{voucher}/upload-image', [AdminVoucherController::class, 'uploadImage'])->name('admin.vouchers.upload.image');
Route::post('panel/vouchers/{voucher}/upload-logo', [AdminVoucherController::class, 'uploadLogo'])->name('admin.vouchers.upload.logo');
Route::get('voucher/update/tradedoubler',[AdminVoucherController::class,'updateVouchersTradedoubler'])->name('admin.vouchers.update.tradedoubler');
Route::get('voucher/update/tradetracker',[AdminVoucherController::class,'updateVouchersTradetracker'])->name('admin.vouchers.update.tradetracker');


Route::get('/panel/vouchers/store/create', [AdminVoucherStoreController::class,'create'])->name('admin.vouchers.store.create');
Route::post('/panel/vouchers/store/add', [AdminVoucherStoreController::class,'add'])->name('admin.vouchers.store.add');
Route::post('/panel/vouchers/store/{store}/edit', [AdminVoucherStoreController::class,'edit'])->name('admin.vouchers.store.edit');
Route::post('/panel/vouchers/store/{store}/update', [AdminVoucherStoreController::class,'update'])->name('admin.vouchers.store.update');
Route::get('voucher/store/update/tradedoubler',[AdminVoucherStoreController::class,'updateTradedoubler'])->name('admin.vouchers.stores.update.tradedoubler');
Route::get('voucher/store/update/tradetracker',[AdminVoucherStoreController::class,'updateTradetracker'])->name('admin.vouchers.stores.update.tradetracker');

//SHOPS
Route::get('/panel/shops', [AdminShopController::class, 'index'])->name('admin.shops.index');
Route::get('/panel/shops/create', [AdminShopController::class, 'create'])->name('admin.shops.create');
Route::post('/panel/shops/add', [AdminShopController::class, 'add'])->name('admin.shops.add');
Route::delete('/panel/shops/{shop}/delete', [AdminShopController::class, 'destroy'])->name('admin.shops.destroy');
Route::get('/panel/shops/{shop}/edit', [AdminShopController::class, 'edit'])->name('admin.shops.edit');
Route::put('/panel/shops/{shop}/update', [AdminShopController::class, 'update'])->name('admin.shops.update');

//LEAFLETS
Route::prefix('/panel/leaflets')->name('admin.leaflets.')->group(function () {
    Route::get('/', [AdminLeafletController::class, 'index'])->name('index');
    Route::get('/create', [AdminLeafletController::class, 'create'])->name('create');
    Route::post('/add', [AdminLeafletController::class, 'add'])->name('add');
    Route::get('/search', [AdminLeafletController::class, 'search'])->name('search');
    Route::get('/{leaflet}', [AdminLeafletController::class, 'manage'])->name('manage');
    Route::delete('/{leaflet}/delete', [AdminLeafletController::class, 'destroy'])->name('destroy');
    Route::get('/{leaflet}/edit', [AdminLeafletController::class, 'edit'])->name('edit');
    Route::put('/{leaflet}/update', [AdminLeafletController::class, 'update'])->name('update');
    Route::get('/{leaflet}/pages', [AdminPageController::class, 'manage'])->name('page.manage');
    Route::get('/{leaflet}/pages/create', [AdminPageController::class, 'create'])->name('page.create');
    Route::put('/{leaflet}/pages/add', [AdminPageController::class, 'add'])->name('page.add');
    Route::get('/{leaflet}/pages/edit', [AdminPageController::class, 'edit'])->name('page.edit');
    Route::put('/{leaflet}/pages/update', [AdminPageController::class, 'update'])->name('page.update');
    Route::get('/{leaflet}/pages/order', [AdminPageController::class, 'editOrder'])->name('page.edit.order');
    Route::put('/{leaflet}/pages/updateOrder', [AdminPageController::class, 'updateOrder'])->name('page.update.order');
    Route::get('/{leaflet}/pages/products/create', [AdminPageClickController::class, 'create'])->name('page.product.create');
    Route::post('/{leaflet}/pages/products/add', [AdminPageClickController::class, 'add'])->name('page.product.add');
    Route::delete('/{leaflet}/{pageClick}/delete', [AdminPageClickController::class, 'destroy'])->name('page.product.destroy');


});

//PRODUCTS
Route::prefix('panel/products')->name('admin.products.')->group(function () {
    Route::get('/', [AdminProductController::class, 'index'])->name('index');
    Route::get('/search', [AdminProductController::class, 'search'])->name('search'); //Wyszukiwarka produktów
    Route::get('/{product:slug}', [AdminProductController::class, 'manage'])->name('manage');
    Route::post('/{product}/upload-image', [AdminProductController::class, 'uploadImage'])->name('upload.image'); //Dodawanie, zmiana grafiki

    // DESCRIPTION
    Route::prefix('/{product:slug}/description')->name('description.')->group(function () {
        Route::get('/edit', [AdminProductDescriptionController::class, 'edit'])->name('edit'); //Edit - Dane podstawowe
        Route::put('/update', [AdminProductDescriptionController::class, 'update'])->name('update');
        Route::get('/faq/edit', [AdminProductDescriptionController::class, 'editFaq'])->name('faq.edit'); //Edit - FAQ
        Route::put('/faq/update', [AdminProductDescriptionController::class, 'updateFaq'])->name('faq.update');
        Route::get('/excerpt/edit', [AdminProductDescriptionController::class, 'editExcerpt'])->name('excerpt.edit'); //Edit - Excerpt
        Route::put('/excerpt/update', [AdminProductDescriptionController::class, 'updateExcerpt'])->name('excerpt.update');
        Route::get('/parameters/edit', [AdminProductDescriptionController::class, 'editParameters'])->name('parameters.edit'); //Edit - Parametry
        Route::put('/parameters/update', [AdminProductDescriptionController::class, 'updateParameters'])->name('parameters.update');
        Route::get('/content/edit', [AdminProductDescriptionController::class, 'editContent'])->name('content.edit'); //Edit - Główny opis
        Route::put('/content/update', [AdminProductDescriptionController::class, 'updateContent'])->name('content.update');
        Route::put('/image/{index}', [AdminProductDescriptionController::class, 'updateContentImage']) // Dodawanie, edycja zdjęcia w wpisie głownym
            ->name('content.update.image');

        // SHOP DESCRIPTION
        Route::prefix('/shop')->name('shop.')->group(function () {
            Route::get('/{shop:slug}/edit', [AdminProductDescriptionController::class, 'editShop'])->name('editShop');
            Route::put('/{shop}/update', [AdminProductDescriptionController::class, 'updateShop'])->name('updateShop');
            Route::get('/{shop:slug}/faq/edit', [AdminProductDescriptionController::class, 'editShopFaq'])->name('editShopFaq');
            Route::put('/{shop}/faq/update', [AdminProductDescriptionController::class, 'updateShopFaq'])->name('updateShopFaq');
            Route::get('/{shop:slug}/create', [AdminProductDescriptionController::class, 'createShop'])->name('createShop');
            Route::get('/{shop}/add', [AdminProductDescriptionController::class, 'addShop'])->name('addShop');
            Route::get('/{shop:slug}', [AdminProductDescriptionController::class, 'manageShop'])->name('manageShop');

            Route::get('/', [AdminProductDescriptionController::class, 'indexShop'])->name('indexShop');
        });
    });


});




//Route::get('panel/shops/{shop}', [BackController::class, 'clickableIndex']);
Route::get('panel', [Backcontroller::class, 'index'])->name('admin.index');


Route::get('tchibo',[SearchController::class,'tchibo'])->name('search.tchibo');

Route::domain('{subdomain}.'.$mainDomain)->group(function () use ($pages, $ads, $inserts, $insertData, $leaflets_category, $leaflets_time, $leaflets, $vouchers, $retailers, $products, $mainDomain) {

    Route::get('/w-gazetce/{slug}', [ProductController::class, 'showSubdomain'])
        ->name('subdomain.products.show');

    Route::get('/gazetka-promocyjna/{id}', function ($subdomain, $id) use ($pages, $inserts, $insertData, $ads, $leaflets) {
       return app(LeafletController::class)->subdomainLeaflet($subdomain, $id,  $insertData);
    })->name('subdomain.leaflet');

    Route::get('/{community}/{address}' ,function ($subdomain, $community, $address) {
        return app(ShopController::class)->subdomainShowAddress($subdomain, $community, $address);
    })->name('subdomain.shop_address');

    Route::get('/{community}', function ($subdomain, $community) use ($leaflets) {
        return app(MainController::class)->subdomainIndexGps($subdomain, $community, $leaflets);
    })->name('subdomain.index_gps');

    Route::get('/', function ($subdomain) {
        return app(MainController::class)->subdomainIndex($subdomain);
    })->name('subdomain.index');

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

    //    Route::get('/kupony-rabatowe',[ShopController::class,'indexGps'])->name('main.retailers.gps');

    Route::get('/kupony-rabatowe', function () use ($descriptions) {
      return app(VoucherController::class)->index($descriptions);
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

    //Blogs

    // Route::get('/abc-zakupowicza/{category}/{article}',[BlogController::class, 'show'])->name('main.blogs.article');

    Route::get('/abc-zakupowicza/{category}/{article}', function ($category, $article) use ($descriptions) {
        return app(BlogController::class)->show($category, $article, $descriptions);
    })->name('main.blogs.article');

    // Route::get('/abc-zakupowicza/{category}',[BlogController::class, 'indexCategory'])->name('main.blogs.category');

    Route::get('/abc-zakupowicza/{category}', function ($category) use ($descriptions) {
        return app(BlogController::class)->indexCategory($category, $descriptions);
    })->name('main.blogs.category');

   // Route::get('/abc-zakupowicza',[BlogController::class, 'index'])->name('main.blogs');

    Route::get('/abc-zakupowicza', function () use ($descriptions, $blogCategory) {
        return app(BlogController::class)->index($descriptions, $blogCategory);
    })->name('main.blogs');




    // Route::get('/lokalizacje', [PlaceController::class, 'index'])->name('main.map');

    Route::get('/lokalizacje/{category}', function ($category) use ($descriptions, $leaflets, $mainDomain){
        return app(PlaceController::class)->indexVoivodeship($category, $descriptions, $leaflets, $mainDomain);
    })->name('main.maps.voivodeship');


//    Route::get('/lokalizacje', [PlaceController::class, 'index'])->name('main.map');

    Route::get('lokalizacje', function () use ($descriptions, $leaflets, $mainDomain) {
        return app(PlaceController::class)->index($descriptions, $leaflets, $mainDomain);
    })->name('main.maps');

    Route::get('/onas', [MainController::class, 'about'])->name('main.about');

    Route::get('/polityka-prywatnosci', [MainController::class, 'privacy'])->name('main.privacy');

    Route::get('/polityka-cookies', [MainController::class, 'cookies'])->name('main.cookies');

    Route::get('/regulamin', [MainController::class, 'statute'])->name('main.statute');

    Route::get('/kontakt',[ContactController::class,'index'])->name('main.contact');

    Route::post('/send-contact',[ContactController::class,'send'])->name('main.contact.send');


    Route::post('/ratings', [RatingController::class, 'store'])->middleware('auth')->name('ratings.store');

    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

    Route::get('/convert', [LeafletCoverController::class, 'storePage']);

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



Route::get('tchibo',[SearchController::class,'tchibo'])->name('search.tchibo');






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
