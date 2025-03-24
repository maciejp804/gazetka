<?php
namespace App\Services;

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
    public function getProducts(string $status = 'promo', $category = null, $subcategory = null, string $shopSlug = null, int $perPage = null)
    {
        $now = now();

        $query = PageClick::with([
            'page.leaflets.shop',
            'leafletProduct.product',
            'page.leaflets' => function ($query) {
                $query->withPivot('sort_order');
            }
        ])
            ->where('valid_from', '<=', $now)
            ->where('valid_to', '>=', $now)
            ->whereHas('leafletProduct', function ($query) use ($status) {
                $query->where('status', $status);
            });

        if (!is_null($shopSlug)) {
            $query->whereHas('page.leaflets.shop', function ($query) use ($shopSlug) {
                $query->where('slug', $shopSlug);
            });
        }

        if (!is_null($category)) {
            $query->whereHas('leafletProduct.product.category', function ($query) use ($category) {
                $query->where('id', $category)
                    ->orWhere('parent_id', $category);
            });
        }

        if (!is_null($subcategory)) {
            $query->whereHas('leafletProduct.product.category', function ($query) use ($subcategory) {
                $query->where('category_id', $subcategory);
            });
        }

        // Jeśli paginacja jest ustawiona (czyli `$perPage` nie jest `null`), używamy paginacji
        if (!is_null($perPage)) {
            $paginatedResults = $query->paginate($perPage);
            $transformedResults = $this->transformProducts($paginatedResults->getCollection());

            return new LengthAwarePaginator(
                $transformedResults,
                $paginatedResults->total(),
                $perPage,
                $paginatedResults->currentPage(),
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        // Jeśli paginacja nie jest ustawiona, pobieramy wszystko bez paginacji
        return $this->transformProducts($query->get());
    }

    /**
     * Przetwarza dane produktów do spłaszczonej formy.
     *
     * @param Collection $products Kolekcja produktów do przetworzenia.
     * @return Collection
     */
    private function transformProducts(Collection $products): Collection
    {
        return $products->map(function ($click) {
            return $click->page->leaflets->map(function ($leaflet) use ($click) {
                return [
                    'click_id'      => $click->id,
                    'valid_from'    => $click->valid_from,
                    'valid_to'      => $click->valid_to,
                    'page_id'       => $click->page->id,
                    'page_image'    => $click->page->image_path,
                    'page_number'   => optional($leaflet->pivot)->sort_order,
                    'leaflet_id'    => $leaflet->id,
                    'shop_image'    => optional($leaflet->shop)->image,
                    'shop_name'     => optional($leaflet->shop)->name,
                    'shop_slug'     => optional($leaflet->shop)->slug,
                    'product_id'    => optional($click->leafletProduct->product)->id,
                    'product_name'  => optional($click->leafletProduct->product)->name,
                    'product_slug'  => optional($click->leafletProduct->product)->slug,
                    'product_image' => optional($click->leafletProduct->product)->image,
                    'price'         => optional($click->leafletProduct)->price,
                    'promo_price'   => optional($click->leafletProduct)->promo_price
                ];
            });
        })->flatten(1);
    }

    public function getProductOccurrences(int $productId): Collection
    {
        return PageClick::with([
            'page.leaflets.shop',
            'leafletProduct' => function ($query) use ($productId) {
                $query->where('product_id', $productId);
            },
            'leafletProduct.product',
            'page.leaflets' => function ($query) {
                $query->withPivot('sort_order');
            }
        ])
            ->whereHas('leafletProduct', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->get()
            ->map(function ($click) {
                $leaflet = $click->page->leaflets->first(); // jedna gazetka na stronę

                $promo = $click->leafletProduct?->promo_price;
                $normal = $click->leafletProduct?->price;

                return [
                    'leaflet_id'    => $leaflet?->id,
                    'leaflet_title' => $leaflet?->title,
                    'shop_name'     => $leaflet?->shop?->name,
                    'shop_slug'     => $leaflet?->shop?->slug,
                    'shop_image'    => $leaflet?->shop?->image,
                    'page_id'       => $click->page_id,
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
