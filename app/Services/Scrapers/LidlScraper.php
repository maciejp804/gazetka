<?php

namespace App\Services\Scrapers;

use Symfony\Component\DomCrawler\Crawler;

class LidlScraper extends BaseScraper implements ScraperStrategyInterface
{
    public function supports(string $url): bool
    {
        return str_contains(parse_url($url, PHP_URL_HOST), 'lidl.pl');
    }

    public function scrape(string $url): ?array
    {
        $html = $this->fetchHtml($url);

        if (!$html) {
            return null;
        }
        $data = $this->extractProductJson($html);
//        dd($data);
        $response = array(
                'promo_price' => $data['offers'][0]['price']
        );


        return $response;
    }


}
