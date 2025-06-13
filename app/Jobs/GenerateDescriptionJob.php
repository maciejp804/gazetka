<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ProductDescription;
use GuzzleHttp\Client;
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

    public function handle(): void
    {
        try {
            $name = $this->product->name;
            $message = "Napisz krótki opis produktu \"{$name}\" (max 70 słów), zawrzyj informacje o zastosowaniu i promocji.";

            $client = new Client();
            $payload = [
                'tone_of_voice' => 'professional',
                'product_name' => $name,
                'product_characteristics' => $message,
                'primary_keyword' => $name,
            ];

            $response = $client->post('https://api.writesonic.com/v2/business/content/product-descriptions?engine=premium&language=pl&num_copies=1', [
                'json' => $payload,
                'headers' => [
                    'X-API-KEY' => config('services.writesonic.token'),
                    'accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!empty($data[0]['text'])) {
                ProductDescription::updateOrCreate(
                    ['product_id' => $this->product->id, 'shop_id' => null],
                    ['excerpt' => $this->shorten($data[0]['text'])]
                );

            }

        } catch (\Throwable $e) {
            Log::error("Writesonic job failed for product ID {$this->product->id}: " . $e->getMessage());
        }
    }

    protected function shorten(string $text, int $maxWords = 80): string
    {
        // Usuń nadmiarowe białe znaki
        $text = trim(preg_replace('/\s+/', ' ', $text));

        // Podziel na zdania
        $sentences = preg_split('/(?<=[.!?])\s+/', $text);

        $shortText = '';
        $wordCount = 0;

        foreach ($sentences as $sentence) {
            $wordsInSentence = str_word_count($sentence);

            if (($wordCount + $wordsInSentence) > $maxWords) {
                break;
            }

            $shortText .= $sentence . ' ';
            $wordCount += $wordsInSentence;
        }

        return trim($shortText);
    }
}
