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
}
