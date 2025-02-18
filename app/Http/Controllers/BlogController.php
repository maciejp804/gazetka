<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Leaflet;
use App\Models\Place;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BlogController extends Controller
{
    public function index($descriptions, $blogCategory)
    {
        $placesAll = Place::all();

        $placesLimit40 = $placesAll->sortByDesc('population')->take(40);

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $leaflets = Leaflet::with('shop', 'cover')
            ->where('valid_to', '>=', now('Europe/Warsaw')->toDateTime())
            ->where('status', '=', 'published')
            ->get(); // Gazetka musi być nadal ważna

        $sum = 0;
        foreach ($blogCategory as $item) {
            $sum += $item['qty'];
        }

        $vouchers = Voucher::with('voucherStore')->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'ABC Zakupowicza', 'url' => ''],
        ];
        $blogCategory = BlogCategory::withCount(['blogs' => function ($query) {
            $query->where('status', '=', 'published');
    }])->get();

        $sum = 0;
        foreach ($blogCategory as $item) {
            $sum += $item['blogs_count'];
        }

        $blogs = BlogCategory::with(['blogs' => function($query) {
            $query->with('user.profile')->orderBy('created_at', 'desc')->take(4);
        }])->get();




        return view('main.blogs.index', data:
            [
                'place' => $place->name,
                'places' => $placesLimit40,

                'h1_title'=> 'ABC Zakupowicza',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'descriptions' => $descriptions,
                'blogCategory' => $blogCategory,
                'blogs' => $blogs,
                'sum' => $sum,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
            ]);
    }

    public function indexCategory($category, $descriptions, $blogCategory, $leaflets)
    {
        $places = Place::all();

        $places = $places->sortByDesc('population')->take(40);

        $place = $places->first();

        $sum = 0;
        foreach ($blogCategory as $item) {
            $sum += $item['qty'];
        }

        $vouchers = Voucher::with('voucherStore')->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'ABC Zakupowicza', 'url' => route('main.blogs')],
            ['label' => $category, 'url' => ''],
        ];

        return view('main.blogs.index_category', data:
            [
                'place' => $place->name,
                'places' => $places,

                'h1_title'=> 'ABC Zakupowicza',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'descriptions' => $descriptions,
                'blogCategory' => $blogCategory,
                'sum' => $sum,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
            ]);
    }

    public function show($category, $article, $descriptions, $blogCategory)
    {

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'ABC Zakupowicza', 'url' => route('main.blogs')],
            ['label' => $category, 'url' =>  route('main.blogs_category', ['category' => $category])],
            ['label' => $article, 'url' => ''],
        ];

        return view('main.blogs.show', data:
            [
                'slug' => 'Warszawa',
                'h1_title'=> 'Jak wywołać zdjęcia w Rossmannie i zaoszczędzić pieniądze?',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'descriptions' => $descriptions,
                'blogCategory' => $blogCategory,
                'breadcrumbs' => $breadcrumbs
            ]);
    }
}
