<?php

namespace App\Services\Ocr\Parsers;

use Illuminate\Support\Facades\Log;

abstract class AbstractBlockParser
{
    protected const UNIT_TYPES = ['kg', 'g', 'ml', 'l', 'opak', 'szt', 'but', 'puszka', 'słoik'];

    abstract public function parse(string $text): array;

    protected function combineDiscountedPrice(?string $line): ?string
    {
        if (!$line) return null;

        if (
            preg_match('/(\d+,\d{2})\s*zł/', $line, $priceMatch) &&
            preg_match('/(\d{1,2})\s*%\s*(taniej|mniej)/i', $line, $discountMatch)
        ) {
            $regular = (float) str_replace(',', '.', $priceMatch[1]);
            $percent = (int) $discountMatch[1];

            $discounted = $regular * (1 - $percent / 100);

            // Zaokrąglenie do końcówki x,99
            $whole = floor($discounted);
            $promo = $whole + 0.99;

            // Jeśli promo > discounted, to przytnij do niższej "x,99"
            if ($promo > $discounted) {
                $promo = $whole - 1 + 0.99;
            }

            return number_format($promo, 2, ',', '') . ' zł';
        }

        return null;
    }

    protected function calculateDiscountedPrice(?float $price)
    {
        $whole = (float)str_replace(',', '.', $price);
        return $whole - 1 + 0.99;

    }

    protected function calculatePriceFromUnitAndWeight(array &$data): void
    {
        if (!isset($data['price']) && isset($data['unit_price'], $data['weight_volume'])) {
            if (
                preg_match('/(\d+,\d{2})\s*zł\s*\/\s*(kg|g|ml|l)/', $data['unit_price'], $m1) &&
                preg_match('/(\d+(?:[.,]\d+)?)\s*(g|kg|ml|l)/i', $data['weight_volume'], $m2)
            ) {
                $pricePerUnit = (float) str_replace(',', '.', $m1[1]);
                $unit1 = strtolower($m1[2]);
                $amount = (float) str_replace(',', '.', $m2[1]);
                $unit2 = strtolower($m2[2]);

                if ($unit1 === 'kg' && $unit2 === 'g') {
                    $amount = $amount / 1000;
                } elseif ($unit1 === 'g' && $unit2 === 'kg') {
                    $amount = $amount * 1000;
                } elseif ($unit1 === 'l' && $unit2 === 'ml') {
                    $amount = $amount / 1000;
                } elseif ($unit1 === 'ml' && $unit2 === 'l') {
                    $amount = $amount * 1000;
                }

                $data['price'] = round($pricePerUnit * $amount, 2);
                $data['unit'] = 'opakowanie';
            }
        }
    }

    protected function smartPsychologicalPrice(float $value): float
    {
        $fraction = $value - floor($value);

        if ($fraction < 0.28) {
            // blisko początku → obniż do x.99 poprzedniego zł
            return floor($value - 1) + 0.99;
        }

        if ($fraction < 0.3) {
            return round($value, 2); // np. 3.12 → zostaw
        }

        if ($fraction < 0.7) {
            return floor($value) + 0.50;
        }

        return floor($value) + 0.99;
    }

}
