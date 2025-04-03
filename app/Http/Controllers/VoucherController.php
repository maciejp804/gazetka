<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Description;
use App\Models\Leaflet;
use App\Models\Place;
use App\Models\Shop;
use App\Models\Tag;
use App\Models\Voucher;
use App\Models\VoucherStore;
use App\Services\ImageService;
use App\Services\SortOptionsService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class VoucherController extends Controller
{
    public function index()
    {
        $placesAll = Place::all();

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $shops = $this->shops(32);

        $categories = Category::where('status','active')->where('type', 'voucher')->get();
        $model = new Voucher(); // Przykład: szukamy tagów dla kuponów
        $tags = Tag::whereJsonContains('applies_to', class_basename($model))->where('start_date', '<', now())->where('end_date', '>', now())->get();
        $vouchers = Voucher::with('voucherStore')
            ->where('valid_to', '>=', now('Europe/Warsaw'))->paginate(9);

        $voucher_sort = SortOptionsService::getSortOptions();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Kupony rabatowe', 'url' => ''],
        ];

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        $leaflets = Leaflet::with('shop')->where('valid_to','>=',now())->get();
        $leaflets = $leaflets->sortByDesc('created_at')->take(40);


        return view('main.vouchers.index', data:
            [

                //Lokalizacja
                'place' => $place,

                'h1_title'=> 'Aktualne kody rabatowe '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' - kupony na zniżki promocyjne',
                'page_title'=> 'Aktualne kody rabatowe, promocje, zniżki '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,

                'voucher_categories' => $categories,
                'tags' => $tags,
                'voucher_sort' => $voucher_sort,
                'vouchers' => $vouchers,
                'shops' => $shops,
                'leaflets' => $leaflets,
            ]);
    }

    public function indexCategory($category, $descriptions, $retailers_category, $retailers_time, $products)
    {

        $categories = Category::where('status','active')->where('type', 'voucher')->get();
        $category = $categories->where('slug', $category)->first();

        if(!$category){
            abort(404);
        }

        $placesAll = Place::all();

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $model = new Voucher(); // Przykład: szukamy tagów dla kuponów
        $tags = Tag::whereJsonContains('applies_to', class_basename($model))->get();

        $vouchers = Voucher::with('voucherStore')->where('category_id', $category->id)
            ->where('valid_to', '>=', now('Europe/Warsaw'))->paginate(9);

        $shops = $this->shops(32);

        $leaflets = Leaflet::with('shop')->where('valid_to','>=',now())->get();
        $leaflets = $leaflets->sortByDesc('created_at')->take(40);

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'Kupony rabatowe', 'url' => route('main.vouchers')],
            ['label' => $category->name, 'url' => ''],
        ];

        $voucher_sort = SortOptionsService::getSortOptions();

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName(), $place) ?? Description::getDefault(Route::currentRouteName(), $place);

        return view('main.vouchers.index_category', data:
            [
                'place' => $place,


                'h1_title'=> 'Aktualne kody rabatowe w kategorii <strong>'.mb_strtolower($category->name).'</strong> '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' - kupony na zniżki promocyjne',
                'page_title'=> 'Aktualne kody rabatowe, promocje, zniżki w kategorii '.$category->name.' '.monthReplace(date('Y-m-d',strtotime('now')), 'full', 'm-Y').' | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'descriptions' => $descriptions,
                'breadcrumbs' => $breadcrumbs,
                'retailers_category' => $retailers_category,
                'retailers_time' => $retailers_time,
                'products' => $products,
                'voucher_categories' => $categories,
                'tags' => $tags,
                'voucher_sort' => $voucher_sort,
                'vouchers' => $vouchers,
                'category' => $category,
                'shops' => $shops,
                "leaflets" => $leaflets,
            ]);
    }

    public function create()
    {
        $stores = VoucherStore::where('status', 'active')->get();
//        $voucher = Voucher::where('status', 'active')->find(1);
        $categories = Category::where('status', 'active')->where('type', 'voucher')->get();
        return view('panel.voucher.create', [
//            'voucher' => $voucher,
            'stores' => $stores,
            'categories' => $categories,
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'code' => 'nullable|string|max:255',
            'conditions' => 'nullable|string|max:255',
            'status' => 'required|in:active,expired,draft',
            'is_featured' => 'nullable|boolean',
            'voucher_store_id' => 'required|exists:voucher_stores,id',
            'category_id' => 'required|exists:categories,id',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = 'images/vouchers/offers/offer_' . uniqid();
            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path,
                120,
                120
            );
            if (!empty($result)) {
                $validated['image'] = $path;
            }
        }

        Voucher::create([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'url' => $validated['url'],
            'code' => $validated['code'],
            'conditions' => $validated['conditions'],
            'status' => $validated['status'],
            'is_featured' => $validated['is_featured'] ?? 0,
            'voucher_store_id' => $validated['voucher_store_id'],
            'category_id' => $validated['category_id'],
            'valid_from' => $validated['valid_from'],
            'valid_to' => $validated['valid_to'],
            'image' => $validated['image'],
        ]);

        return redirect()->route('vouchers.index')->with('success', 'Kupon został dodany.');
    }

    public function edit(Voucher $voucher)
    {
        $stores = VoucherStore::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->where('type', 'voucher')->get();

        return view('panel.voucher.edit', [
            'voucher' => $voucher,
            'stores' => $stores,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Voucher $voucher)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'code' => 'nullable|string|max:255',
            'conditions' => 'nullable|string|max:255',
            'status' => 'required|in:active,expired,draft',
            'is_featured' => 'nullable|boolean',
            'voucher_store_id' => 'required|exists:voucher_stores,id',
            'category_id' => 'required|exists:categories,id',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = 'images/vouchers/offers/offer_' . uniqid();
            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path,
                120,
                120
            );
            if (!empty($result)) {
                $validated['image'] = $path;
            }
        }

        $voucher->update($validated);

        return redirect()->route('vouchers.index')->with('update', 'Kupon został zaktualizowany.');
    }


    public function uploadImage(Request $request, Voucher $voucher)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $pathWithoutExtension = 'images/vouchers/offers/offer_' . uniqid();

        $result = app(ImageService::class)->convertAndStore(
            $request->file('image')->getContent(),
            $pathWithoutExtension,
            120,
            120
        );

        if (!empty($result)) {
            // zapisujemy tylko path bez rozszerzenia
            $voucher->update([
                'image' => $pathWithoutExtension
            ]);
        }

        return back()->with('success', 'Grafika została zapisana.');
    }

    public function uploadLogo(Request $request, Voucher $voucher)
    {
        $request->validate([
            'imageLogo' => 'required|image|max:2048',
        ]);

        $pathWithoutExtension = 'images/vouchers/logo/logo_' . uniqid();

        $result = app(ImageService::class)->convertAndStore(
            $request->file('imageLogo')->getContent(),
            $pathWithoutExtension,
            120,
            44
        );

        if (!empty($result)) {
            // zapisujemy tylko path bez rozszerzenia
            $voucher->voucherStore->update([
                'image' => $pathWithoutExtension
            ]);
        }

        return back()->with('success', 'Grafika została zapisana.');
    }



    protected function shops($limit)
    {
        return Shop::withCount(['leaflets' => function ($query) {
            $query->where('valid_to', '>=',now('Europe/Warsaw')->toDateTime())
                ->where('status', '=', 'published')
                ->where('valid_from', '<=', now('Europe/Warsaw')->toDateTime());
        }])->where('status', '=', 1)
            ->orderBy('ranking', 'desc')->take($limit)->get();
    }
}
