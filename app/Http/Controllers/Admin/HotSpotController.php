<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotSpot;
use App\Models\Leaflet;
use App\Models\LeafletProduct;
use App\Models\Page;
use App\Models\PageClick;
use App\Models\Product;
use App\Services\ImageService;
use App\Services\ScraperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Symfony\Component\DomCrawler\Crawler;

class HotSpotController extends Controller
{

    protected ScraperService $scraperService;

    public function __construct(ScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    public function create(Leaflet $leaflet)
    {

        // Pobranie stron gazetki posortowanych na podstawie sort_order z paginacją (np. 10 stron na stronę)
        $pages = $leaflet->pages()
            ->with('hotSpots.product')
            ->orderBy('leaflet_page.sort_order')  // Sortowanie na podstawie kolumny sort_order w tabeli pivot
            ->paginate(1);  // Paginacja, 10 stron na stronę



        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => route('admin.leaflets.index')],
            ['label' => $leaflet->shop->name.'-'.$leaflet->title, 'url' => route('admin.leaflets.manage', $leaflet->id)],
            ['label' => 'Opisz', 'url' => '']

        ];


        return view('admin.leaflet.page.edit_order.product.create',[
            'leaflet' => $leaflet,
            'breadcrumbs' => $breadcrumbs,
            'pages' => $pages,
        ]);
    }

    public function add(Request $request, Leaflet $leaflet)
    {

        $leaflet = $leaflet->find($request->leaflet_id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'leaflet_id' => 'required|exists:leaflets,id',
            'page_id' => 'required|exists:leaflets,id',
        ]);


        // Tworzenie rekordu w tabeli HotSpot
        HotSpot::create([
            'page_id' => $validated['page_id'],
            'product_id' => $validated['product_id'],
            'status' => 'hidden',
            'priority' => 'low',
            'valid_from' => $leaflet->valid_from,
            'valid_to' => $leaflet->valid_to,
            'x' => 10,
            'y' => 10,
            'width' => 50,
            'height' => 50,
            'price' => $request->input('price', 0),
            'promo_price' => $request->input('promo_price', 0),
        ]);




        return redirect()->back()->with('success', 'Produkt dodany');
    }

    public function import(Request $request, Leaflet $leaflet)
    {
        // Walidacja pliku
        $validated = $request->validate([
            'file' => 'required|mimes:csv,json|max:2048',
        ]);

        // Odczytanie zawartości pliku JSON
        $fileContent = file_get_contents($validated['file']);
        $data = json_decode($fileContent, true);

        // Sprawdzanie formatu
        if (isset($data[0]['page'])) {
            // Format 2: { "page": 1, "page_id": 146, ... }
            $this->importFormatTwo($data, $leaflet);
        } else {
            // Format 1: { "1": [ "44", "1881", ...] }
            $this->importFormatOne($data, $leaflet);
        }

        return redirect()->back()->with('success', 'Produkty zostały zaimportowane');
    }

    public function export(Request $request, Leaflet $leaflet)
    {
        $hotspots = HotSpot::with('product', 'page.leaflets')
            ->whereHas('page.leaflets', function ($query) use ($leaflet) {
                $query->where('leaflets.id', $leaflet->id);
            })
            ->get()
            ->map(function ($item) {
                // Załadowanie pierwszego leaflet z relacji
                $leaflet = $item->page->leaflets->first();

                // Jeśli nie ma żadnego leaflet, pomijamy ten element
                if (!$leaflet) {
                    return null;
                }

                return [
                    'page' => $leaflet->pivot->sort_order,  // sort_order z tabeli pivot
                    'page_id' => $item->page_id,
                    'product_id' => $item->product_id,  // ID produktu
                    'status' => $item->status,
                    'priority' => $item->priority,
                    'image' => $item->image,
                    'price' => $item->price,
                    'promo_price' => $item->promo_price,
                    'url' => $item->url,
                    'x' => $item->x,
                    'y' => $item->y,
                    'width' => $item->width,
                    'height' => $item->height,
                    'image_width' => $item->image_width,
                    'image_height' => $item->image_height,
                    'valid_from' => $item->valid_from,
                    'valid_to' => $item->valid_to,
                ];
            })
            ->filter();  // Filtrujemy, aby usunąć puste wartości (gdy brak leaflet)


        return response()->json($hotspots);
    }

    public function updateHotspot(Request $request, Leaflet $leaflet)
    {

        $validated = $request->validate([
            'id' => 'required|exists:hot_spots,id',
            'product_id' => 'required|exists:products,id',
            'page_id' => 'required|exists:pages,id',
            'status' => 'required|in:visible,hidden',
            'priority' => 'required|in:low,medium,high',
            'price' => 'nullable|numeric',
            'promo_price' => 'nullable|numeric',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date',
            'url' => 'nullable|url',
            'x' => 'nullable|numeric',
            'y' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'image_width' => 'nullable|numeric',
            'image_height' => 'nullable|numeric',
            'image' => 'nullable|string'
        ]);


        $baseUrl = config('affmanager.production.programms.'.$leaflet->shop_id.'.link');

        if (!empty($validated['url']) && !str_starts_with($validated['url'], $baseUrl)) {
            $validated['url'] = $baseUrl . urlencode($validated['url']);
        }


        $validated['price'] = $validated['price'] ?: 0;
        $validated['promo_price'] = $validated['promo_price'] ?: 0;
        $hotSpot = HotSpot::where('id', $validated['id'])->first();

        if (($hotSpot->x != $validated['x']) || ($hotSpot->y != $validated['y']) || ($hotSpot->width != $validated['width']) || ($hotSpot->height != $validated['height']))
        {
            if ( Storage::disk('public')->exists($hotSpot->image . '.webp'))
            {
                Storage::disk('public')->delete([$hotSpot->image . '.webp', $hotSpot->image . '.avif', $hotSpot->image . '.jpg']);
            }

            $pathWithoutExtension = 'images/hotspots/offer/' . uniqid();

            $imagePath = public_path('storage/' . $validated['image'].'.webp');
//        dd($imagePath);
            $result = app(ImageService::class)->cropAndStore(
                $imagePath,
                $pathWithoutExtension,
                $validated['x'] * $validated['image_width'] / 100,
                $validated['y'] * $validated['image_height'] / 100,
                $validated['width']  * $validated['image_width'] / 100,
                $validated['height']  * $validated['image_height'] / 100,
                $validated['image_width'],
                $validated['image_height']);

            if($result['path']){
                $validated['image'] = $result['path'];
                Log::debug('Aktualizacja ścieżki image', [
                    'product_id' => $result['path'],

                ]);

            }

        } else {
            $validated['image'] = $hotSpot->image;
        }



        $hotSpot->update($validated);

        $product = Product::where('id', $validated['product_id'])->first();

        Log::debug("Porównuję obrazy: '{$product->image}' vs '{$validated['image']}'");
        Log::debug("Sprawdzam str_contains: " . (str_contains($product->image, 'images/hotspots') ? 'True' : 'False'));

        if(empty($product->image) || (str_contains($product->image, 'images/hotspots') && (trim($product->image) != trim($validated['image']))))
        {

            $product->update([
                'image' => $validated['image'],
            ]);

            Log::debug('Aktualizacja bazy', [
                'product_id' => $product->id,
                'image' =>  $product->image
            ]);
        }


        return redirect()->back()->with('success', 'Produkt zaktualizowany');


    }

    public function fetchProductData(Request $request, ScraperService $scraper)
    {
        $url = $request->input('url');
        $data = $scraper->scrape($url);

        if (!$data) {
            return response()->json(['error' => 'Nie udało się pobrać danych.'], 422);
        }

        return response()->json($data);
    }


    public function deleteHotSpot(Leaflet $leaflet, HotSpot $hotSpot)
    {

        $hotSpot = HotSpot::with('product')->where('id', $hotSpot->id)->first();
        // Usuwamy rekord HotSpot (łączy produkt ze stroną)

        if ($hotSpot->image)
        {
            $image_count = Product::where('image', $hotSpot->image)->count();

            if ( Storage::disk('public')->exists($hotSpot->image . '.webp') && $image_count == 0)
            {
                Storage::disk('public')->delete([$hotSpot->image . '.webp', $hotSpot->image . '.avif', $hotSpot->image . '.jpg']);
            }
        }

        // Usuwamy rekord HotSpot (łączy produkt ze stroną)
        $hotSpot->delete();

        return redirect()->back()->with('success', 'Produkt został usunięty ze strony.');
    }


    public function deletePage(Leaflet $leaflet, $page)
    {

        $hotSpots = HotSpot::with('product')->where('page_id', $page)->get();
        // Usuwamy rekord HotSpot (łączy produkt ze stroną)

        foreach ($hotSpots as $hotSpot) {

            if ($hotSpot->image)
            {
                $image_count = Product::where('image', $hotSpot->image)->count();

                if ( Storage::disk('public')->exists($hotSpot->image . '.webp') && $image_count == 0)
                {
                    Storage::disk('public')->delete([$hotSpot->image . '.webp', $hotSpot->image . '.avif', $hotSpot->image . '.jpg']);
                }
            }

            // Usuwamy rekord HotSpot (łączy produkt ze stroną)
            $hotSpot->delete();

        }

        return redirect()->back()->with('success', 'Produkty zostały usunięte ze strony.');
    }



    public function delete(Leaflet $leaflet)
    {

        $hotSpots = HotSpot::with('product', 'page', 'page.leaflets')
            ->whereHas('page.leaflets', function ($query) use ($leaflet) {
                $query->where('leaflets.id', $leaflet->id);
            })->get();


        foreach ($hotSpots as $hotSpot) {

            if ($hotSpot->image)
            {
                $image_count = Product::where('image', $hotSpot->image)->count();

                if ( Storage::disk('public')->exists($hotSpot->image . '.webp') && $image_count == 0)
                {
                    Storage::disk('public')->delete([$hotSpot->image . '.webp', $hotSpot->image . '.avif', $hotSpot->image . '.jpg']);
                }
            }

            // Usuwamy rekord HotSpot (łączy produkt ze stroną)
            $hotSpot->delete();

        }

        return redirect()->back()->with('success', 'Produkty zostały usunięte ze strony.');
    }

    protected function importFormatOne(array $data, Leaflet $leaflet)
    {
        // Format 1 import
        foreach ($data as $page => $items) {
            // Znalezienie id strony w tabeli pośredniczącej 'leaflet_page' na podstawie numeru strony (page)
            $pageId = DB::table('leaflet_page')
                ->where('leaflet_id', $leaflet->id)
                ->where('sort_order', $page) // Numer strony
                ->value('page_id');

            foreach ($items as $productOldId) {
                $product = Product::where('old_id', $productOldId)
                    ->where('status', 1)
                    ->first();

                if ($product) {
                    HotSpot::firstOrCreate(
                        [
                            'page_id' => $pageId,
                            'product_id' => $product->id
                        ],
                        [
                            'status' => 'hidden',
                            'priority' => 'low',
                            'valid_from' => $leaflet->valid_from,
                            'valid_to' => $leaflet->valid_to,
                            'x' => 50,
                            'y' => 50,
                            'width' => 50,
                            'height' => 50,
                        ]
                    );

                }
            }
        }
    }

    protected function importFormatTwo(array $data, Leaflet $leaflet)
    {
        // Format 2 import
        foreach ($data as $item) {

            // Znalezienie produktu na podstawie jego ID
            $product = Product::where('id', $item['product_id'])
                ->where('status', 1)  // Tylko aktywne produkty
                ->first();

            // Jeśli produkt istnieje, tworzymy HotSpot i LeafletProduct
            if ($product) {

                $pageId = DB::table('leaflet_page')
                    ->where('leaflet_id', $leaflet->id)
                    ->where('sort_order', $item['page']) // odpowiada "page": 1
                    ->value('page_id');


                // Tworzymy lub aktualizujemy HotSpot
                HotSpot::updateOrCreate(
                    [
                        'page_id' => $pageId,
                        'product_id' => $product->id
                    ],
                    [
                        'status' => $item['status'],
                        'priority' => $item['priority'],
                        'valid_from' => $item['valid_from'],
                        'valid_to' => $item['valid_to'],
                        'price' => $item['price'],
                        'promo_price' => $item['promo_price'],
                        'url' => $item['url'],
                        'x' => $item['x'],
                        'y' => $item['y'],
                        'width' => $item['width'],
                        'height' => $item['height'],
                        'image_width' => $item['image_width'],
                        'image_height' => $item['image_height'],
                        'image' => $item['image']  // Zapisz ścieżkę obrazu
                    ]
                );

            }

        }
    }

}
