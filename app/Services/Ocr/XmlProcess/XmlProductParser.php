<?php

namespace App\Services\Ocr\XmlProcess;

use App\Models\Product;

class XmlProductParser
{
    public function parse(string $xmlPath): array
    {
        if (!file_exists($xmlPath)) {
            throw new \Exception("File not found: $xmlPath");
        }

        $xml = simplexml_load_file($xmlPath);
        if (!$xml) {
            throw new \Exception("Failed to load XML file.");
        }

        $texts = [];
        foreach ($xml->page->text as $textNode) {
            $text = trim((string) $textNode);
            if ($text === '') continue;

            $texts[] = [
                'x' => (int) $textNode['left'],
                'y' => (int) $textNode['top'],
                'width' => (int) $textNode['width'],
                'height' => (int) $textNode['height'],
                'text' => $text,
            ];
        }

        usort($texts, fn($a, $b) => $a['y'] <=> $b['y'] ?: $a['x'] <=> $b['x']);

        return $this->groupProducts($texts);
    }

    private function groupProducts(array $texts): array
    {
        $products = [];
        $group = [];
        $lastY = null;
        $threshold = 50;

        foreach ($texts as $t) {
            if ($lastY !== null && abs($t['y'] - $lastY) > $threshold && !empty($group)) {
                $block = $this->extractData($group);
                if ($block) {
                    $products[] = $block;
                }
                $group = [];
            }
            $group[] = $t;
            $lastY = $t['y'];
        }

        if (!empty($group)) {
            $block = $this->extractData($group);
            if ($block) {
                $products[] = $block;
            }
        }

        return $products;
    }

    private function extractData(array $group): ?array
    {
        $textBlob = mb_strtolower(implode(' ', array_column($group, 'text')));


        preg_match('/(\d{1,3}[.,]\d{2})/', $textBlob, $price);
        preg_match('/(\d{1,3}[.,]\d{2})[^\d]*(kg|l|ml|g)/', $textBlob, $unitPrice);
        preg_match('/(\d+%\s*taniej)/', $textBlob, $promo);
        preg_match('/(\d+\s*(kg|g|ml|l))/', $textBlob, $weight);
        preg_match('/od\s*(\d{1,2}\.\d{1,2})/', $textBlob, $from);
        preg_match('/do\s*(\d{1,2}\.\d{1,2})/', $textBlob, $to);

        $name = null;
        foreach ($group as $line) {
            if (strlen($line['text']) > 8 && !preg_match('/\d/', $line['text'])) {
                $name = $line['text'];
                break;
            }
        }

        $productDictionary = Product::pluck('name')->toArray();
        usort($productDictionary, fn($a, $b) => mb_strlen($b) <=> mb_strlen($a));

        $normalizedText = $this->normalizeText($textBlob);
        $matchedName = null;
        $confidence = 'none';

        foreach ($productDictionary as $knownName) {
            $normalizedKnown = $this->normalizeText($knownName);

            if (preg_match('/\b' . preg_quote($normalizedKnown, '/') . '\b/u', $normalizedText)) {
                $matchedName = $knownName;
                $confidence = '100%';
                break;
            }

            $lev = levenshtein($normalizedKnown, $normalizedText);
            $maxLen = max(mb_strlen($normalizedKnown), mb_strlen($normalizedText));
            $similarity = $maxLen > 0 ? (1 - $lev / $maxLen) : 0;

            if ($similarity > 0.85) {
                $matchedName = $knownName;
                $confidence = round($similarity * 100) . '%';
                break;
            }
        }

        $unitStr = isset($unitPrice[1], $unitPrice[2]) ? str_replace(',', '.', $unitPrice[1]) . ' zł/' . $unitPrice[2] : null;

        return [
            'name' => $matchedName ?? $name,
            'price' => isset($price[1]) ? str_replace(',', '.', $price[1]) : null,
            'unit_price' => $unitStr,
            'promotion' => $promo[1] ?? null,
            'weight' => $weight[1] ?? null,
            'date_from' => $from[1] ?? null,
            'date_to' => $to[1] ?? null,
            'raw_text' => $textBlob,
            'match_confidence' => $confidence
        ];
    }

    private function normalizeText(string $text): string
    {
        $text = mb_strtolower($text);
        $from = ['ą','ć','ę','ł','ń','ó','ś','ź','ż'];
        $to   = ['a','c','e','l','n','o','s','z','z'];
        $text = str_replace($from, $to, $text);
        $text = preg_replace('/[^a-z0-9 ]+/u', '', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }
}
