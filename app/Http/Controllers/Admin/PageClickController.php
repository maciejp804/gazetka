<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function destroy(Leaflet $leaflet, PageClick $pageClick)
    {
        // Usuwamy rekord PageClick (łączy produkt ze stroną)
        $pageClick->delete();

        // Pobieramy powiązany produkt z tabeli `leaflet_product`
        $leaflet_product = LeafletProduct::with('pageClicks')->find($pageClick->leaflet_product_id);

        // Sprawdzamy, czy produkt nie ma żadnych powiązanych rekordów PageClick
        if ($leaflet_product && $leaflet_product->pageClicks->count() === 0) {
            // Jeśli nie ma powiązań z żadnymi stronami, usuwamy rekord w `leaflet_product`
            $leaflet_product->delete();
        }

        return redirect()->back()->with('success', 'Produkt został usunięty ze strony.');
    }


}
