<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Voucher;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index($descriptions, $blogCategory, $leaflets)
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
            ['label' => 'ABC Zakupowicza', 'url' => ''],
        ];

        return view('main.blogs.index', data:
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
