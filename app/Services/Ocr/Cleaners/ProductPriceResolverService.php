<?php

namespace App\Services\Ocr\Cleaners;

class ProductPriceResolverService
{
    /**
     * Znajdź najbliższy blok z ceną do wskazanego bloku z opisem produktu.
     */
    public function findClosestPriceBlock(array $productBlock, array $allBlocks): ?array
    {
        $productMidX = ($productBlock['startX'] + $productBlock['endX']) / 2;
        $productTopY = $productBlock['minY'];

        $closest = null;
        $minDistance = PHP_INT_MAX;

        foreach ($allBlocks as $block) {
            if (!isset($block['text'], $block['startX'], $block['endX'], $block['minY'], $block['maxY'])) {
                continue;
            }

            if (!preg_match('/\d+,\d{2}/', $block['text'])) {
                continue; // tylko ceny wyglądające na liczby z przecinkiem
            }

            $priceBottomY = $block['maxY'];
            $priceMidX = ($block['startX'] + $block['endX']) / 2;

            $horizontalDistance = abs($priceMidX - $productMidX);
            $verticalDistance = $productTopY - $priceBottomY;

            if ($verticalDistance >= 0 && $verticalDistance < 100 && $horizontalDistance < 100) {
                $totalDistance = $verticalDistance + $horizontalDistance;

                if ($totalDistance < $minDistance) {
                    $closest = $block;
                    $minDistance = $totalDistance;
                }
            }
        }

        return $closest;
    }

    /**
     * Pobierz cenę z bloku tekstowego.
     */
    public function extractPriceFromBlock(?array $priceBlock): ?string
    {
        if (!$priceBlock || !isset($priceBlock['text'])) {
            return null;
        }

        if (preg_match('/(\d+,\d{2})/', $priceBlock['text'], $m)) {
            return $m[1] . ' zł';
        }

        return null;
    }
}
