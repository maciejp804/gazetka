<?php

namespace App\Console\Commands;

use App\Models\Lemma;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class LemmaDictionary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lemma-dictionary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::select('name')->get();
        $allWords = [];
        foreach ($products as $product) {
            $words = preg_split('/\s+/', strtolower($product->name));
            foreach ($words as $word) {
                $clean = preg_replace('/[^a-ząćęłńóśźż0-9]/u', '', $word);
                if (mb_strlen($clean, 'UTF-8') > 1) {
                    $allWords[$clean] = true;
                }
            }
        }
        $words = array_keys($allWords);

        $this->info('Znaleziono' . count($words) . 'unikalnych słów...');
        foreach ($words as $word) {
            if(Lemma::where('lemma', $word)->exists()) continue;

            try {
                $response = Http::timeout(5)->post('http://localhost:5000/lemmatize', [
                    'text' => $word,
                ]);
                $lemmas = array_unique($response->json()['lemmas'] ?? []);

                if (empty($lemmas)) {
                    continue;
                }

                // Usuń wszystko po ":" np. "mielone:subst" → "mielone"
                $lemat = explode(':', $lemmas[0])[0] ?? $word;

                Lemma::updateOrInsert([
                    'name' => $word,
                    'lemma' => $lemat,
                ]);

            } catch (\Exception $e) {
                $this->error("❌ {$word}:". $e->getMessage());
            }

        }
        $this->info('✅ Gotowe.');
    }
}
