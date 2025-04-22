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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;

class HotSpotController extends Controller
{
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
            ['label' => $leaflet->shop->name.'-'.$leaflet->title, 'url' => '']

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

        $leafletProduct = LeafletProduct::where('leaflet_id', $request->leaflet_id)->where('product_id', $request->product_id)->first();

        if (!$leafletProduct) {
            $leafletProduct =LeafletProduct::create([
                'leaflet_id' => $validated['leaflet_id'],
                'product_id' => $validated['product_id'],
                'status' => 'normal',
                'price' => $request->input('price', 0),
                'promo_price' => $request->input('promo_price', 0),
            ]);
        }

        // Tworzenie rekordu w tabeli HotSpot
        HotSpot::create([
            'page_id' => $validated['page_id'],
            'product_id' => $validated['product_id'],
            'status' => 'hidden',
            'priority' => 'low',
            'valid_from' => $leaflet->valid_from,
            'valid_to' => $leaflet->valid_to,
            'url' => ' ',
            'x' => 10,
            'y' => 10,
            'width' => 10,
            'height' => 10,
            'price' => $request->input('price', 0),
            'promo_price' => $request->input('promo_price', 0),
        ]);




        return redirect()->back()->with('success', 'Produkt dodany');
    }

    public function updateHotspot(Request $request)
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
                $validated['x'],
                $validated['y'],
                $validated['width'],
                $validated['height'],
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

    public function deleteHotSpot(Leaflet $leaflet, HotSpot $hotSpot)
    {

        // Usuwamy rekord HotSpot (łączy produkt ze stroną)
        $hotSpot->delete();

        // Sprawdzamy, czy produkt nie jest już przypisany do tej strony
        $hotSpotInPage = HotSpot::where('page_id', $hotSpot->page_id)
            ->where('product_id', $hotSpot->product_id)
            ->first();  // Pobieramy pierwszy rekord (jeśli istnieje)

        // Sprawdzamy, czy produkt nie jest już przypisany do żadnej strony
        $leaflet_product = LeafletProduct::where('leaflet_id', $leaflet->id)
            ->where('product_id', $hotSpot->product_id)
            ->first();  // Pobieramy pierwszy rekord (jeśli istnieje)

        // Jeśli nie ma żadnych innych HotSpotów dla tej strony i produktu, usuwamy rekord w `leaflet_product`
        if (empty($hotSpotInPage) && !empty($leaflet_product)) {
            $leaflet_product->delete(); // Usuwamy powiązanie z gazetką
        }

        return redirect()->back()->with('success', 'Produkt został usunięty ze strony.');
    }


    public function deletePage(Leaflet $leaflet, $page)
    {

        $hotSpots = HotSpot::with('product')->where('page_id', $page)->get();
        // Usuwamy rekord HotSpot (łączy produkt ze stroną)

        foreach ($hotSpots as $hotSpot) {

            // Usuwamy rekord HotSpot (łączy produkt ze stroną)
            $hotSpot->delete();

            // Sprawdzamy, czy produkt nie jest już przypisany do tej strony
            $hotSpotInPage = HotSpot::where('page_id', $hotSpot->page_id)
                ->where('product_id', $hotSpot->product_id)
                ->first();  // Pobieramy pierwszy rekord (jeśli istnieje)

            // Sprawdzamy, czy produkt nie jest już przypisany do żadnej strony
            $leaflet_product = LeafletProduct::where('leaflet_id', $leaflet->id)
                ->where('product_id', $hotSpot->product_id)
                ->first();  // Pobieramy pierwszy rekord (jeśli istnieje)

            // Jeśli nie ma żadnych innych HotSpotów dla tej strony i produktu, usuwamy rekord w `leaflet_product`
            if (empty($hotSpotInPage) && !empty($leaflet_product)) {
                $leaflet_product->delete(); // Usuwamy powiązanie z gazetką
            }

        }

        return redirect()->back()->with('success', 'Produkt został usunięty ze strony.');
    }

}
