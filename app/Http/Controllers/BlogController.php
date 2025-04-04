<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Leaflet;
use App\Models\Place;
use App\Models\Voucher;
use Illuminate\Support\Facades\Cookie;

class BlogController extends Controller
{
    public function index($descriptions)
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


        $vouchers = Voucher::with('voucherStore')->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'ABC Zakupowicza', 'url' => ''],
        ];

        $categories = Category::withCount(['blogs' => function ($query) {
            $query->where('status', '=', 'published');
                }])->where('status','active')->where('type', 'blog')->get();

        $sum = 0;
        foreach ($categories as $item) {
            $sum += $item['blogs_count'];
        }

        $blogs = Category::with(['blogs' => function($query) {
            $query->with('user.profile')->orderBy('created_at', 'desc')->take(4);
        }])->where('status','active')->where('type', 'blog')->get();

        $blogsNewtest = Blog::getAll(4);


        return view('main.blogs.index', data:
            [
                'place' => $place->name,
                'places' => $placesLimit40,

                'h1_title'=> 'ABC Zakupowicza',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',

                'descriptions' => $descriptions,
                'blogCategory' => $categories,
                'blogs' => $blogs,
                'blogsNewtest' => $blogsNewtest,
                'sum' => $sum,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
            ]);
    }

    public function indexCategory($category, $descriptions)
    {
        $categories = Category::withCount(['blogs' => function ($query) {
            $query->where('status', '=', 'published');
        }])->where('status','active')->where('type', 'blog')->get();

        $blogCategory = $categories->where('slug', '=', $category)->first();

        if(!$blogCategory)
        {
            abort(404);
        }

        $places = Place::all();

        $places = $places->sortByDesc('population')->take(40);

        $place = $places->first();

        $leaflets = Leaflet::with('shop', 'cover')
            ->where('valid_to', '>=', now('Europe/Warsaw')->toDateTime())
            ->where('status', '=', 'published')
            ->get(); // Gazetka musi być nadal ważna

        $sum = 0;
        foreach ($categories as $item) {
            $sum += $item['blogs_count'];
        }

        $blogs = Blog::with(['user.profile', 'category'])
            ->where('category_id', '=', $blogCategory->id)
            ->orderBy('created_at', 'desc')->paginate(7);

        $vouchers = Voucher::with('voucherStore')->get();

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'ABC Zakupowicza', 'url' => route('main.blogs')],
            ['label' => $blogCategory->name, 'url' => ''],
        ];

        return view('main.blogs.index_category', data:
            [
                'place' => $place->name,
                'places' => $places,

                'h1_title'=> 'ABC Zakupowicza',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'descriptions' => $descriptions,
                'blogCategories' => $categories,
                'blogCategory' => $blogCategory,
                'blogs' => $blogs,
                'sum' => $sum,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
            ]);
    }

    public function show($category, $article, $descriptions)
    {

        $categories = Category::withCount(['blogs' => function ($query) {
            $query->where('status', '=', 'published');
        }])->where('status','active')->where('type', 'blog')->get();

        $blogCategory = $categories->where('slug', '=', $category)->first();

        if(!$blogCategory)
        {
            abort(404);
        }

        $blogs = Blog::with(['user.profile', 'category'])
            ->orderBy('created_at', 'desc')->get();

        $blog = $blogs
            ->where('slug', '=', $article)->first();

        if(!$blog)
        {
            abort(404);
        }

        $blogs = $blogs
            ->where('slug', '!=', $article)->take(10);

        $placesAll = Place::all();

        $placesLimit40 = $placesAll->sortByDesc('population')->take(40);

        $location = Cookie::get('user_location');

        if (!$location) {
            $place = $placesAll->where('id', '=', 1172)->first();
        } else {
            $locationData = json_decode($location, true);
            $place = $placesAll->where('id', '=', $locationData['id'])->first();
        }

        $breadcrumbs = [
            ['label' => 'Strona główna', 'url' => route('main.index')],
            ['label' => 'ABC Zakupowicza', 'url' => route('main.blogs')],
            ['label' => $blogCategory->name, 'url' =>  route('main.blogs.category', ['category' => $category])],
            ['label' => $blog->title, 'url' => ''],
        ];

        return view('main.blogs.show', data:
            [
                'place' => $place->name,
                'places' => $placesLimit40,

                'h1_title'=> 'Jak wywołać zdjęcia w Rossmannie i zaoszczędzić pieniądze?',
                'page_title'=> 'Gazetki promocyjne, nowe i nadchodzące promocje | GazetkaPromocyjna.com.pl',
                'meta_description' => 'Gazetki promocyjne sieci handlowych pozwolą Ci zaoszczędzić czas i pieniądze. Dzięki nowym ulotkom poznasz aktualną ofertę sklepów.',
                'descriptions' => $descriptions,
                'blogCategory' => $blogCategory,
                'blog' => $blog,
                'blogs' => $blogs,
                'breadcrumbs' => $breadcrumbs
            ]);
    }
}
