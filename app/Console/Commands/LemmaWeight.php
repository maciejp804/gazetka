<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\LemmaWeight as LemmaWeightModel;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Console\Command;

class LemmaWeight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lemma-weight';

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

        $allProducts = Product::count();

        $wordDf = [];

        Product::select('lemmat')->chunk(100, function ($products) use (&$wordDf) {
            foreach ($products as $product) {
                $words = array_unique(explode(' ', $product->lemmat));
                foreach ($words as $word) {
                    if (!in_array($word, config('stopwords'))) {
                        $wordDf[$word] = ($wordDf[$word] ?? 0) + 1;
                    }
                }
            }
        });

        // Teraz zapis do bazy
        foreach ($wordDf as $word => $df) {
            $idf = log($allProducts / $df, 10);

            LemmaWeightModel::updateOrCreate(
                ['word' => $word],
                ['df' => $df, 'idf' => $idf]
            );
        }

    }
}
