<?php
namespace App\Services;

use App\Models\HotSpot;
use App\Models\Lemma;
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
    public function getHotSpots(string $priority = null, $category = null, $subcategory = null, string $shopSlug = null, int $perPage = null, int $limit = null)
    {
        $now = now();

        $query = HotSpot::with([
            'page.leaflets.shop',
            'product',  // Powiązanie z produktem
            'page.leaflets' => function ($query) {
                $query->withPivot('sort_order');
            }
        ])
            ->where('valid_to', '>=', $now)
            ->whereHas('product', function ($query) {
            $query->where('status', 1);
        });

        // Filtrowanie po priorytecie (powyżej zadanego priorytetu)
        if (!is_null($priority)) {
            $priorityLevels = ['low', 'medium', 'high'];  // Lista priorytetów w kolejności rosnącej

            // Sprawdzamy, gdzie znajduje się dany priorytet w tablicy
            $priorityIndex = array_search($priority, $priorityLevels);

            if ($priorityIndex !== false) {
                // Pobieramy wszystkie wartości od zadanego priorytetu do końca tablicy
                $higherPriorities = array_slice($priorityLevels, $priorityIndex);

                // Filtrowanie po priorytetach, które są powyżej lub równe zadanemu
                $query->whereIn('priority', $higherPriorities);
            }
        }

        // Sortowanie po priorytecie
        $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");

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

        // Jeśli limit jest ustawiony, stosujemy limit
        if (!is_null($limit)) {
            $query->limit($limit);
        }

        // Jeśli paginacja ani limit nie są ustawione, zwróć wszystkie wyniki
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
                    'leaflet_valid_from' => date('Y-m-d', strtotime($leaflet->valid_from)),
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
                    'leaflet_valid_from' => date('Y-m-d', strtotime($leaflet->valid_from)),
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

    public function productInLeaflet($product, $shop)
    {
        return HotSpot::with('product', 'page', 'page.leaflets.shop')
            ->where('hot_spots.valid_to', '>=', now('Europe/Warsaw')->toDateString())
            ->where('hot_spots.product_id', $product->id)
            ->get()
            ->map(function ($item) use ($shop) {
                $leaflet = $item->page->leaflets->first();
                return [
                    'leaflet_id' => $leaflet->id ?? null,
                    'leaflet_valid_from' => date('Y-m-d', strtotime($leaflet->valid_from)),
                    'name' => $leaflet->shop->name ?? 'Brak sklepu',
                    'slug' => $leaflet->shop->slug ?? 'Brak sklepu',
                    'shop_image' => $leaflet->shop->image ?? 'Brak sklepu',
                    'page_number' => $leaflet->pivot->sort_order ?? null,
                    'page_image' => $item->page->image_path ?? null,
                    'valid_from' => $item->valid_from,
                    'valid_to' => $item->valid_to,
                    'updated_at' => $item->updated_at->format('Y-m-d H:i:s'),
                    'is_in_shop' => $leaflet->shop->id === $shop->id  // Dodajemy flagę informującą, czy jest w tym sklepie
                ];
            });
    }

    function lemmatTextLocal(string $tekst): string
    {
        $words = preg_split('/\s+/', strtolower($tekst));
        $lammas = [];

        foreach ($words as $word) {
            $clear= preg_replace('/[^a-ząćęłńóśźż0-9]/u', '', $word);
            $lemma = Lemma::where('name', $clear)->value('lemma') ?? $clear;
            $lammas[] = $lemma;
        }

        return implode(' ', $lammas);
    }



}
