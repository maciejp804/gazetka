<?php

namespace App\Services\Ocr\Parsers;

use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\matches;
use function Webmozart\Assert\Tests\StaticAnalysis\float;

class ChataPolskaBlockParser extends AbstractBlockParser
{
    public function parse(string $text): array
    {
        $lines = array_filter(array_map('trim', explode("\n", $text)));
        $units = implode('|', self::UNIT_TYPES);
        $weight_range = false;

        $data = [
            'price' => null,
            'unit' => null,
            'unit_price' => null,
            'weight_volume' => null,
            'price_promo' => null,
            'promotion' => null,
        ];


        foreach ($lines as $line) {
            $line = str_replace('"','', $line);
            $line = mb_strtolower(trim($line));


            // 1. Specjalna data oferty
            if(preg_match("/(\d{1,2}(?:\.\d{2})?)\s*-\s*(\d{1,2}\.\d{2})(?:\.\d{4})?/", $line, $m))
            {
                continue;
            }

            // 2. Cena promocyjna i cena regularna z pola z cenami
            if(preg_match("/^\s*\d{1,5}([.,]\d{2})?\s*$/", $line, $m))
            {
                $normalized = str_replace(',', '.', $m[0]);

                // Jeśli brak separatora – np. 1899 → 18.99
                if (!str_contains($normalized, '.') && strlen($normalized) >= 3) {
                    $float = (float) number_format(((int)$normalized) / 100, 2, '.', '');
                } else {
                    $float = (float) number_format((float)$normalized, 2, '.', '');
                }
                if (!$data['price_promo'])
                {
                    $data['price_promo'] = $float;
                }
                if(preg_match("/\b\d{1,5}([.,]\d{2})\b/", $float, $m)) {
                    $data['price'] = $float;
                }


            }

            // 3. Gramatura (waga/objętość) — np. 250 g, 300 ml


            if (!$data['weight_volume'] && preg_match('/\b\d{1,4}\s*[-–]\s*\d{1,4}\s*(g|ml|l|szt|opak|kg)\b/i', $line, $m)) {

                $t = explode('-', $m[0]);
                $m = explode(' ', $t[1]);
                $data['weight_volume'] = str_replace(',', '.', $m[0]) . ' ' . strtolower($m[1]);
                $data['unit'] = strtolower($m[1]);

            }

            if (!$data['weight_volume'] && preg_match('/\b(\d+[.,]?\d*)\s*(kg|g|ml|l|1|szt)\b/i', $line, $m)) {
                $data['weight_volume'] = str_replace(',', '.', $m[1]) . ' ' . strtolower($m[2]);
                $data['unit'] = strtolower($m[2]);

            }

            // 4. Cena jednostkowa (zł / 100 g, zł / kg, itd.)

            if (preg_match("/\b\d{1,3}[.,]\d{2}\s*[-–]\s*\d{1,3}[.,]\d{2}\s*\/\s*(kg|g|ml|l|1|szt|opak|m|cm)\b/i", $line, $m)) {
               $t = explode('-', $m[0]);
               $price = (float) str_replace(',', '.', $t[0]);
               $weight = explode(' ', $data['weight_volume']);
               $data['price_promo'] = round($price * (float) $weight[0]/1000, 2);
               $weight_range = true;
            }

            if (preg_match("/(\d+[.,]\d{2})\s*(?:zł)?\s*\/\s*(?:(\d+)?\s*($units))/i", $line, $m)
                && $weight_range === false
            ) {
                $price_temp = (float) str_replace(',', '.', $m[1]);
                $weight = explode(' ', $data['weight_volume']);
                $price = round($price_temp * (float) $weight[0]/1000, 2);


                if ($data['price_promo'] >= $price) {
                    $data['price_promo'] = $price;
                }  elseif ($data['price'] >= $price) {
                    $data['price'] = $price;
                }

            }

            // 3. Pierwszego zastosowania obniżki
            if (str_contains($line, 'pierwszego zastosowania obniżki') || str_contains($line, 'przed wprowadzeniem obniżki')) {
                if (preg_match("/(\d+[.,]\d{2})\s*(?:zł)?(?:\s*\/\s*[\d\s]*($units))?/i", $line, $m)) {
                    $data['price'] = (float) str_replace(',', '.', $m[1]);

                }
            }

            // 5. Promocja
            if (
                isset($data['price_promo'], $data['price']) && $data['price'] > 0
            ) {
                $value = ($data['price_promo'] * 100) / $data['price'];
                $value = abs(intval($value) - 100);
                $data['promotion'] = 'Taniej o ' . $value . ' %';
            }

            // 6. Cena z jednostkę
            if(isset($data['price_promo'], $data['weight_volume'])) {
                $data['unit_price'] = $data['price_promo'] .' / '. $data['weight_volume'];
            }

        }

        return $data;
    }


}
