<?php

namespace App\Services\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

abstract class BaseScraper implements ScraperStrategyInterface
{
    public function fetchHtml(string $url): ?string
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; LaravelBot/1.0)',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $html = curl_exec($ch);
        curl_close($ch);

        return $html ?: null;
    }

    public function extractProductJson(string $html): ?array
    {
        $crawler = new Crawler($html);

        $jsonLd = $crawler->filter('script[type="application/ld+json"]')->each(function ($node) {
            $data = json_decode($node->text(), true);

            if (!is_array($data)) return null;

            if (($data['@type'] ?? null) === 'Product') return $data;

            if (isset($data[0])) {
                foreach ($data as $entry) {
                    if (($entry['@type'] ?? null) === 'Product') {
                        return $entry;
                    }
                }
            }

            return null;
        });

        return collect($jsonLd)->filter()->first();
    }

    function getScrapedContent($offerUrl)
    {
        $key = env('SCRAPER_API_KEY');
        $url = "https://api.scraperapi.com/?api_key=".$key."&url=$offerUrl";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

    }
}

