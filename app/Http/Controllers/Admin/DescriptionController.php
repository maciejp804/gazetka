<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use App\Services\ImageService;
use Illuminate\Http\Request;

class DescriptionController extends Controller
{
    public function editContent(Shop $shop)
    {
        $shop = Shop::with('description')->where('id', $shop->id)->first();

        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Sieci handlowe', 'url' => route('admin.shops.index')],
            ['label' => mb_ucfirst($shop->name), 'url' => route('admin.shops.manage', $shop->slug)],
            ['label' => 'Tekst głowny', 'url' => '']
        ];



        return view('admin.shop.description.edit_content', [
            'shop' => $shop,
            'breadcrumbs' => $breadcrumbs,

        ]);

    }

    public function updateContent(Request $request, Product $product)
    {
        $validated = $request->validate([
            'content' => 'required|array',
            'content.*.h2_title' => 'nullable|string|max:255',
            'content.*.h3_title' => 'nullable|string|max:255',
            'content.*.body' => 'nullable|string',
            'content.*.image' => 'nullable|string|max:2048',
        ]);

        $blocks = [];

        foreach ($validated['content'] as $index => $block) {

            $data = [
                'h2_title' => $block['h2_title'] ?? '',
                'h3_title' => $block['h3_title'] ?? '',
                'body' => $block['body'] ?? '',
                'image' => $block['image'] ?? '',
            ];

            $blocks[] = $data;
        }

        $product->descriptions->update([
            'content' => $blocks,
        ]);

        return back()->with('success', 'Zawartość została zaktualizowana.');
    }

    public function updateContentImage(Request $request, Shop $shop, int $index)
    {

        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $description = $shop->description;

        if (!$description || !isset($description->content[$index])) {
            return back()->withErrors(['error' => 'Nie znaleziono bloku do edycji.']);
        }

        $block = $description->content[$index];

        // Przetwórz obrazek
        $path = 'images/shops/content/image_' . uniqid();
        $result = app(ImageService::class)->convertAndStore(
            $request->file('image')->getContent(),
            $path,
            1200,
            800
        );

        if (!empty($result)) {
            // Podmień tylko pole image w konkretnym bloku
            $block['image'] = $path;

            $content = $description->content;
            $content[$index] = $block;

            $description->update([
                'content' => $content
            ]);
        }

        return back()->with('success', 'Obrazek został zaktualizowany.');
    }

    public function editFaq(Shop $shop)
    {
        $shop = Shop::with('description')->where('id', $shop->id)->first();


        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Sieci handlowe', 'url' => route('admin.shops.index')],
            ['label' => mb_ucfirst($shop->name), 'url' => route('admin.shops.manage', $shop->slug)],
            ['label' => 'FAQ', 'url' => '']
        ];


        return view('admin.shop.description.edit_faq', [
            'shop' => $shop,
            'breadcrumbs' => $breadcrumbs,

        ]);

    }
    public function updateFaq(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'faq' => 'nullable|array',
            'faq.*.question' => 'nullable|string|max:255',
            'faq.*.answer' => 'nullable|string|max:1000',
        ]);

        // Załaduj relację
        $shop->load('description');

        // Użyj updateOrCreate na relacji
        $shop->description()->updateOrCreate(
            [], // domyślny warunek – tylko jeden rekord powiązany
            [
                'faq' => $validated['faq'] ?? [],
                'route_name' => 'subdomain.index',
                'shop_id' => $shop->id// <- dostosuj do swojego kontekstu
                ],

        );

        return redirect()
            ->route('admin.shops.manage', $shop)
            ->with('update', 'FAQ produktu zaktualizowany.');
    }

}
