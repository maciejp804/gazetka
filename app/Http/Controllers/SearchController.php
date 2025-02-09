<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Leaflet;
use App\Models\PageClick;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\Tag;
use App\Models\Voucher;
use App\Models\VoucherStore;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function single(Request $request)
    {
        $query = $request->input('query');
        $searchType = $request->input('searchType');

        $products = $retailers = $places = [];

        if ($searchType === 'products-retailers') {

            $products = Product::where('name', 'like', $query . '%')->get();

            $retailers = Shop::where('name', 'like', $query . '%')->get();

        } elseif ($searchType === 'places') {

            $places = Place::where('name', 'like', $query . '%')->get();

        }
        // Zwrócenie wyników jako JSON z dwoma kategoriami
        return response()->json([
            'html' => view('components.search-results-dropdown', compact('products', 'retailers', 'places'))->render()
        ]);
    }

    public function tripleSwiper(Request $request)
    {
        $query = $request->input('query');
        if ($query !== '') {
            $query = strtolower($query);
        }
        $searchType = $request->input('searchType');
        $category = $request->input('category');
        $time = $request->input('time');


        if ($searchType === 'leaflets') {
            // Filtrowanie według nazwy
            $leaflets = Leaflet::with('shop', 'products')
                ->join('shops', 'leaflets.shop_id', '=', 'shops.id')
                ->where('valid_to', '>=', now('Europe/Warsaw')->toDateTime())
                ->where('leaflets.status', '=', 'published')
                ->whereHas('shop', function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', $query . '%');
                });

            // Filtrowanie według kategorii
                if ($category != 'all')
                {
                    $leaflets->whereHas('products', function ($queryProduct) use ($category) {
                        $queryProduct->where('product_category_id', $category);
                    });
                }



            // Obsługa czasu (sortowanie i filtrowanie)

            $leaflets = $this->leafletsGetOrderBy($time, $leaflets);

            $results = $leaflets->get();

        }


        // Zwrócenie wyników jako JSON z widokiem
        return response()->json([
            'html' => view('components.search-results-swiper', compact('results', 'searchType'))->render()
        ]);

    }

    public function triple($request)
    {
        $query = $request->input('query');
        if ($query !== '') {
            $query = strtolower($query);
        }
        $searchType = $request->input('searchType');
        $category = $request->input('category');
        $time = $request->input('time');

        // Parametry paginacji (domyślnie page=1, limit=10)
        $page  = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $subcategory = $request->input('subcategory');

        if ($searchType === 'leaflets') {

            // Filtrowanie według nazwy
            $leaflets = Leaflet::with('shop', 'products.product_category')
                ->join('shops', 'leaflets.shop_id', '=', 'shops.id')
                ->where('valid_to', '>=', now('Europe/Warsaw')->toDateTime())
                ->where('leaflets.status', '=', 'published')
                ->whereHas('shop', function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', $query . '%');
                });

            // Filtrowanie według kategorii
            if ($category != 'all')
            {
                $leaflets->whereHas('products.product_category', function ($queryProduct) use ($category) {
                    $queryProduct->where('id', $category)
                    ->orWhere('parent_id', $category);
                });
            }


            // Obsługa czasu (sortowanie i filtrowanie)

           $leaflets = $this->leafletsGetOrderBy($time, $leaflets);

           $results = $leaflets->paginate($limit, ['*'], 'page', $page);

        } elseif ($searchType === 'retailers') {

            $retailers = Shop::where('name', 'like', $query . '%');

            // Filtrowanie według kategorii
            if($category != 'all')
            {
                $retailers = $retailers
                    ->where('shop_category_id', $category);
            }

            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case '1': // Sortowanie po ulubionych

                        break;

                    case '2': // Sortowanie po najwyżej oceniane
                        $retailers = $retailers
                            ->orderBy('ranking', 'desc');
                        break;

                    case '3': // Sortowanie po nazwie Alfabetycznie
                        $retailers = $retailers
                            ->orderBy('name', 'asc');
                        break;

                    case '4': //

                        break;
                }
            }
            $results = $retailers->paginate($limit, ['*'], 'page', $page);

        } elseif ($searchType === 'products') {

            $products = PageClick::select('page_clicks.*')
                ->join('leaflet_products', 'page_clicks.leaflet_product_id', '=', 'leaflet_products.id')
                ->where('valid_from', '<=', now())
                ->where('valid_to', '>=', now())
                ->whereHas('leafletProduct.product', function ($queryName) use ($query) {
                    $queryName->where('name', 'like', $query . '%');
                });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                if ($subcategory != 'all') {
                    // Filtrowanie po konkretnej subkategorii – produkt musi mieć product_category_id równy $subcategory.
                    $products = $products->whereHas('leafletProduct.product.category', function ($queryCategory) use ($subcategory) {
                        $queryCategory->where('id', $subcategory);
                    });
                } else {
                    // Filtrowanie po głównej kategorii – produkt może być przypisany do głównej kategorii
                    // lub do którejś z jej subkategorii (czyli tam, gdzie parent_id = $category).
                    $products = $products->whereHas('leafletProduct.product.category', function ($queryCategory) use ($category) {
                        $queryCategory->where('id', $category)
                            ->orWhere('parent_id', $category);
                    });
                }
            }

            // Obsługa czasu (sortowanie i filtrowanie)

            $products = $this->productsGetOrderBy($time, $products);

            $results = $products->paginate($limit, ['*'], 'page', $page);



            $flattenedCollection = $results->getCollection()->flatMap(function ($click) {
                return $click->page->leaflets->map(function ($leaflet) use ($click) {
                    return [
                        'click_id'      => $click->id,
                        'valid_from'    => $click->valid_from,
                        'valid_to'      => $click->valid_to,
                        'page_id'       => $click->page->id,
                        'leaflet_id'    => $leaflet->id,
                        'logo_xs'       => $leaflet->shop ? $leaflet->shop->logo_xs : null,
                        'shop_name'     => $leaflet->shop ? $leaflet->shop->name : null,
                        'shop_slug'     => $leaflet->shop ? $leaflet->shop->slug : null,
                        'product_id'    => $click->leafletProduct->product ? $click->leafletProduct->product->id : null,
                        'product_name'  => $click->leafletProduct->product ? $click->leafletProduct->product->name : null,
                        'product_slug'  => $click->leafletProduct->product ? $click->leafletProduct->product->slug : null,
                        'product_image'  => $click->leafletProduct->product ? $click->leafletProduct->product->image : null,
                        'price'         => $click->leafletProduct ? $click->leafletProduct->price : null,
                        'promo_price'   => $click->leafletProduct ? $click->leafletProduct->promo_price : null,
                    ];
                });
            });

            // Podmiana kolekcji w paginatorze – zachowujemy metadane paginacji
            $results->setCollection($flattenedCollection);



        }

        $html = view('components.search-results-container', compact('results', 'searchType'))->render();

        // Zwrócenie wyników jako JSON z widokiem
        return response()->json([
            'html' => $html,
            'pagination' => [
                'currentPage' => $results->currentPage(),
                'totalPages'  => $results->lastPage(),
                'total'        => $results->total(),
                // ewentualnie total() też się przydaje
            ],
        ]);
    }

   public function quadruple($request)
    {
        $query = $request->input('query');
        if ($query !== '') {
            $query = strtolower($query);
        }
        $searchType = $request->input('searchType');
        $category = $request->input('category');
        $time = $request->input('time');
        $type = $request->input('type');

        // Parametry paginacji (domyślnie page=1, limit=10)
        $page  = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        if ($searchType === 'vouchers') {

            // Filtrowanie według nazwy
            $vouchers = Voucher::with('voucherStore')
                ->where('end_date', '>=',now())
                ->whereHas('voucherStore', function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', $query . '%');
                });

            // Filtrowanie według kategorii
            if ($category != 'all') {
                $vouchers = $vouchers->where('voucher_category_id', $category);
            }

            // Filtrowanie według tagów
            if ($type != 'all') {
                $vouchers = $vouchers->whereHas('tags', function ($queries) use ($type) {
                    $queries->where('tags.id', $type);
                });
            }

            // Filtrowanie według czasu
            if ($time != 'all') {
                switch ($time) {
                    case '1': // Sortowanie według daty rozpoczęcia
                        $vouchers = $vouchers->orderBy('updated_at', 'desc');
                        break;

                    case '2':
                        $vouchers = $vouchers->orderBy('end_date', 'asc');
                        break;

                    case '3':
                        $vouchers = $vouchers->where('start_date','>', now());
                        break;

                    case '4':
                        $vouchers = $vouchers->where('start_date','<', now());
                        break;
                    // Dodaj inne przypadki, jeśli są wymagane
                }
            }

            $results = $vouchers->paginate($limit, ['*'], 'page', $page);

        }


        // Zwrócenie wyników jako JSON z widokiem
        $html = view('components.search-results-container', compact('results', 'searchType'))->render();

        // Zwrócenie wyników jako JSON z widokiem
        return response()->json([
            'html' => $html,
            'pagination' => [
                'currentPage' => $results->currentPage(),
                'totalPages'  => $results->lastPage(),
                // ewentualnie total() też się przydaje
            ],
        ]);
    }

    public function test($week, $number, $start)
    {
        set_time_limit(3200);
        $data = json_decode(file_get_contents(storage_path('app\public\json\kombinacje.json')), true);
        $i = 0;
        $l = 356406;
        foreach ($data['combinations'] as $combination) {
            if ($i >= $start) {

                //$url = 'https://pepco.pl/wp-content/uploads/2024/11/P10_'.$l.'_Leaflet_1.jpg';
                $url = 'https://gazetki.aldi.pl/2025/kw'.$week.'/25k'.$week.'g'.$number . $combination . '//GetPDF.ashx';
                //$url = 'https://gazetki.aldi.pl/2024/kw33/24k33g01cdga//GetPDF.ashx';
                $ch = curl_init($url);

                // Set cURL options
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);


                // Execute the cURL session
                $response = curl_exec($ch);

                // Check for errors
                if (curl_errno($ch)) {
                    echo 'Error: ' . curl_error($ch) . PHP_EOL;
                } else {
                    // Get the HTTP response status code
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    // Process the response based on the status code
                    if ($http_code == 200) {
                        echo "<span style='color: green'>$i. Catalog ID $url exists and is accessible.</span>" . '<br/>';
                        curl_close($ch);

                        break;

                    } else {
                        echo "<span style='color: red'>$i. Catalog ID $url is not accessible. HTTP Status Code: $http_code </span>" . '<br/>';
                    }
                }

                // Close the cURL session
                curl_close($ch);
            }

            $i++;
            $l++;
            // break;
        }
    }

    public function combination()
    {


        $letters = ["a", "b", "c", "d", "e", "f", "g", "h", "j", "o", "t", "k"];
        $combinations = [];

// Cztery zagnieżdżone pętle generują wszystkie 4-literowe ciągi
        foreach ($letters as $l1) {
            foreach ($letters as $l2) {
                foreach ($letters as $l3) {
                    foreach ($letters as $l4) {
                        $combinations[] = $l1 . $l2 . $l3 . $l4;
                    }
                }
            }
        }

// Zamiana tablicy na format JSON z ładnym formatowaniem
        $json = json_encode($combinations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Zapis do pliku kombinacje.json w bieżącym katalogu
        file_put_contents("kombinacje.json", $json);

        echo "Wygenerowano " . count($combinations) . " kombinacji. Plik 'kombinacje.json' został zapisany.\n";

    }

    /**
     * @param mixed $time
     * @param Builder $leaflets
     * @return Builder
     */
    public function leafletsGetOrderBy(mixed $time, Builder $leaflets): Builder
    {
        switch ($time) {
            case 'all': // Sortowanie po updated_at (ostatnio dodane)
                $leaflets = $leaflets->orderBy('leaflets.updated_at', 'desc');
                break;

            case '1': // Sortowanie po updated_at (ostatnio dodane)
                $leaflets = $leaflets->orderBy('shops.ranking', 'desc');

                break;

            case '2': // Sortowanie po dacie zakończenia (end)
                $leaflets = $leaflets
                    ->where('valid_from', '<=', now('Europe/Warsaw')->toDateTime())
                    ->orderBy('valid_to', 'asc');
                break;

            case '3': // Sortowanie po dacie startu gdzie jest ona w przyszłości
                $leaflets = $leaflets
                    ->where('valid_from', '>', now())
                    ->orderBy('valid_from', 'desc');
                break;

            case '4': // Filtrowanie tylko aktywnych gazetek
                $leaflets = $leaflets
                    ->where('valid_from', '<=', now())
                    ->orderBy('valid_from', 'desc');
                break;
        }
        return $leaflets;
    }

    /**
     * @param mixed $time
     * @param Builder $leaflets
     * @return Builder
     */
    public function productsGetOrderBy(mixed $time, Builder $products): Builder
    {
        switch ($time) {
            case 'all': // Sortowanie po updated_at (ostatnio dodane)
                $products = $products->orderBy('updated_at', 'desc');
                break;

            case '1': // Sortowanie po updated_at (ostatnio dodane)

                $products = $products->orderBy('promo_price', 'asc');
                break;

            case '2': // Sortowanie po updated_at (ostatnio dodane)

                $products = $products->orderBy('promo_price', 'desc');
                break;

            case '3': // Sortowanie po dacie zakończenia (end)
                $products = $products
                    ->where('valid_from', '<=', now('Europe/Warsaw')->toDateTime())
                    ->orderBy('valid_to', 'asc');
                break;

            case '4': // Sortowanie po dacie startu gdzie jest ona w przyszłości
                $products = $products
                    ->where('valid_from', '>',  now('Europe/Warsaw')->toDateTime())
                    ->orderBy('valid_from', 'desc');
                break;

            case '5': // Filtrowanie tylko aktywnych gazetek
                $products = $products
                    ->where('valid_from', '<=',  now('Europe/Warsaw')->toDateTime())
                    ->orderBy('valid_from', 'desc');
                break;
        }
        return $products;
    }
}
