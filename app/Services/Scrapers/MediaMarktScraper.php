<?php

namespace App\Services\Scrapers;

class MediaMarktScraper extends BaseScraper implements ScraperStrategyInterface
{
    public function supports(string $url): bool
    {
        return str_contains(parse_url($url, PHP_URL_HOST), 'mediamarkt.pl');
    }

    public function scrape(string $url): ?array
    {
        $html = $this->getScrapedContent($url);

        if (!$html) {
            return null;
        }

        return $this->extractProductJson($html);
    }
}
