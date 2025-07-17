<?php

namespace App\Jobs;

use App\Models\HotSpot;
use App\Models\Leaflet;
use App\Models\Page;
use App\Models\Product;
use App\Models\LeafletProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportHotspotsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $leafletId;
    protected int $page;
    protected string $url;

    public function __construct(int $leafletId, int $page, string $url)
    {
        $this->leafletId = $leafletId;
        $this->page = $page;
        $this->url = $url;
    }

    public function handle(): void
    {


        $page = Page::with('leaflets')
            ->whereHas('leaflets', function ($query) {
                $query->where('leaflet_id', $this->leafletId)
                ->where('sort_order', $this->page);
            })
            ->first();

        if (!$page) {
            Log::warning('Nie znaleziono powiązanej strony dla leafletId ' . $this->leafletId . ' i page ' . $this->page);
            return;
        }

        $response = Http::timeout(15)->get($this->url);


        if (!$response->ok()) {
            Log::error("Błąd podczas pobierania JSON: " . $response->status(), ['url' => $this->url]);
            return;
        }

        $data = $response->json();

        if (!isset($data['hotspots'])) {
            Log::warning("Brak danych hotspotów w JSON", ['url' => $this->url]);
            return;
        }

        foreach ($data['hotspots'] as $hotspot) {
            foreach ($hotspot['products'] as $prod) {
                $title = $prod['title'];
                $brand = $prod['brand'] ?? null;
                $price = $prod['price'] ?? null;
                $promo_proce = $prod['discountedPrice'] ?? $prod['price'];
                $url = $prod['webshopUrl'] ?? null;

                // Przypisanie produktu na podstawie podobieństwa nazw
                $product = Product::all()->sortByDesc(function ($item) use ($title) {
                    similar_text(strtolower($item->name), strtolower($title), $percent);
                    return $percent;
                })->first(function ($item) use ($title) {
                    similar_text(strtolower($item->name), strtolower($title), $percent);
                    return $percent > 60; // próg podobieństwa
                });

                HotSpot::create([
                    'page_id' => $page->id,
                    'product_id' => $product?->id,
                    'name' => $title,
                    'brand' => $brand,
                    'price' => $price,
                    'promo_price' => $promo_proce,
                    'url' => $url,
                    'x' => $hotspot['position']['left'] * 100,
                    'y' => $hotspot['position']['top'] * 100,
                    'width' => $hotspot['position']['width']* 100,
                    'height' => $hotspot['position']['height']* 100,
                    'image_width' => $page->width,
                    'image_height' => $page->height,
                ]);
            }
        }

        Log::info("Import hotspotów zakończony", [
            'leaflet_id' => $this->leafletId,
            'page' => $this->page,
            'url' => $this->url
        ]);
    }
}
