<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ProductDescription;
use App\Services\TextServices;
use App\Services\WritesonicService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateDescriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;

    }

    public function handle(WritesonicService $writesonicService, TextServices $textServices): void
    {
        try {
            $name = $this->product->name;
            $message = "Napisz krótki opis produktu \"{$name}\" (max 70 słów), zawrzyj informacje o zastosowaniu i promocji.";

            $payload = [
                'tone_of_voice' => 'professional',
                'product_name' => $name,
                'product_characteristics' => $message,
                'primary_keyword' => $name,
            ];

            $data = $writesonicService->generateProductDescription($payload);

            if (!empty($data[0]['text'])) {
                ProductDescription::updateOrCreate(
                    ['product_id' => $this->product->id, 'shop_id' => null],
                    ['excerpt' => $textServices->shorten($data[0]['text'])]
                );
                Log::info("Otrzymano opis i dodano do bazy danych {$name}");
            }



        } catch (\Throwable $e) {
            Log::error("Writesonic job failed for product ID {$this->product->id}: " . $e->getMessage());
        }
    }
}
