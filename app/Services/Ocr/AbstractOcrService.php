<?php

namespace App\Services\Ocr;

use App\Models\Brand;
use App\Models\Lemma;
use App\Models\Product;
use App\Services\Ocr\Parsers\AbstractBlockParser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Bazowy adapter OCR dla sieci handlowych
 */
abstract class AbstractOcrService
{
    private array $brandAliases;

    protected AbstractBlockParser $ocrProductBlockParser;


    public function __construct(AbstractBlockParser $ocrProductBlockParser)
    {
        $this->brandAliases = Brand::get()
            ->flatMap(function ($brand) {
                $aliases = json_decode($brand->aliases ?? '[]', true);
                $aliases[] = $brand->name;
                return array_map('mb_strtolower', $aliases);
            })
            ->unique()
            ->values()
            ->toArray();

        $this->ocrProductBlockParser = $ocrProductBlockParser;

    }

    public function extractProductDetails(array $mergedBlocks): array
    {
        if (app()->isLocal()) {
            Log::info('Start OCR extraction: blocks count = ' . count($mergedBlocks));
        }
        set_time_limit(0);

        $products = [];
        $suggestions = [];

        $lemmaIndex = [];
        $productDictionary = Product::with(['unigrams.lemma', 'ngrams', 'brands'])
            ->where('status', 1)
            ->get()
            ->map(function ($product) use (&$lemmaIndex) {
                $weights = $product->unigrams
                    ->mapWithKeys(function ($u) use (&$lemmaIndex, $product) {
                        $lemma = $u->lemma->name;
                        $lemmaIndex[$lemma][] = $product->id;
                        return [$lemma => $u->weight];
                    })->toArray();

                $ngrams = $product->ngrams
                    ->groupBy('type')
                    ->map(fn($group) => $group->mapWithKeys(fn($n) => [$n->ngram => $n->weight])->toArray());

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'lemmatized' => implode(' ', array_keys($weights)),
                    'weights' => $weights,
                    'bigrams' => $ngrams['bigram'] ?? [],
                    'trigrams' => $ngrams['trigram'] ?? [],
                    'brand_ids' => $product->brands->pluck('id')->toArray(),
                ];
            })
            ->keyBy('id');

        if (app()->isLocal()) {
            Log::debug('Product dictionary loaded: ' . $productDictionary->count() . ' entries.');
        }

        foreach ($mergedBlocks as $index => $block) {
            $text = $this->cleanDescription($block['text']);
            $detectedBrandIds = $this->detectBrands($text); // 👈 nowa metoda
            $textWithoutBrands = $this->removeBrandNames($text);
            $textWithoutPhrases = $this->removeNoisePhrases($textWithoutBrands);


            $lemmas = $this->filterLemmas(explode(' ', $this->lemmatizeText($textWithoutPhrases)));
            $bigrams = $this->generateNgrams($lemmas, 2);
            $trigrams = $this->generateNgrams($lemmas, 3);

            if (count($lemmas) === 0) continue;

            $ocrString = implode(' ', $lemmas);
            $candidateIDs = collect($lemmas)
                ->flatMap(fn($lemma) => $lemmaIndex[$lemma] ?? [])
                ->unique();

            if (app()->isLocal()) {
                Log::debug("Block #$index - OCR raw: \"$text\"");
                Log::debug("Block #$index - No phrases: \"$textWithoutPhrases\"");
                Log::debug("Block #$index - No brands: \"$textWithoutBrands\"");
                Log::debug("Block #$index - Lemmas: " . json_encode($lemmas));
                Log::debug("Block #$index - Candidates found: " . $candidateIDs->count());
            }

            $bestMatchProduct = null;
            $bestMatchScore = 0;

            foreach ($candidateIDs as $id) {
                $productData = $productDictionary[$id];
                $productString = $productData['lemmatized'];

                $semanticClasses = config('semantic');
                $detectSemanticClasses = function (string $text, array $semanticClasses): array {
                    $text = mb_strtolower($text);
                    $found = [];

                    foreach ($semanticClasses as $class => $keywords) {
                        foreach ($keywords as $keyword) {
                            if (str_contains($text, $keyword)) {
                                $found[] = $class;
                                break;
                            }
                        }
                    }

                    return array_unique($found);
                };

                $ocrClasses = $detectSemanticClasses($ocrString, $semanticClasses);
                $productClasses = $detectSemanticClasses(mb_strtolower($productData['name']), $semanticClasses);
                $conflict = count(array_intersect($ocrClasses, $productClasses)) === 0 &&
                    count($ocrClasses) > 0 && count($productClasses) > 0;

                $semanticPenalty = $conflict ? 15 : 0;

                if (app()->isLocal() && $conflict) {
                    Log::debug("⚠️ Semantyczny konflikt: OCR=[" . implode(',', $ocrClasses) . "], Produkt=[" . implode(',', $productClasses) . "]");
                }

                $score = strtolower($ocrString) === strtolower($productString) ? 100 : 0;
                if (!$score) {
                    similar_text($ocrString, $productString, $percent);
                    $score = $percent >= 95 ? 100 : 0;
                }

                $ocrNoise = config('noises.words'); // <- tylko dla OCR

                $lemmaScore = collect($lemmas)
                    ->reject(fn($l) => in_array($l, $ocrNoise))
                    ->sum(fn($l) => $productData['weights'][$l] ?? 0);

                $bigramScore = collect($bigrams)
                    ->reject(fn($b) => $this->containsNoise($b))
                    ->sum(fn($b) => $productData['bigrams'][$b] ?? 0);

                $trigramScore = collect($trigrams)
                    ->reject(fn($t) => $this->containsNoise($t))
                    ->sum(fn($t) => $productData['trigrams'][$t] ?? 0);


                $brandScore = 0;
                foreach ($detectedBrandIds as $brandId) {
                    if (in_array($brandId, $productData['brand_ids'])) {
                        $brandScore += 15;
                        break;
                    }
                }


                $totalScore = $score + $lemmaScore + $bigramScore + $trigramScore + $brandScore - $semanticPenalty;

                if (app()->isLocal()) {
                    Log::debug("→ Candidate #$id [{$productData['name']}] → Score: $totalScore (L:$lemmaScore B:$bigramScore T:$trigramScore M:$score Brand:$brandScore)");
                }

                if ($totalScore > $bestMatchScore) {
                    $bestMatchScore = $totalScore;
                    $bestMatchProduct = $productData;
                }
            }

            if ($bestMatchProduct && $bestMatchScore >= 10) {
                if (app()->isLocal()) {
                    Log::info("✅ Match found for block #$index: {$bestMatchProduct['name']} (Score: $bestMatchScore)");
                }

                $parsed = $this->ocrProductBlockParser->parse($block['text']);


                $products[] = [
                    'name' => $bestMatchProduct['name'],
                    'product_id' => $bestMatchProduct['id'],
                    'price_promo' => $parsed['price_promo'] ?? null,
                    'price' => $parsed['price'] ?? null,
                    'unit_price' => $parsed['unit_price'] ?? null,
                    'weight_volume' => $parsed['weight_volume'] ?? null,
                    'unit' => $parsed['unit'] ?? null,
                    'promotion' =>$parsed['promotion'] ?? null,
                    'product_name' => $parsed['product_name'] ?? null,
                    'original_block' => $block,
                    'in_product_db' => 1,
                    'match_confidence' => round($bestMatchScore, 2),
                    'lemmas' => $lemmas,
                    'bigrams' => $bigrams,
                    'trigrams' => $trigrams,
                    'brand' => $detectedBrandIds[0] ?? null,
                ];

            } else {
                if (app()->isLocal()) {
                    Log::warning("⚠️ No strong match found for block #$index (Best score: $bestMatchScore)");
                }

                if ($bestMatchScore >= 7 && app()->isLocal()) {

                    $parsed = $this->ocrProductBlockParser->parse($block['text']);

                    $suggestions[] = [
                        'name' => $bestMatchProduct['name'],
                        'product_id' => $bestMatchProduct['id'],
                        'price_promo' => $parsed['price_promo'] ?? null,
                        'price' => $parsed['price'] ?? null,
                        'unit_price' => $parsed['unit_price'] ?? null,
                        'weight_volume' => $parsed['weight_volume'] ?? null,
                        'unit' => $parsed['unit'] ?? null,
                        'promotion' =>$parsed['promotion'] ?? null,
                        'product_name' => $parsed['product_name'] ?? null,
                        'original_block' => $block,
                        'in_product_db' => 1,
                        'match_confidence' => round($bestMatchScore, 2),
                        'lemmas' => $lemmas,
                        'bigrams' => $bigrams,
                        'trigrams' => $trigrams,
                        'brand' => $detectedBrandIds[0] ?? null,
                    ];
                }

            }
        }

        if (app()->isLocal()) {
            Log::info("Finished OCR extraction. Total matched products: " . count($products));
        }

        return [$products, $suggestions];
    }

    protected function removeBrandNames(string $text): string
    {
        foreach ($this->brandAliases as $alias) {
            $pattern = '/(?<!\w)' . preg_quote($alias, '/') . '(?!\w)/iu'; // u = UTF-8, i = ignore case
            $text = preg_replace($pattern, '', $text);
        }

        return trim(preg_replace('/\s+/', ' ', $text));
    }


    protected function lemmatizeText(string $text): string
    {
        $words = explode(' ', $this->preprocessText($text));
        $allLemmas = Lemma::whereIn('name', $words)->pluck('lemma', 'name')->toArray();
        $lemmas = [];

        foreach ($words as $word) {
            if ($this->isBrand($word)) {
                $lemmas[] = $word;
            } elseif (isset($allLemmas[$word])) {
                $lemmas[] = $allLemmas[$word];
            }
        }

        return implode(' ', $lemmas);
    }

    protected function preprocessText(string $text): string
    {
        $text = mb_strtolower($text);
        $stopwords = config('stopwords.all');
        $corrections = [
            'skarpdtki' => 'skarpetki',
            'slodiy' => 'slodycze',
        ];

        $words = explode(' ', $text);
        $processed = array_filter(array_map(function ($word) use ($stopwords, $corrections) {
            if (in_array($word, $stopwords)) return null;
            return $corrections[$word] ?? $word;
        }, $words));

        return implode(' ', $processed);
    }

    protected function filterLemmas(array $lemmas): array
    {
        $noise = config('noises.words');

        return array_values(array_filter($lemmas, function ($lemma) use ($noise) {
            $lemma = trim($lemma);
            return mb_strlen($lemma) >= 3 &&
                !preg_match('/^\d+$/', $lemma) &&
                (!in_array($lemma, $noise) || $this->isBrand($lemma));
        }));
    }

    protected function isBrand(string $word): bool
    {
        return in_array(mb_strtolower($word), $this->brandAliases);
    }

    public function generateNgrams(array $lemmas, $maxN = 3)
    {
        $ngrams = [];
        $count = count($lemmas);

        if ($count < $maxN) {
            return $ngrams;
        }

        for ($n = 2; $n <= $maxN; $n++) {
            for ($i = 0; $i <= $count - $n; $i++) {
                $ngrams[] = implode(' ', array_slice($lemmas, $i, $n));
            }
        }

        return $ngrams;
    }

    protected function cleanDescription(string $text): string
    {
        $patterns = config('stopwords.auchan', []);
        $text = preg_replace($patterns, '', $text);
        return trim($text);
    }

    protected function detectBrands(string $text): array
    {
        $text = mb_strtolower(Str::ascii($text));
        $matchedBrandIds = [];

        foreach (Brand::all() as $brand) {
            $aliases = array_map('mb_strtolower', array_merge([$brand->name], json_decode($brand->aliases ?? '[]', true)));
            foreach ($aliases as $alias) {
                if (Str::contains($text, Str::ascii($alias))) {
                    $matchedBrandIds[] = $brand->id;
                    break;
                }
            }
        }

        return array_unique($matchedBrandIds);
    }

    protected function containsNoise(string $ngram): bool
    {
        $noise = config('noises.words');
        foreach (explode(' ', $ngram) as $word) {
            if (in_array($word, $noise)) {
                return true;
            }
        }
        return false;
    }

    protected function removeNoisePhrases(string $text): string
    {
        $phrases = config('noises.phrases');

        foreach ($phrases as $phrase) {
            $pattern = '/(?<!\w)' . preg_quote($phrase, '/') . '(?!\w)/iu';
            $text = preg_replace($pattern, '', $text);
        }

        return trim(preg_replace('/\s+/', ' ', $text));
    }

}
