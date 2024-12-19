<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    }

    public function tripleSwiper(Request $request, $leaflets)
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

    }

    public function triple($request, $leaflets, $retailers, $products, $vouchers)
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

            $retailers_category =ShopCategory::all();
            $retailers = Shop::where('name', 'like', '%' . $query . '%')->get();


            // Filtrowanie według kategorii
            if ($category != 'all') {

                $category_id = $retailers_category->where('id', $category)->first()->id;
                $retailers = $retailers->where('shop_category_id', $category_id);
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

        } elseif ($searchType === 'products') {


            $product_categories = ProductCategory::all();

            $products = Product::where('name', 'like', $query . '%')->get();


            // Filtrowanie według kategorii
            if ($category != 'all') {
                $category_id = $product_categories->where('id', $category)->first()->id;
                $products = $products->where('product_category_id', $category_id);
            }

//            // Obsługa czasu (sortowanie i filtrowanie)
//            if ($time != 'all') {
//                switch ($time) {
//                    case 'ending': // Sortowanie po dacie zakończenia (end)
//                        usort($products, function ($a, $b) {
//                            return $a['end'] <=> $b['end'];
//                        });
//                        break;
//
//                    case 'last': // Sortowanie po dacie utworzenia (create)
//                        usort($products, function ($a, $b) {
//                            return $a['create'] <=> $b['create'];
//                        });
//                        break;
//
//                    case 'active': // Filtrowanie tylko aktywnych gazetek
//                        $products = array_filter($products, function ($item) {
//                            $today = date('Y-m-d');
//                            return $item['start'] <= $today && $item['end'] >= $today;
//                        });
//                        break;
//                }
//            }


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
    }

   public function quadruple($request, $leaflets, $retailers, $products)
    {
        $query = $request->input('query');
        if ($query !== '') {
            $query = strtolower($query);
        }
        $searchType = $request->input('searchType');
        $category = $request->input('category');
        $time = $request->input('time');
        $type = $request->input('type');

        if ($searchType === 'vouchers') {
            $voucher_store_ids = VoucherStore::where('name', 'like', $query . '%')->pluck('id');

            $vouchers = Voucher::with('voucherStore')->whereIn('voucher_store_id', $voucher_store_ids);

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

            $vouchers = $vouchers->get();

            // Puste wyniki dla innych typów
            $retailers = [];
            $leaflets = [];
            $products = [];
        }


        // Zwrócenie wyników jako JSON z widokiem
        return response()->json([
            'html' => view('components.search-results-container', compact('leaflets', 'retailers', 'products', 'vouchers'))->render()
        ]);
    }

    public function test()
    {
        set_time_limit(3200);
        $data = json_decode(file_get_contents(storage_path('app\public\json\combinations_sorted_with_o_t_at_end.json')), true);
        $i = 1;
        $l = 356406;
        foreach ($data['combinations'] as $combination) {
            if ($i > 0) {

                //$url = 'https://pepco.pl/wp-content/uploads/2024/11/P10_'.$l.'_Leaflet_1.jpg';
                $url = 'https://gazetki.aldi.pl/2024/kw52/24k52g02' . $combination . '//GetPDF.ashx';
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
