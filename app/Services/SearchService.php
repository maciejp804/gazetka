<?php
namespace App\Services;

use App\Models\HotSpot;
use App\Models\PageClick;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SearchService
{
    /**
     * Wyszukuje produkty po nazwie i kategoriach.
     */
    public function searchProducts($query, $category = 'all', $subcategory = 'all', $time = null, $perPage = 10, $page = 1)
    {
        // Tworzymy bazowe zapytanie
        $products = HotSpot::with('product')
            ->where('valid_from', '<=', now())
            ->where('valid_to', '>=', now())
            ->whereHas('product', function ($queryName) use ($query) {
                $queryName->where('name', 'like', $query . '%');
            });

        // Filtrowanie według kategorii i podkategorii
        if ($category !== 'all') {
            $products = $products->whereHas('product.category', function ($queryCategory) use ($category, $subcategory) {
                if ($subcategory !== 'all') {
                    $queryCategory->where('id', $subcategory);
                } else {
                    $queryCategory->where('id', $category)
                        ->orWhere('parent_id', $category);
                }
            });
        }

        // Sortowanie wyników
        $products = $this->applySorting($products, $time);

        // Paginacja i przekształcanie wyników
        return $this->paginateResults($products, $perPage, $page);
    }

    /**
     * Sortowanie wyników wyszukiwania na podstawie parametrów.
     */
    private function applySorting(Builder $query, mixed $time): Builder
    {
        switch ($time) {
            case '1':
                return $query->orderBy('promo_price', 'asc');
            case '2':
                return $query->orderBy('promo_price', 'desc');
            case '3':
                return $query->where('valid_from', '<=', now('Europe/Warsaw'))
                    ->orderBy('valid_to', 'asc');
            case '4':
                return $query->where('valid_from', '>', now('Europe/Warsaw'))
                    ->orderBy('valid_from', 'desc');
            case '5':
                return $query->where('valid_from', '<=', now('Europe/Warsaw'))
                    ->orderBy('valid_from', 'desc');
            default:
                return $query->orderBy('updated_at', 'desc');
        }
    }

    /**
     * Paginacja i transformacja wyników wyszukiwania.
     */
    private function paginateResults(Builder $query, int $perPage, int $page): LengthAwarePaginator
    {
        // Pobieramy paginowane wyniki
        $results = $query->paginate($perPage, ['*'], 'page', $page);

        // Przekształcamy wyniki na spłaszczoną kolekcję
        $transformedResults = $this->transformProducts($results->getCollection());

        // Tworzymy nowy paginator z przekształconymi danymi
        return new LengthAwarePaginator(
            $transformedResults,
            $results->total(),
            $perPage,
            $results->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    /**
     * Transformacja wyników do uproszczonej struktury.
     */
    private function transformProducts(Collection $products): Collection
    {
        return $products->flatMap(function ($hotSpot) {
            return $hotSpot->page->leaflets->map(function ($leaflet) use ($hotSpot) {
                return [
                    'click_id'      => $hotSpot->id,
                    'valid_from'    => $hotSpot->valid_from,
                    'valid_to'      => $hotSpot->valid_to,
                    'page_id'       => $hotSpot->page->id,
                    'page_image'    => $hotSpot->page->image_path,
                    'page_number'   => optional($leaflet->pivot)->sort_order,
                    'leaflet_id'    => $leaflet->id,
                    'shop_image'    => optional($leaflet->shop)->image,
                    'shop_name'     => optional($leaflet->shop)->name,
                    'shop_slug'     => optional($leaflet->shop)->slug,
                    'product_id'    => optional($hotSpot->product)->id,
                    'product_name'  => optional($hotSpot->product)->name,
                    'product_slug'  => optional($hotSpot->product)->slug,
                    'product_image' => optional($hotSpot->product)->image,
                    'price'         => optional($hotSpot)->price,
                    'promo_price'   => optional($hotSpot)->promo_price,
                    'url'           => optional($hotSpot)->url,
                ];
            });
        });
    }
}
