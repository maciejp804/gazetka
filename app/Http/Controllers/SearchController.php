<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Leaflet;
use App\Models\Place;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\Tag;
use App\Models\Voucher;
use App\Models\VoucherStore;
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
            $leaflets = Leaflet::with('shop')
                ->where('valid_to', '>=',now())
                ->whereHas('shop', function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', $query . '%');
                });

            // Filtrowanie według kategorii


            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case '1': // Sortowanie po dacie zakończenia (end)
                        $leaflets = $leaflets->orderBy('updated_at', 'desc');
                        break;

                    case '2': // Sortowanie po dacie zakończenia (end)
                        $leaflets = $leaflets
                            ->where('valid_from', '<=',now())
                            ->orderBy('valid_to', 'asc');
                        break;

                    case '3': // Sortowanie po dacie utworzenia (create)
                        $leaflets = $leaflets
                            ->where('valid_from', '>',now())
                            ->orderBy('valid_from', 'desc');
                        break;

                    case '4': // Filtrowanie tylko aktywnych gazetek
                        $leaflets = $leaflets
                            ->where('valid_from', '<=', now())
                            ->orderBy('valid_from', 'desc');
                        break;
                }
            }
            $leaflets = $leaflets->get();

        }
        // Zwrócenie wyników jako JSON z widokiem
        return response()->json([
            'html' => view('components.search-results-swiper', compact('leaflets'))->render()
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

        if ($searchType === 'leaflets') {

            // Filtrowanie według nazwy
            $leaflets = Leaflet::with('shop')
                ->where('valid_to', '>=',now())
                ->whereHas('shop', function ($queryBuilder) use ($query) {
                    $queryBuilder->where('name', 'like', $query . '%');
                });

            // Filtrowanie według kategorii


            // Obsługa czasu (sortowanie i filtrowanie)
            if ($time != 'all') {
                switch ($time) {
                    case '1': // Sortowanie po dacie zakończenia (end)
                        $leaflets = $leaflets->orderBy('updated_at', 'desc');
                        break;

                    case '2': // Sortowanie po dacie zakończenia (end)
                        $leaflets = $leaflets
                            ->where('valid_from', '<=',now())
                            ->orderBy('valid_to', 'asc');
                        break;

                    case '3': // Sortowanie po dacie utworzenia (create)
                        $leaflets = $leaflets
                            ->where('valid_from', '>',now())
                            ->orderBy('valid_from', 'desc');
                        break;

                    case '4': // Filtrowanie tylko aktywnych gazetek
                        $leaflets = $leaflets
                            ->where('valid_from', '<=', now())
                            ->orderBy('valid_from', 'desc');
                        break;
                }
            }

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

            $products = Product::where('name', 'like', $query . '%');


            // Filtrowanie według kategorii
            if ($category != 'all') {

                $products = $products->where('product_category_id', $category);
            }

           // Obsługa czasu (sortowanie i filtrowanie)


            $results = $products->paginate($limit, ['*'], 'page', $page);

        }

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
        $data = json_decode(file_get_contents(storage_path('app\public\json\new_combinations.json')), true);
        $i = 1;
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
}
