<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotSpot;
use App\Models\Leaflet;
use App\Models\LeafletProduct;
use App\Models\Page;
use App\Models\PageClick;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class PageClickController extends Controller
{

    public function create(Leaflet $leaflet)
    {

        // Pobranie stron gazetki posortowanych na podstawie sort_order z paginacją (np. 10 stron na stronę)
        $pages = $leaflet->pages()
            ->orderBy('leaflet_page.sort_order')  // Sortowanie na podstawie kolumny sort_order w tabeli pivot
            ->paginate(1);  // Paginacja, 10 stron na stronę



        $products = $leaflet->productsOnPage($pages[0]->id)->get();


        // Pobieramy powiązane page_click (hotspoty) dla strony
        $pageClicks = PageClick::with('page', 'leafletProduct.product')->where('page_id', $pages[0]->id)->get();


        $breadcrumbs = [
            ['label' => 'Panel', 'url' => route('admin.index')],
            ['label' => 'Gazetki', 'url' => route('admin.leaflets.index')],
            ['label' => $leaflet->shop->name.'-'.$leaflet->title, 'url' => '']

        ];
        return view('admin.leaflet.page.edit_order.product.create',[
            'leaflet' => $leaflet,
            'breadcrumbs' => $breadcrumbs,
            'pages' => $pages,
            'products' => $products,
            'pageClicks' => $pageClicks,


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

        // Tworzenie rekordu w tabeli PageClick
        PageClick::create([
            'page_id' => $validated['page_id'],
            'leaflet_product_id' => $leafletProduct->id,
            'status' => 'hidden',
            'valid_from' => $leaflet->valid_from,
            'valid_to' => $leaflet->valid_to,
            'url' => ' ',
            'x' => 10,
            'y' => 10,
            'width' => 10,
            'height' => 10,
        ]);

        return redirect()->back()->with('success', 'Produkt dodany');
    }

    public function destroy(Leaflet $leaflet, HotSpot $hotSpot)
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



}
