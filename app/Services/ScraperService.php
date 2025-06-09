<?php

namespace App\Services;

use App\Services\Scrapers\ScraperStrategyInterface;

class ScraperService
{
    protected array $strategies;

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    public function scrape(string $url): ?array
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($url)) {
                return $strategy->scrape($url);
            }
        }

        throw new \Exception("No scraper strategy found for: {$url}");
    }
}



//namespace App\Services;
//
//use Symfony\Component\DomCrawler\Crawler;
//
//class ScraperService
//{
//    public function fetchHtml(string $url): ?string
//    {
//        $ch = curl_init($url);
//        curl_setopt_array($ch, [
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; LaravelBot/1.0)',
//            CURLOPT_SSL_VERIFYHOST => false,
//            CURLOPT_SSL_VERIFYPEER => false,
//        ]);
//
//        $html = curl_exec($ch);
//        curl_close($ch);
//
//        return $html ?: null;
//    }
//
//    public function extractProductJson(string $html): ?array
//    {
//        $crawler = new Crawler($html);
//
//        $jsonLd = $crawler->filter('script[type="application/ld+json"]')->each(function ($node) {
//            $data = json_decode($node->text(), true);
//            if (!is_array($data)) {
//                return null;
//            }
//
//            // Jeśli pojedynczy blok to sprawdzamy typ
//            if (($data['@type'] ?? null) === 'Product') {
//                return $data;
//            }
//
//            // Jeśli to jest tablica (np. wiele @type)
//            if (isset($data[0])) {
//                foreach ($data as $entry) {
//                    if (($entry['@type'] ?? null) === 'Product') {
//                        return $entry;
//                    }
//                }
//            }
//
//            return null;
//        });
//
//        return collect($jsonLd)->filter()->first();
//    }
//
//    public function scrapeProduct(string $url): ?array
//    {
//        $html = $this->fetchHtml($url);
//
//        if (!$html) {
//            return null;
//        }
//
//        return $this->extractProductJson($html);
//    }
//
//}
