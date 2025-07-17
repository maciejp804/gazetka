<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class GenerateLemmaWeights extends Command
{
    protected $signature = 'product:generate-weights';
    protected $description = 'Generate lemma weights, bigrams, and trigrams for products';

    public function handle()
    {
        $this->info("Generating lemma weights for products...");

        Product::chunk(100, function ($products) {
            foreach ($products as $product) {
                if (!$product->lemmat) continue;

                $lemmas = explode(' ', trim($product->lemmat));
                $lemmas = $this->filterLemmas($lemmas);

                if (empty($lemmas)) {
                    $product->lemmat = null;
                    $product->lemma_weights = null;
                    $product->lemma_bigrams = null;
                    $product->lemma_trigrams = null;
                    $product->save();
                    continue;
                }

                // Update filtered lemma string
                $product->lemmat = implode(' ', $lemmas);

                $lemmaWeights = $this->generateLemmaWeights($lemmas);
                $bigramWeights = $this->generateNgramWeights($lemmaWeights, 2);
                $trigramWeights = $this->generateNgramWeights($lemmaWeights, 3);

                $product->lemma_weights = json_encode($lemmaWeights, JSON_UNESCAPED_UNICODE);
                $product->lemma_bigrams = json_encode($bigramWeights, JSON_UNESCAPED_UNICODE);
                $product->lemma_trigrams = json_encode($trigramWeights, JSON_UNESCAPED_UNICODE);

                $product->save();

                $this->line("Updated: {$product->id} - {$product->name}");
            }
        });

        $this->info("Done.");
    }

    private function filterLemmas(array $lemmas): array
    {
        $stopwords = ['z', 'do', 'na', 'od', 'i', 'w', 'ze', 'pod', 'za', 'po', 'u', 'o'];

        return array_values(array_filter($lemmas, function ($lemma) use ($stopwords) {
            $lemma = trim($lemma);
            return mb_strlen($lemma) >= 3 && !preg_match('/^\d+$/', $lemma) && !in_array($lemma, $stopwords);
        }));
    }

    private function generateLemmaWeights(array $lemmas): array
    {
        $count = count($lemmas);
        if ($count === 0) return [];

        $baseWeights = range($count, 1);
        $sum = array_sum($baseWeights);

        $normalized = array_map(function ($w) use ($sum) {
            return round(($w / $sum) * 10, 2);
        }, $baseWeights);

        return array_combine($lemmas, $normalized);
    }

    private function generateNgramWeights(array $lemmaWeights, int $n): array
    {
        $lemmas = array_keys($lemmaWeights);
        $ngrams = [];

        for ($i = 0; $i <= count($lemmas) - $n; $i++) {
            $ngram = array_slice($lemmas, $i, $n);
            $weight = array_sum(array_map(fn($l) => $lemmaWeights[$l] ?? 0, $ngram));
            $forward = implode(' ', $ngram);
            $ngrams[$forward] = round($weight, 2);

            // Add reversed version with lower weight (0.8x)
            $reversed = implode(' ', array_reverse($ngram));
            if (!isset($ngrams[$reversed])) {
                $ngrams[$reversed] = round($weight * 0.8, 2);
            }
        }

        return $ngrams;
    }
}
