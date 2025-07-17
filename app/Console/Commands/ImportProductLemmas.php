<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Lemma;
use App\Models\Unigram;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProductLemmas extends Command
{
    protected $signature = 'import:product-lemmas';
    protected $description = 'Importuje lematy i wagi z produktów do tabeli unigrams oraz aktualizuje kolumnę products.unigram';

    public function handle(): void
    {
        $this->info('Rozpoczynam import...');

        Product::chunk(100, function ($products) {
            foreach ($products as $product) {
                $rawWeights = json_decode($product->lemma_weights, true);
                if (!$rawWeights || !is_array($rawWeights)) {
                    continue;
                }

                $unigrams = [];
                DB::transaction(function () use ($rawWeights, $product, &$unigrams) {
                    Unigram::where('product_id', $product->id)->delete();

                    foreach ($rawWeights as $lemmaText => $weight) {
                        $lemma = Lemma::firstOrCreate(['name' => $lemmaText], ['lemma' => $lemmaText]);

                        Unigram::create([
                            'product_id' => $product->id,
                            'lemma_id' => $lemma->id,
                            'weight' => $weight,
                            'type' => 'unigram',
                        ]);

                        $unigrams[] = $lemmaText;
                    }

                });

                $this->info("Zaktualizowano produkt ID: {$product->id} ({$product->name})");
            }
        });

        $this->info('Import zakończony.');
    }
}
