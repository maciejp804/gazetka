<?php

namespace App\Services;

class TextServices
{
    public function shorten(string $text, int $maxWords = 80): string
    {
        // Usuń nadmiarowe białe znaki
        $text = trim(preg_replace('/\s+/', ' ', $text));

        // Podziel na zdania
        $sentences = preg_split('/(?<=[.!?])\s+/', $text);

        $shortText = '';
        $wordCount = 0;

        foreach ($sentences as $sentence) {
            $wordsInSentence = str_word_count($sentence);

            if (($wordCount + $wordsInSentence) > $maxWords) {
                break;
            }

            $shortText .= $sentence . ' ';
            $wordCount += $wordsInSentence;
        }

        return trim($shortText);
    }

    public function generateAliases($brandName): array {
        $brand = strtolower($brandName);
        $aliases = [$brandName];

        // bez polskich znaków
        $noDiacritics = iconv('UTF-8', 'ASCII//TRANSLIT', $brandName);
        if ($noDiacritics && $noDiacritics !== $brandName) {
            $aliases[] = $noDiacritics;
        }

        // wersja bez spacji
        $aliases[] = str_replace(' ', '', $brand);
        $aliases[] = str_replace(' ', '-', $brand);

        return array_unique($aliases);
    }

    public function slugify(string $name): string
    {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $name); // usuwa polskie znaki
        $slug = preg_replace('/[^a-zA-Z0-9\s-]/', '', $slug); // usuwa znaki specjalne
        $slug = strtolower(trim($slug));
        $slug = preg_replace('/[\s-]+/', '-', $slug); // spacje → myślniki

        return $slug;
    }


}
