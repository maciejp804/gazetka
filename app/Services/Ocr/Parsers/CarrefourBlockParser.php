<?php

namespace App\Services\Ocr\Parsers;

use Illuminate\Support\Facades\Log;

class CarrefourBlockParser extends AbstractBlockParser
{
    public function parse(string $text): array
    {
        $lines = array_filter(array_map('trim', explode("\n", $text)));
        $units = implode('|', self::UNIT_TYPES);

        $data = [
            'price' => null,
            'unit' => null,
            'unit_price' => null,
            'weight_volume' => null,
            'price_promo' => null,
            'promotion' => null,
        ];


        foreach ($lines as $index => $line) {
            $line = mb_strtolower(trim($line));

            // Wykryj frazę "na wagę"
            if (str_contains($line, 'na wagę')) {
                $data['sold_by_weight'] = true;
            }

            // 1. Cena jednostkowa (zł / 100 g, zł / kg, itd.)
            if (
                !$data['unit_price'] &&
                preg_match("/(\d+,\d{2})\s*zł\s*\/\s*([\d\s]*($units))/", $line, $m)
            ) {
                $rawValue = (float) str_replace(',', '.', $m[1]);
                $rawUnit = trim($m[2]);
                $unit = match(trim($m[3])) {
                    'kg' => 'kg',
                    'g', '100 g' => '100g',
                    'ml' => 'ml',
                    'l', 'I', "1" => 'l',
                    'opak' => 'opak',
                    'but' => 'but',
                    'puszka' => 'puszka',
                    'pęczek' => 'pęczek',
                    default => 'szt'
                };

                $data['unit_price'] =  number_format($rawValue, 2, ',', '') . ' zł / ' . $rawUnit;

                if(!isset($data['weight_volume']))
                {
                    if($unit === 'kg')
                    {
                        $data['weight_volume'] = '100 g';
                    }
                }

                if(isset($data['weight_volume']) &&
                    preg_match("/\b(\d{1,3}(?:[.,]\d{1,3})?)\s?($units)\b/i", $data['weight_volume'], $matches))
                {
                   $weight_volume = (float) str_replace(',', '.', $matches[1]);
                   $weight_unit = $matches[2];

                    if ($weight_unit === 'g' && $unit === 'kg') {
                        $promo_price = round($rawValue * $weight_volume / 1000, 2);
                    } elseif ($weight_unit === 'kg' && $unit === 'g') {
                        $promo_price = round($rawValue * ($weight_volume * 1000),2);
                    } elseif ($weight_unit === 'ml' && $unit === 'l') {
                        $promo_price = round($rawValue * $weight_volume / 1000, 2);
                    } elseif ($weight_unit === 'l' && $unit === 'ml') {
                        $promo_price = round($rawValue * ($weight_volume * 1000), 2);
                    }

                }

                // Przelicz 100 g na kg, jeśli "na wagę"
                if ($data['sold_by_weight'] ?? false && str_starts_with($rawUnit, '100')) {
                    $value = round($rawValue * 10, 2);
                    $unit = 'kg';
                    $value = $this->calculateDiscountedPrice($value);
                }



                if(!isset($data['price_promo'])) {
                    $data['price_promo'] ??= $promo_price ?? $value ?? null;
                }

                if(!isset($data['price'])) {
                    $data['price'] ??= $promo_price ?? $value ?? null;

                }
                $data['unit'] = $unit;
                $data['unit_price_numeric'] = $value ?? null;

            }


            // 2. Cena regularna / przed obniżką z jednostką i % zniżki
            if( str_contains($line, 'najniższa cena z 30 dni') &&
                preg_match("/(\d+,\d{2})\s*zł\s*\/\s*([\d\s]*($units))/", $line, $m)){
                $data['price'] = (float) str_replace(',', '.', $m[1]);

            }



            if ((str_contains($line, 'cena regularna') || str_contains($line, 'cena przed obniżką')) &&
                preg_match("/(\d+,\d{2})\s*zł\s*\/\s*([\d\s]*($units))/", $line, $m)
            ) {
                $data['price'] = (float) str_replace(',', '.', $m[1]);
                $data['unit'] = trim($m[3]);

            }

            if (preg_match('/(\d+[\.,]?\d*)\s*zł\s*\/\s*(\w+)\s*\.\s*,\s*(\d+)\s*%\s*(taniej|mniej)/i', $line, $m)) {
                $data['price'] = (float) str_replace(',', '.', $m[1]);
                $data['unit'] = trim($m[2]);
                $percent = (int) $m[3];
                $data['promotion'] = 'Taniej o '. $percent .'%';

            }

            if ((str_contains($line, 'taniej') || str_contains($line, 'mniej')) && $index != 0) {

                if (preg_match('/(\d{1,2})\s*%\s*(taniej|mniej)/', $line, $discountMatch)) {

                    $percent = (int) $discountMatch[1];

                    // UWAGA: musisz mieć wcześniej przypisaną cenę regularną
                    if (isset($data['price']) && $percent > 0) {
                        $regular = $data['price'];
                        $discounted = $regular * (1 - $percent / 100);

                        $promo = $this->smartPsychologicalPrice($discounted);
                        $data['price_promo'] = $promo;

                    }

                    if (
                        isset($data['price_promo'], $percent) &&
                        is_numeric($data['price_promo']) &&
                        is_numeric($percent) &&
                        $percent > 0 && $percent < 100 // zabezpieczenie przed dzieleniem przez 0
                    ) {
                        $discounted = (float) $data['price_promo'];
                        $regular = $discounted / (1 - $percent / 100); // poprawna odwrotna kalkulacja
                        $data['price'] = $this->smartPsychologicalPrice($regular);
                    }


                    $data['promotion'] = 'Taniej o '. $percent .'%';

                }

            }


            // 4. Gramatura (waga/objętość) — np. 250 g, 300 ml
            if (!$data['weight_volume'] && preg_match('/(\d+[\.,]?\d*)\s*(g|kg|ml|l)\b/i', $line, $m)) {
                $data['weight_volume'] = str_replace(',', '.', $m[1]) . ' ' . strtolower($m[2]);

            }


            if (isset($data['unit_price'], $data['weight_volume'])) {
                // parse unit_price: np. "64,65 zł / kg"
                $data['unit_price'] = preg_replace('/\/\s*1\b/i', '/ l', $data['unit_price']);
                if (preg_match('/(\d+,\d{2})\s*zł\s*\/\s*(kg|g|l|ml)/', $data['unit_price'], $m)) {
                    $unitPrice = (float) str_replace(',', '.', $m[1]);
                    $unit = $m[2];
                    $weight = $data['weight_volume'];

                    if (preg_match('/(\d+[\.,]?\d*)\s*(g|kg|ml|l)/i', $weight, $wm)) {
                        $amount = (float) str_replace(',', '.', $wm[1]);
                        $weightUnit = strtolower($wm[2]);

                        // Zamień wszystko na KG lub L
                        if ($unit === 'kg' && $weightUnit === 'g') {
                            $amount = $amount / 1000;
                        } elseif ($unit === 'l' && $weightUnit === 'ml') {
                            $amount = $amount / 1000;
                        }

                        // Cena za produkt
                        $price = round($unitPrice * $amount, 2);

                        if (!isset($data['price_promo']))
                        {
                            $data['price_promo'] = $price;
                        }

                        $data['unit'] = 'opak';
                    }
                }

            }

        }

        return $data;
    }

}
