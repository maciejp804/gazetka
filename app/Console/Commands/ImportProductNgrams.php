<?php

namespace App\Console\Commands;

use App\Models\Ngram;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProductNgrams extends Command
{
    protected $signature = 'import:ngrams';
    protected $description = 'Import bigrams and trigrams from products table to ngrams table';

    public function handle(): void
    {
        $this->info('Starting import of ngrams...');

        $products = Product::query()
            ->whereNotNull('lemma_bigrams')
            ->orWhereNotNull('lemma_trigrams')
            ->get();

        foreach ($products as $product) {
            DB::transaction(function () use ($product) {
                // Usuń stare ngramy
                Ngram::where('product_id', $product->id)->delete();

                // Bigrams
                $bigrams = json_decode($product->lemma_bigrams, true) ?? [];
                foreach ($bigrams as $phrase => $weight) {
                    Ngram::create([
                        'product_id' => $product->id,
                        'ngram' => $phrase,
                        'type' => 'bigram',
                        'weight' => $weight,
                    ]);
                }

                // Trigrams
                $trigrams = json_decode($product->lemma_trigrams, true) ?? [];
                foreach ($trigrams as $phrase => $weight) {
                    Ngram::create([
                        'product_id' => $product->id,
                        'ngram' => $phrase,
                        'type' => 'trigram',
                        'weight' => $weight,
                    ]);
                }
            });

            $this->info("Processed product #{$product->id}");
        }

        $this->info('Import completed.');
    }
}
