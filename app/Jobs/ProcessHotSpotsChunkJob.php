<?php

namespace App\Jobs;

use App\Models\HotSpot;
use App\Models\Leaflet;
use App\Models\Page;
use App\Models\Product;
use App\Services\ImageService;
use App\Services\Ocr\AbstractOcrService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessHotSpotsChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $chunk;
    protected Leaflet $leaflet;
    protected int $imageWidth;
    protected int $imageHeight;

    public function __construct(array $chunk, Leaflet $leaflet, int $imageWidth, int $imageHeight)
    {
        $this->chunk = $chunk;
        $this->leaflet = $leaflet;
        $this->imageWidth = $imageWidth;
        $this->imageHeight = $imageHeight;
    }

    public function handle(AbstractOcrService $ocrService, ImageService $imageService)
    {
        $existing = [];
        foreach ($this->chunk as $item) {
            // Deduplication by hash
            $hash = md5($item['name'] . '|' . $item['price'] . '|' . $item['pageNumber'] . '|' . $item['brandName']);

            if (isset($existing[$hash])) {
                continue;
            }
            $existing[$hash] = true;

            $merageBlocks = [['text' => $item['name']]];
            [$productDetails, $suggestions] = $ocrService->extractProductDetails($merageBlocks);
            $details = $productDetails[0] ?? null;

            if (!$details || empty($details['product_id'])) {
                continue;
            }

            $details['area']['x'] = (int)($item['area']['topLeftCorner']['x'] * 100);
            $details['area']['y'] = (int)($item['area']['topLeftCorner']['y'] * 100);
            $details['area']['width'] = (int)(($item['area']['bottomRightCorner']['x'] - $item['area']['topLeftCorner']['x']) * 100);
            $details['area']['height'] = (int)(($item['area']['bottomRightCorner']['y'] - $item['area']['topLeftCorner']['y']) * 100);
            $details['price_promo'] = (float) number_format(((int)$item['price']) / 100, 2, '.', '');
            $details['pageNumber'] = $item['pageNumber'] + 1;
            $details['valid_from'] = $item['dateStart']['date'];
            $details['valid_to'] = $item['dateEnd']['date'];

            $product = Product::where('id', $details['product_id'])
                ->where('status', 1)
                ->first();

            if (!$product) {
                continue;
            }

            $pageId = DB::table('leaflet_page')
                ->where('leaflet_id', $this->leaflet->id)
                ->where('sort_order', $details['pageNumber'])
                ->value('page_id');

            $page = Page::find($pageId);
            if (!$page) {
                continue;
            }

            $imagePath = public_path('storage/' . $page->image_path . '.webp');
            $pathWithoutExtension = 'images/hotspots/offer/' . uniqid();

            $result = $imageService->cropAndStore(
                $imagePath,
                $pathWithoutExtension,
                $page->width * $details['area']['x'] / 100,
                $page->height * $details['area']['y'] / 100,
                $page->width * $details['area']['width'] / 100,
                $page->height * $details['area']['height'] / 100,
                $page->width,
                $page->height
            );

            if (!$result['path']) {
                continue;
            }

            HotSpot::create(
                [
                    'page_id' => $pageId,
                    'product_id' => $product->id,
                    'status' => 'hidden',
                    'priority' => 'low',
                    'valid_from' => $details['valid_from'],
                    'valid_to' => $details['valid_to'],
                    'price' => 0.00,
                    'promo_price' => $details['price_promo'],
                    'url' => null,
                    'x' => $details['area']['x'],
                    'y' => $details['area']['y'],
                    'width' => $details['area']['width'],
                    'height' => $details['area']['height'],
                    'image_width' => $this->imageWidth,
                    'image_height' => $this->imageHeight,
                    'image' => $result['path'],
                ]
            );

            if (empty($product->image)) {
                $product->update(['image' => $result['path']]);
            }
        }
    }
}

