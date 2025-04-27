<?php
namespace App\Services;

use App\Models\HotSpot;
use App\Models\PageClick;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductService
{
    /**
     * Pobiera produkty z możliwością paginacji lub bez niej.
     *
     * @param string $status Status produktu (np. 'promo').
     * @param string|null $shopSlug Opcjonalny slug sklepu do filtrowania.
     * @param int|null $perPage Ilość produktów na stronę (null = bez paginacji).
     * @return LengthAwarePaginator|Collection
     */
    public function getHotSpots(string $priority = null, $category = null, $subcategory = null, string $shopSlug = null, int $perPage = null)
    {
        $now = now();

        $query = HotSpot::with([
            'page.leaflets.shop',
            'product',  // Powiązanie z produktem
            'page.leaflets' => function ($query) {
                $query->withPivot('sort_order');
            }
        ])
            ->where('valid_from', '<=', $now)
            ->where('valid_to', '>=', $now);

        //Filtorwanie po priority
        if(!is_null($priority)) {
            $query->where('priority', $priority);
        }

        // Filtrowanie po sklepie (slug)
        if (!is_null($shopSlug)) {
            $query->whereHas('page.leaflets.shop', function ($query) use ($shopSlug) {
                $query->where('slug', $shopSlug);
            });
        }

        // Filtrowanie po kategorii
        if (!is_null($category)) {
            $query->whereHas('product.category', function ($query) use ($category) {
                $query->where('id', $category)
                    ->orWhere('parent_id', $category);
            });
        }

        // Filtrowanie po subkategorii
        if (!is_null($subcategory)) {
            $query->whereHas('product.category', function ($query) use ($subcategory) {
                $query->where('category_id', $subcategory);
            });
        }

        // Debugging: Sprawdź, jakie zapytanie jest generowane


        // Paginacja
        if (!is_null($perPage)) {
            $paginatedResults = $query->paginate($perPage);
            $transformedResults = $this->transformHotSpots($paginatedResults->getCollection());

            return new LengthAwarePaginator(
                $transformedResults,
                $paginatedResults->total(),
                $perPage,
                $paginatedResults->currentPage(),
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        // Jeśli paginacja nie jest ustawiona
        return $this->transformHotSpots($query->get());
    }



    /**
     * Przetwarza dane produktów do spłaszczonej formy.
     *
     * @param Collection $products Kolekcja produktów do przetworzenia.
     * @return Collection
     */
    private function transformHotSpots(Collection $hotSpots): Collection
    {
        return $hotSpots->map(function ($hotSpot) {
            return $hotSpot->page->leaflets->map(function ($leaflet) use ($hotSpot) {
                return [
                    'hotspot_id'     => $hotSpot->id,
                    'valid_from'     => $hotSpot->valid_from,
                    'valid_to'       => $hotSpot->valid_to,
                    'page_id'        => $hotSpot->page->id,
                    'page_image'     => $hotSpot->page->image_path,
                    'page_number'    => optional($leaflet->pivot)->sort_order,
                    'leaflet_id'     => $leaflet->id,
                    'shop_image'     => optional($leaflet->shop)->image,
                    'shop_name'      => optional($leaflet->shop)->name,
                    'shop_slug'      => optional($leaflet->shop)->slug,
                    'product_id'     => optional($hotSpot->product)->id,
                    'product_name'   => optional($hotSpot->product)->name,
                    'product_slug'   => optional($hotSpot->product)->slug,
                    'product_image'  => $hotSpot->image,
                    'price'          => optional($hotSpot)->price,
                    'promo_price'    => optional($hotSpot)->promo_price,
                    'url'            => optional($hotSpot)->url,
                ];
            });
        })->flatten(1);
    }


    public function getProductOccurrences(int $productId): Collection
    {
        return HotSpot::with([
            'page.leaflets.shop',
            'page.leaflets' => function ($query) {
                $query->withPivot('sort_order');
            }
        ])
            ->where('hot_spots.product_id', $productId)
            ->get()
            ->map(function ($hotSpot) {
                $leaflet = $hotSpot->page->leaflets->first(); // jedna gazetka na stronę

                $promo = $hotSpot->promo_price;
                $normal = $hotSpot->price;

                return [
                    'leaflet_id'    => $leaflet?->id,
                    'leaflet_title' => $leaflet?->title,
                    'shop_name'     => $leaflet?->shop?->name,
                    'shop_slug'     => $leaflet?->shop?->slug,
                    'shop_image'    => $leaflet?->shop?->image,
                    'page_id'       => $hotSpot->page_id,
                    'page_number'   => $leaflet?->pivot?->sort_order,
                    'price'         => $normal,
                    'promo_price'   => $promo,
                    'effective_price' => $promo > 0 ? $promo : ($normal > 0 ? $normal : null),
                ];
            })
            ->filter() // usuń null-e
            ->sortBy(function ($item) {
                return $item['effective_price'] ?? PHP_INT_MAX; // brak ceny → na koniec
            })
            ->values(); // resetuje klucze
    }


}
