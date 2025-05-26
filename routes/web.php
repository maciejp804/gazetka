<?php


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
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\VoucherController;
use App\Http\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VoucherController as AdminVoucherController;
use App\Http\Controllers\Admin\VoucherStoreController as AdminVoucherStoreController;
use App\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Http\Controllers\Admin\LeafletController as AdminLeafletController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductDescriptionController as AdminProductDescriptionController ;
use App\Http\Controllers\Admin\PageController as AdminPageController; ;
use App\Http\Controllers\Admin\HotSpotController as AdminHotSpotController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\DescriptionController as AdminDescriptionController;

Route::get('/robots.txt', function () {
    $host       = request()->getHost();
    $main       = 'gazetkapromocyjna.com.pl';
    $isMain     = $host === $main || $host === "www.$main";
    $sitemap    = $isMain
        ? secure_url('/sitemaps/sitemap-main.xml')
        : secure_url('/sitemaps/sitemap-'.explode('.', $host)[0].'.xml');

    $body = App::environment('production')
        ? "User-agent: *\nDisallow:\n\nSitemap: $sitemap"
        : "User-agent: *\nDisallow: /\n\nSitemap: $sitemap";

    return response($body, 200)
        ->header('Content-Type', 'text/plain')
        ->withoutCookies();                     // Laravel 11 helper
})->withoutMiddleware([
    StartSession::class,
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
]);

$mainDomain = config('app.main_domain');

//START SEARCH
Route::get('/search/single/dropdown',[SearchController::class,'single'])->name('search.single');
Route::get('/search/triple/swiper',[SearchController::class,'tripleSwiper'])->name('search.triple.swiper');
Route::get('/search/triple/',[SearchController::class,'triple'])->name('search.triple');
Route::get('search/quadruple',[SearchController::class,'quadruple'])->name('search.quadruple');
//END SEARCH


Route::get('/cron/aldi/{week}/{number}/{start}/{letter}', [SearchController::class, 'aldiCron'])->name('cron.aldi');


//ZAPLECZE
Route::prefix('/panel')->name('admin.')->group(function () {
    //VOUCHER
    Route::get('/vouchers', [AdminVoucherController::class, 'index'])->name('vouchers.index');
    Route::get('/vouchers/create', [AdminVoucherController::class, 'create'])->name('vouchers.create');
    Route::post('/vouchers/add', [AdminVoucherController::class, 'add'])->name('vouchers.add');
    Route::delete('/vouchers/{voucher}/delete', [AdminVoucherController::class, 'destroy'])->name('vouchers.destroy');
    Route::get('/vouchers/{voucher}/edit', [AdminVoucherController::class, 'edit'])->name('vouchers.edit');
    Route::put('/vouchers/{voucher}/update', [AdminVoucherController::class, 'update'])->name('vouchers.update');
    Route::post('/vouchers/{voucher}/upload-image', [AdminVoucherController::class, 'uploadImage'])->name('vouchers.upload.image');
    Route::post('/vouchers/{voucher}/upload-logo', [AdminVoucherController::class, 'uploadLogo'])->name('vouchers.upload.logo');
    Route::get('/vouchers/update/tradedoubler',[AdminVoucherController::class,'updateVouchersTradedoubler'])->name('vouchers.update.tradedoubler');
    Route::get('/vouchers/update/tradetracker',[AdminVoucherController::class,'updateVouchersTradetracker'])->name('vouchers.update.tradetracker');


    Route::get('/vouchers/store/create', [AdminVoucherStoreController::class,'create'])->name('vouchers.store.create');
    Route::post('/vouchers/store/add', [AdminVoucherStoreController::class,'add'])->name('vouchers.store.add');
    Route::post('/vouchers/store/{store}/edit', [AdminVoucherStoreController::class,'edit'])->name('vouchers.store.edit');
    Route::post('/vouchers/store/{store}/update', [AdminVoucherStoreController::class,'update'])->name('vouchers.store.update');
    Route::get('/vouchers/store/update/tradedoubler',[AdminVoucherStoreController::class,'updateTradedoubler'])->name('vouchers.stores.update.tradedoubler');
    Route::get('/vouchers/store/update/tradetracker',[AdminVoucherStoreController::class,'updateTradetracker'])->name('vouchers.stores.update.tradetracker');

//SHOPS
    Route::prefix('/shops')->name('shops.')->group(function () {
        Route::get('/', [AdminShopController::class, 'index'])->name('index');
        Route::get('/create', [AdminShopController::class, 'create'])->name('create');
        Route::post('/add', [AdminShopController::class, 'add'])->name('add');
        Route::prefix('/{shop:slug}/description')->name('description.')->group(function () {
            Route::get('/faq/edit', [AdminDescriptionController::class, 'editFaq'])->name('faq.edit'); //Edit - FAQ
            Route::put('/faq/update', [AdminDescriptionController::class, 'updateFaq'])->name('faq.update');
            Route::get('/content/edit', [AdminDescriptionController::class, 'editContent'])->name('content.edit'); //Edit - Główny opis
            Route::put('/content/update', [AdminDescriptionController::class, 'updateContent'])->name('content.update');
            Route::put('/image/{index}', [AdminDescriptionController::class, 'updateContentImage']) // Dodawanie, edycja zdjęcia we wpisie głownym
            ->name('content.update.image');
        });
        Route::get('/{shop:slug}', [AdminShopController::class, 'manage'])->name('manage');
        Route::delete('/{shop:slug}/delete', [AdminShopController::class, 'destroy'])->name('destroy');
        Route::get('/{shop:slug}/edit', [AdminShopController::class, 'edit'])->name('edit');
        Route::put('/{shop:slug}/update', [AdminShopController::class, 'update'])->name('update');
    });


//LEAFLETS
    Route::prefix('/leaflets')->name('leaflets.')->group(function () {
        Route::get('/', [AdminLeafletController::class, 'index'])->name('index');
        Route::get('/create', [AdminLeafletController::class, 'create'])->name('create');
        Route::post('/add', [AdminLeafletController::class, 'add'])->name('add');
        Route::get('/search', [AdminLeafletController::class, 'search'])->name('search');
        Route::post('/hotspot/create', [AdminHotSpotController::class, 'createHotSpot'])->name('hotspot.create');
        Route::put('/hotspot/update', [AdminHotSpotController::class, 'updateHotSpot'])->name('hotspot.update');
        Route::get('/{leaflet}', [AdminLeafletController::class, 'manage'])->name('manage');
        Route::post('/{leaflet}/upload-image', [AdminLeafletController::class, 'uploadImage'])->name('upload.image'); //Dodawanie, zmiana grafiki
        Route::delete('/{leaflet}/delete', [AdminLeafletController::class, 'destroy'])->name('destroy');
        Route::get('/{leaflet}/edit', [AdminLeafletController::class, 'edit'])->name('edit');
        Route::put('/{leaflet}/update', [AdminLeafletController::class, 'update'])->name('update');
        Route::get('/{leaflet}/pages', [AdminPageController::class, 'manage'])->name('page.manage');
        Route::get('/{leaflet}/pages/create', [AdminPageController::class, 'create'])->name('page.create');
        Route::put('/{leaflet}/pages/add', [AdminPageController::class, 'add'])->name('page.add');
        Route::get('/{leaflet}/pages/create-api', [AdminPageController::class, 'createApi'])->name('page.create.api');
        Route::post('/{leaflet}/pages/add-api', [AdminPageController::class, 'addApi'])->name('page.add.api');
        Route::get('/{leaflet}/pages/edit', [AdminPageController::class, 'edit'])->name('page.edit');
        Route::put('/{leaflet}/pages/update', [AdminPageController::class, 'update'])->name('page.update');
        Route::get('/{leaflet}/pages/import', [AdminPageController::class, 'import'])->name('page.import');
        Route::get('/{leaflet}/pages/order', [AdminPageController::class, 'editOrder'])->name('page.edit.order');
        Route::put('/{leaflet}/pages/updateOrder', [AdminPageController::class, 'updateOrder'])->name('page.update.order');

        Route::prefix('{leaflet}/hotspots')->name('hotspots.')->group(function () {
            Route::get('/create', [AdminHotSpotController::class, 'create'])->name('create');
            Route::post('/add', [AdminHotSpotController::class, 'add'])->name('add');
            Route::post('/import', [AdminHotSpotController::class, 'import'])->name('import');
            Route::get('/export', [AdminHotSpotController::class, 'export'])->name('export');
            Route::delete('/delete', [AdminHotSpotController::class, 'delete'])->name('delete');
            Route::delete('/{page}/deletePage', [AdminHotSpotController::class, 'deletePage'])->name('deletePage');
            Route::delete('/{hotSpot}/deleteSpot', [AdminHotSpotController::class, 'deleteHotSpot'])->name('deleteHotSpot');
        });
    });

//PRODUCTS
    Route::prefix('products')->name('products.')->group(function () {
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

//BLOG
    Route::prefix('/blogs')->name('blogs.')->group(function () {
        Route::get('/', [AdminBlogController::class, 'index'])->name('index');
        Route::get('/create', [AdminBlogController::class, 'create'])->name('create');
        Route::post('/add', [AdminBlogController::class, 'add'])->name('add');
        Route::post('/tiny/upload-image', [AdminBlogController::class, 'uploadImageTiny'])->name('upload.image.tiny');
        Route::get('/{slug:blog}/edit', [AdminBlogController::class, 'edit'])->name('edit');
        Route::put('/{slug:blog}/update', [AdminBlogController::class, 'update'])->name('update');

        Route::post('/{blog}/upload-image', [AdminBlogController::class, 'uploadImage'])->name('upload.image'); //Dodawanie, zmiana grafiki
        Route::delete('/{slug:blog}/delete', [AdminBlogController::class, 'delete'])->name('delete');
    });




//Route::get('panel/shops/{shop}', [BackController::class, 'clickableIndex']);
    Route::get('/', [Backcontroller::class, 'index'])->name('index');
});



Route::get('tchibo',[SearchController::class,'tchibo'])->name('search.tchibo');

Route::domain('{subdomain}.'.$mainDomain)->group(function () {

    Route::get('/w-gazetce/{slug},{id}/', [RedirectController::class, 'productRedirect'])
        ->where(['slug' => '[a-zA-Z0-9-]+', 'id' => '[0-9]+'])  // Doprecyzowanie wzorców
        ->name('productRedirect');


    Route::get('/w-gazetce/{slug}', [ProductController::class, 'showSubdomain'])
        ->name('subdomain.products.show');

    Route::get('/{slug}-gazetka-promocyjna-{combined}/', [RedirectController::class, 'leafletRedirect'])
        ->where([
            'slug' => '[a-zA-Z0-9-]+',
            'combined' => '[0-9]{4}-[0-9]{2}-[0-9]{2},[0-9]+'
        ])
        ->name('leafletRedirect');

    Route::get('/gazetka-promocyjna-{data}/{id}', [LeafletController::class, 'subdomainLeaflet'])
        ->where([
            'data' => '[0-9]{4}-[0-9]{2}-[0-9]{2}',
            'id' => '[0-9]+'
        ])
        ->name('subdomain.leaflet');


    Route::get('/godziny-otwarcia/{city}-{address},{id}/', [RedirectController::class, 'addressRedirect'])
        ->where(['city' => '[a-z-]+', 'address' => '[a-zA-Z0-9-]+', 'id' => '[0-9]+'])  // Doprecyzowanie wzorców
        ->name('addressRedirect');

    Route::get('/{slug}-gazetka-promocyjna-{combined}', [RedirectController::class, 'leafletRedirect'])
        ->where([
            'slug' => '[a-zA-Z0-9-]+',
            'combined' => '[0-9]{4}-[0-9]{2}-[0-9]{2},[0-9]+'
        ])
        ->name('leafletRedirect');


    Route::get('/{community}/{address}', [ShopController::class, 'subdomainShowAddress'])
        ->name('subdomain.shop_address');

    Route::get('/{community}', [MainController::class, 'subdomainIndexGps'])->name('subdomain.index_gps');
    Route::get('/', [MainController::class, 'subdomainIndex'])->name('subdomain.index');

});


Route::domain($mainDomain)->group(function () {

    //Leaflets
    Route::get('/gazetki-promocyjne-{slug},{id}/{place}/', [RedirectController::class, 'placeRedirect'])
        ->where(['slug' => '[a-zA-Z0-9-]+', 'id' => '[0-9]+', 'place' => '[a-zA-Z0-9-]+'])  // Doprecyzowanie wzorców
        ->name('main.place.redirect.leaflet');

    Route::get('/gazetki-promocyjne-{slug},{id}', [RedirectController::class, 'leafletsRedirect'])
        ->where(['slug' => '[a-zA-Z0-9-]+', 'id' => '[0-9]+'])  // Doprecyzowanie wzorców dla slug i id
        ->name('main.leaflets.redirect');

    // Trasa dla kategorii gazetek - powinna być po trasach z ID i slugi, aby uniknąć konfliktu
    Route::get('/gazetki-promocyjne/{category}', [LeafletController::class, 'indexCategory'])
        ->where('category', '[a-zA-Z0-9-]+')  // Doprecyzowanie dopasowania do kategorii
        ->name('main.leaflets.category');

    // Strona główna gazetek
    Route::get('/gazetki-promocyjne', [LeafletController::class, 'index'])->name('main.leaflets');




    //Shops
    Route::get('/sieci-handlowe-{slug},{id}/{place}/', [RedirectController::class, 'placeRedirect'])
        ->where(['slug' => '[a-zA-Z0-9-]+', 'id' => '[0-9]+', 'place' => '[a-zA-Z0-9-]+'])  // Doprecyzowanie wzorców
        ->name('main.place.redirect.shop');

    Route::get('/sieci-handlowe-{slug},{id}/', [RedirectController::class, 'shopRedirect'])
        ->where(['slug' => '[a-zA-Z0-9-]+', 'id' => '[0-9]+'])  // Doprecyzowanie wzorców dla slug i id
        ->name('main.shops.redirect');

    Route::get('/sieci-handlowe/{category}', [ShopController::class,'indexCategory'])->name('main.retailers.category');
    Route::get('/sieci-handlowe',[ShopController::class,'index'])->name('main.retailers');

    //Vouchers
    Route::get('/kupony-rabatowe-{slug},{id}/', [RedirectController::class, 'vouchersRedirect'])
        ->where(['slug' => '[a-zA-Z0-9-]+', 'id' => '[0-9]+'])  // Doprecyzowanie wzorców dla slug i id
        ->name('main.vouchers.redirect');

    Route::get('/kupony-rabatowe/{category}',[VoucherController::class, 'indexCategory'])->name('main.vouchers.category');
    Route::get('/kupony-rabatowe',[VoucherController::class, 'index'])->name('main.vouchers');

    //Products
    Route::get('/produkty/{category}/{subcategory}',[ProductController::class,'indexSubCategory'])->name('main.products.subcategory');
    Route::get('/produkty/{category}',[ProductController::class,'indexCategory'])->name('main.products.category');
    Route::get('/produkty',[ProductController::class,'index'])->name('main.products');
    Route::get('/produkt/{slug}',[ProductController::class,'show'])->name('main.product');


    //Blogs
    Route::get('/poradnik-{slug},{id}/',[RedirectController::class, 'articleRedirect'])
        ->where(['slug' => '[a-zA-Z0-9-]+', 'id' => '[0-9]+'])  // Doprecyzowanie wzorców dla slug i id
        ->name('main.blogs.redirect');

    Route::get('/abc-zakupowicza/{category}/{article}',[BlogController::class, 'show'])->name('main.blogs.article');
    Route::get('/abc-zakupowicza/{category}',[BlogController::class, 'indexCategory'])->name('main.blogs.category');
    Route::get('/abc-zakupowicza',[BlogController::class, 'index'])->name('main.blogs');

    //Maps
    Route::get('/lokalizacje/{category}', [PlaceController::class, 'indexVoivodeship'])->name('main.maps.voivodeship');
    Route::get('/lokalizacje', [PlaceController::class, 'index'])->name('main.maps');

    //Footer
    Route::get('/onas', [MainController::class, 'about'])->name('main.about');
    Route::get('/polityka-prywatnosci', [MainController::class, 'privacy'])->name('main.privacy');
    Route::get('/polityka-cookies', [MainController::class, 'cookies'])->name('main.cookies');
    Route::get('/regulamin', [MainController::class, 'statute'])->name('main.statute');
    Route::get('/kontakt',[ContactController::class,'index'])->name('main.contact');

    Route::post('/send-contact',[ContactController::class,'send'])->name('main.contact.send');
    Route::post('/ratings', [RatingController::class, 'store'])->middleware('auth')->name('ratings.store');
    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
    Route::get('/convert', [LeafletCoverController::class, 'storePage']);

    Route::get('/combination', [SearchController::class, 'combination'])
        ->middleware('auth')
        ->name('combination');

    require __DIR__.'/auth.php';

   //Main
    Route::get('/{community}',[MainController::class,'indexGps'])->name('main.index.gps');
    Route::get('/',[MainController::class,'index'])->name('main.index');

});







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

