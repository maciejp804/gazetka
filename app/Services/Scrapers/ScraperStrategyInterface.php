<?php

namespace App\Services\Scrapers;

interface ScraperStrategyInterface
{
    public function supports(string $url): bool;

    public function scrape(string $url): ?array;
}

