<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\TransferStats;
use Illuminate\Support\Facades\Artisan;
use App\Models\Blog;

Artisan::command('links:fix-redirects {id?}', function ($id = null) {
    $this->info('Start naprawiania linków 301…');
    $counter = 0;
    // 💧 przygotuj klienta Guzzle
    $httpClient = new Client([
        'allow_redirects' => true,
        'timeout'         => 5,
    ]);

    $processBatch = function ($articles) use ($httpClient, &$counter) {
        foreach ($articles as $article) {
            $content = $article->body;

            if (! preg_match_all(
                '#https?://[a-z0-9-]+\.gazetkapromocyjna\.com\.pl/[^"\'\s]*gazetka-promocyjna[^"\'\s]+#i',
                $content,
                $matches
            )) {
                continue;
            }

            $mapping = [];
            foreach (array_unique($matches[0]) as $oldUrl) {
                $effectiveUri = null;

                try {
                    $httpClient->head($oldUrl, [
                        'on_stats' => function(TransferStats $stats) use (&$effectiveUri) {
                            $effectiveUri = (string) $stats->getEffectiveUri();
                        },
                    ]);
                } catch (TransferException $e) {
                    $code = $e->getResponse()?->getStatusCode();

                    if ($code === 404) {
                        $this->warn("404 Not Found dla URL “{$oldUrl}” w artykule #{$article->id} ({$article->slug})");
                        continue;
                    }

                    $this->warn("Błąd HTTP dla URL “{$oldUrl}” w artykule #{$article->id} ({$article->slug}): "
                        . $e->getMessage());

                    continue;
                }

                // jeśli chcesz fallback na GET przy HEAD 404:
                if (empty($effectiveUri) && isset($code) && $code === 404) {
                    try {
                        $httpClient->get($oldUrl, [
                            'allow_redirects' => true,
                            'timeout'         => 5,
                            'on_stats'        => function(TransferStats $stats) use (&$effectiveUri) {
                                $effectiveUri = (string) $stats->getEffectiveUri();
                            },
                        ]);
                    } catch (TransferException $e2) {
                        $this->warn("GET też nie zadziałał dla URL “{$oldUrl}” w artykule #{$article->id} ({$article->slug}): "
                            . $e2->getMessage());
                        continue;
                    }
                }

                $finalUrl = $effectiveUri ?: $oldUrl;
                if ($finalUrl !== $oldUrl) {
                    $mapping[$oldUrl] = $finalUrl;
                }
            }



            if ($mapping) {
                $newContent = str_replace(
                    array_keys($mapping),
                    array_values($mapping),
                    $content
                );

                if ($newContent !== $content) {
                    $article->body = $newContent;
                    $article->save();
                    $this->info(" Artykuł #{$article->id} zaktualizowany: "
                        . count($mapping) . " linków");
                    $counter  += count($mapping);
                }
            }
        }
    };

    if ($id) {
        $this->info(" Przetwarzam tylko wpis o ID=$id");
        $single = Blog::where('id', $id)->get();
        $processBatch($single);
    } else {
        Blog::chunk(100, $processBatch);
    }

    $this->info(' Gotowe!' . $counter);
})->describe('Zamienia w body linki 301 na ostateczne URL-e; opcjonalnie tylko wybranego wpisu.');
