<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use App\Models\Voucher;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {

        $blogs = Blog::with('category')->orderBy('id', 'desc')->paginate(10);

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Blogs', 'url' => '']
        ];

        return view('admin.blog.index',
        [
            'blogs' => $blogs,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function create()
    {

        $user = User::with('profile')->where('id', 1)->first();
        $categories = Category::where('type', 'blog')->get();


        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Blogs', 'url' => route('admin.blogs.index')],
            ['label' => 'Dodaj artykuł', 'url' => '']
        ];

        return view('admin.blog.create',
            [
                'user' => $user,
                'categories' => $categories,
                'breadcrumbs' => $breadcrumbs
            ]);
    }

    public function add(Request $request)
    {
//        dd($request->all());
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'published_at' => 'nullable|date',
            'status' => 'required|in:published,archive,draft',
            'excerpt' => 'nullable|string|max:1200',
            'body' => 'nullable|string|max:20000',
            'image' => 'nullable|image|max:2048',
            'user_id' => 'nullable|exists:users,id',
        ]);
        $path = 'images/blogs/images/photo_' . uniqid();

        if ($request->hasFile('image')) {

            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path,
                800,
                500
            );

            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path.'-100x100',
                100,
                100
            );
            if (!empty($result)) {
                $validated['image'] = $path;
            }
        }

        if(empty($validated['slug']))
        {
            $validated['slug'] = $this->generateSlug($validated['title']);

        }


        $body = str_replace('<p>', '<p class="my-2 pl-2 leading-7 text-gray-700">', $validated['body']);
        $body = str_replace('<h2>', '<h2 class="font-bold my-4 text-1xl">', $body);
        $body = str_replace('<h3>', '<h3 class="font-semibold my-4 pl-2 text-lg text-gray-800">', $body);
        $validated['body'] = $body;

        Blog::create([
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'category_id' => $validated['category_id'],
            'published_at' => $validated['published_at'],
            'status' => $validated['status'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'image' => $validated['image'],
            'user_id' => $validated['user_id'],
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Artykuł został dodany.');
    }

    public function edit($slug)
    {

        $blog = Blog::with('category')->where('slug', $slug)->first();
        $categories = Category::where('status', 'active')->where('type', 'blog')->get();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Blogs', 'url' => route('admin.blogs.index')],
            ['label' => $blog->title, 'url' => '']
        ];

        return view('admin.blog.edit',
            [
                'blog' => $blog,
                'categories' => $categories,
                'breadcrumbs' => $breadcrumbs
            ]);
    }

    public function update(Request $request, $slug = null)
    {

        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'published_at' => 'nullable|date',
            'status' => 'required|in:published,archive,draft',
            'excerpt' => 'nullable|string|max:1200',
            'body' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);


        $blog = Blog::where('slug', $slug)->first();

//        dd($blog);
        if(empty($validated['slug']))
        {
            $validated['slug'] = $this->generateSlug($validated['title']);

        }

        $body = str_replace('<p>', '<p class="my-2 pl-2 leading-7 text-gray-700">', $validated['body']);
        $body = str_replace('<h2>', '<h2 class="font-bold my-4 text-1xl">', $body);
        $body = str_replace('<h3>', '<h3 class="font-semibold my-4 pl-2 text-lg text-gray-800">', $body);
        $validated['body'] = $body;

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Artykuł został zaktualizowany.');
    }

    public function uploadImage(Request $request, Blog $blog)
    {

        try {
            $request->validate([
                'image' => 'required|image|max:10000',
            ]);


            $pathWithoutExtension = 'images/blogs/images/photo_' . uniqid();


            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $pathWithoutExtension,
                800,
                500
            );

            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $pathWithoutExtension.'-100x100',
                100,
                100
            );

            if (!empty($result)) {
                // zapisujemy tylko path bez rozszerzenia

                if ($blog->image && Storage::disk('public')->exists($blog->image . '.webp')) {
                        Storage::disk('public')->delete([$blog->image . '.webp', $blog->image . '.avif', $blog->image . '.jpg']);
                }

                $blog->update([
                    'image' => $pathWithoutExtension
                ]);
            }

            return back()->with('success', 'Grafika została zapisana.');
        } catch (\Throwable $e) {
            Log::error('Błąd podczas aktualizacji zdjęcia produktu', [
                'product_id' => $blog->id,
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Wystąpił błąd przy zapisie grafiki.');
        }

    }

    public function uploadImageTiny(Request $request)
    {
        Log::info('Zapytanie otrzymane', ['request' => $request->all()]);
        // Walidacja pliku (opcjonalnie)
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20048', // Maksymalny rozmiar 2MB
        ]);

        if ($request->hasFile('file')) {
            $path = 'images/blog/images/tiny/photo_' . uniqid();
            $result = app(ImageService::class)->convertAndStore(
                $request->file('file')->getContent(),
                $path,
                800,
                500
            );
            Log::info('Plik zapisany:', ['path' => $path]);
            $json = json_encode([
                'location' => Storage::url($path.'.webp'), // Zwracamy pełny URL do obrazu
            ]);
            Log::info('Plik zapisany:', ['path' => $json]);
                return response()->json([
                    'location' => Storage::url($path.'.webp'), // Zwracamy pełny URL do obrazu
                ]);

        }


        return response()->json(['error' => 'No file uploaded'], 400);
    }

    protected function generateSlug($string) {
        $map = [
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n',
            'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z', 'Ą' => 'a',
            'Ć' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n', 'Ó' => 'o',
            'Ś' => 's', 'Ź' => 'z', 'Ż' => 'z'
        ];
        $string = strtr($string, $map);
        $string = mb_strtolower($string, 'UTF-8');
        $string = preg_replace('/[^\w\s-]/', '', $string);
        $string = preg_replace('/[\s_]+/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);

        return trim($string, '-');
    }
}
