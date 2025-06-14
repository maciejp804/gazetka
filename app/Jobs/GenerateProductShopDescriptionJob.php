<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\Shop;
use App\Services\TextServices;
use App\Services\WritesonicService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateProductShopDescriptionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    protected Product $product;
    protected Shop $shop;

    public function __construct(Product $product, Shop $shop)
    {
        $this->product = $product;
        $this->shop = $shop;
    }

    /**
     * Execute the job.
     */
    public function handle(WritesonicService $writesonicService, TextServices $textServices): void
    {
        try {
            $product_name = $this->product->name;
            $shop_name = $this->shop->name;
            $shop_id = $this->shop->id;

            $message = "Napisz krótki opis produktu \"{$product_name}\" dla sieci handlowej \"{$shop_name}\"(max 70 słów), zawrzyj informacje o zastosowaniu i promocji.";

            $payload = [
                'tone_of_voice' => 'professional',
                'product_name' => $product_name,
                'product_characteristics' => $message,
                'primary_keyword' => $product_name,
            ];

            $data = $writesonicService->generateProductDescription($payload);


            if (!empty($data[0]['text'])) {
                ProductDescription::updateOrCreate(
                    ['product_id' => $this->product->id, 'shop_id' => $shop_id],
                    ['excerpt' => $textServices->shorten($data[0]['text'])]
                );
                Log::info("Otrzymano opis i dodano do bazy danych {$product_name} {$shop_name}");
            }

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
        }
    }
}
