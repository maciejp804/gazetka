<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Description;
use App\Models\Leaflet;
use App\Models\Place;
use App\Models\Voucher;
use App\Services\ImageService;
use App\Services\LeafletService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class BlogController extends Controller
{

    protected LeafletService $leafletService;
    protected ImageService $imageService;

    public function __construct(LeafletService $leafletService, ImageService $imageService)
    {
        $this->leafletService = $leafletService;
        $this->imageService = $imageService;
    }

    public function index()
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

        [$leaflets, $counter] = $this->leafletService->getLeaflets(20);


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

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName());
        $default_descriptions = Description::getDefaultBlogs(Route::currentRouteName());

        return view('main.blogs.index', data:
            [
                'place' => $place->name,
                'places' => $placesLimit40,

                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",



                'blogCategory' => $categories,
                'blogs' => $blogs,
                'blogsNewtest' => $blogsNewtest,
                'sum' => $sum,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
            ]);
    }

    public function indexCategory($category)
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

        [$leaflets, $counter] = $this->leafletService->getLeaflets(20);

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

        $descriptions = Description::getByRouteAndPlace(Route::currentRouteName());
        $default_descriptions = Description::getDefaultBlogs(Route::currentRouteName(), $category);

        return view('main.blogs.index_category', data:
            [
                'place' => $place->name,
                'places' => $places,

                'h1_title' => $descriptions->h1_title ?? $default_descriptions->h1_title ?? "DoMyślny",
                'meta_title'=> $descriptions->meta_title ?? $default_descriptions->meta_title ?? "DoMyślny",
                'meta_description' => $descriptions->meta_description ?? $default_descriptions->meta_description ?? "DoMyślny",
                'descriptions' => $descriptions,
                'excerpt' => $descriptions->excerpt ?? $default_descriptions->excerpt ?? "DoMyślny",

                'blogCategories' => $categories,
                'blogCategory' => $blogCategory,
                'blogs' => $blogs,
                'sum' => $sum,
                'breadcrumbs' => $breadcrumbs,
                'leaflets' => $leaflets,
                'vouchers' => $vouchers,
            ]);
    }

    public function show($category, $article)
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

        $path = $blog->image . '.webp';

    if (Storage::disk('public')->exists($path)) {
        $image = Image::read(Storage::disk('public')->get($path));
        $width = $image->width();
        $height = $image->height();
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

                'h1_title' => $blog->title ?? "DoMyślny",
                'meta_title'=> $blog->meta_title ?? $blog->title ?? "DoMyślny",
                'meta_description' => !empty($blog->meta_description) ? $blog->meta_description : (!empty($blog->excerpt) ? $blog->excerpt : 'DoMyślny'),
                'excerpt' => $blog->excerpt ?? "DoMyślny",

                'blogCategory' => $blogCategory,
                'blog' => $blog,
                'blogs' => $blogs,
                'width' => $width,
                'height' => $height,
                'breadcrumbs' => $breadcrumbs
            ]);
    }
}
