<?php

namespace App\Services\Ocr\Parsers;

use Illuminate\Support\Facades\Log;
use function Webmozart\Assert\Tests\StaticAnalysis\float;

class AuchanBlockParser extends AbstractBlockParser
{
    public function parse(string $text): array
    {
        $lines = array_filter(array_map('trim', explode("\n", $text)));
        $units = implode('|', self::UNIT_TYPES);

        $priceStatus = false;

        $data = [
            'price' => null,
            'unit' => null,
            'unit_price' => null,
            'weight_volume' => null,
            'price_promo' => null,
            'promotion' => null,
            'promo_text' => null,
        ];


        foreach ($lines as $index => $line) {
            $line = mb_strtolower(trim($line));

            // 1.Wykryj frazę "na wagę"
            if (str_contains($line, 'na wagę') || str_contains($line, 'luzem')) {
                $data['sold_by_weight'] = true;
            }

            // 2. Tekst Promocyjny jeżeli jest
            if (preg_match('/\b(\d+)\s*\+\s*(\d+)\b/', $line, $match))
            {
                $data['promotion'] = strtolower($match[0]);
                $data['promo_text'] = true;
            }

            if (preg_match('/za\s+(\d+[.,]?\d*)\s*(zł(?:oty)?|pln)?/i', $line, $match) && $data['promo_text'])
            {

                $data['promotion'] .= ' '.strtolower($match[0]);
                $data['promo_text'] = false;
            }

            if (preg_match('/gratis/i', $line, $match) && $data['promo_text'])
            {

                $data['promotion'] .= ' '.strtolower($match[0]);
                $data['promo_text'] = false;
            }

            if(preg_match('/(\d{1,3})\s*%\s*TANIEJ/i', $text, $match) && $data['promo_text'] !== true )
            {
                $rawText = explode("\n", $match[0]);

                $data['promotion'] = strtolower($rawText[0]);
                if (isset($rawText[1]))
                {
                    $data['promotion']  .=' '.strtolower($rawText[1]);
                }
                $data['promo_text'] = true;
            }

            // 2. Cena promocyjna i cena regularna z pola z cenami
            if(preg_match("/^\s*\d{1,3}[.,]\d{2}\s*$/", $line, $m) || preg_match("/^\s*\d{3,6}\s*$/", $line, $m))
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


            // 3a. Cena regularna / szukaj ceny przed obniżką, np. "zastosowania obniżki 7,99 zł"
            if (preg_match('/zastosowania\s+obniżki\s+(\d{1,5}[.,]\d{2})\s*zł/i', $line, $m)) {
                $normalized = (float) str_replace(',', '.', $m[1]);
                $data['price'] = $normalized;

                if(!isset($data['price_promo']) || $data['price_promo'] > $data['price']) {
                    if (isset($data['promotion']) && preg_match('/(\d{1,2})\s*%\s*taniej/i', $data['promotion'], $m)) {
                        $percent = (float) $m[1];
                        $value = $data['price'] * (1 - $percent / 100);
                        $data['price_promo'] = $this->roundPsychologically($value);
                    }
                }
                $priceStatus = true;
            }

             // 3b. Cena regularna / przed obniżką to
            if(str_contains($line, 'przed obniżką to') &&
                preg_match("/(\d+,\d{2})\s*zł(?:\s*\/\s*([\d\s]*($units)))?/i", $line, $m)){
                $data['price'] = (float) str_replace(',', '.', $m[1]);

//                if(!isset($data['price_promo']) || $data['price_promo'] > $data['price']) {
//                    dd($lines, $line, $data);
//                }

            }
            // 4. Cena promocyjna na bazie promocji i ceny regularnej
            if (isset($data['price']) && !isset($data['price_promo']) && $priceStatus) {
                if (isset($data['promotion']) && preg_match('/(\d{1,2})\s*%\s*taniej/i', $data['promotion'], $m)) {

                    $percent = (float) $m[1];
                    $value = $data['price'] * (1 - $percent / 100);
                    $data['price_promo'] = $this->roundPsychologically($value);
                }
            }


            // 5. Jednostka — np. g, ml, szt., opak.
            if (!$data['unit'] && preg_match("/\b($units)\b/i", $line, $m)) {
                $data['unit'] = match(trim($m[1])) {
                    'kg' => 'kg',
                    'g', '100 g' => '100g',
                    'ml' => 'ml',
                    'l'  => 'l',
                    'opak' => 'opak',
                    'but' => 'but',
                    'puszka' => 'puszka',
                    'pęczek' => 'pęczek',
                    default => 'szt'
                };
            }

            if (!$data['unit'] && isset($data['sold_by_weight'])) {
                $data['unit'] = 'kg';
            }

        }

        // 6. Sprawdzenie ceny promocyjnej na bazie promocji i ceny regularnej
        if (!empty($data['price']) && !empty($data['price_promo']) && !empty($data['promotion'])) {
            if (preg_match('/(\d{1,2})\s*%\s*taniej/i', $data['promotion'], $m)) {
                $percent = (float) $m[1];
                $expected = $data['price'] * (1 - $percent / 100);
                $expectedPromo = $this->roundPsychologically($expected);

                // Tolerancja 5 groszy – nie nadpisuj, jeśli różnica jest bardzo mała
                if (abs($expectedPromo - $data['price_promo']) > 0.8) {
                    $data['price_promo'] = $expectedPromo;
                    $data['_price_promo_corrected'] = true; // debug/info
                }
            }
        }

        return $data;
    }

    function roundPsychologically(float $value): float
    {
        $zl = floor($value);
        $gr = round(($value - $zl) * 100); // grosze jako liczba całkowita

        if ($gr <= 8) {
            return max(0, $zl - 1 + 0.99); // np. 12.08 → 11.99
        }

        if ($gr <= 19) {
            return $zl + 0.09; // np. 12.14 → 12.09
        }

        // domyślne zaokrąglenie
        return round($value, 2);
    }

}
