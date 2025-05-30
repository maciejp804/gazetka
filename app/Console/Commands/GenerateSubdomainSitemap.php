<?php

namespace App\Console\Commands;

use App\Models\HotSpot;
use App\Models\Leaflet;
use App\Models\Marker;
use App\Models\Place;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSubdomainSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate-subdomain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generuje sitemapę dla subdomen';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Shop::where('status', 'active')
            ->each(function ($shop) {

            $sitemap = Sitemap::create();

            // Strona główna subdomeny
            $sitemap->add(
                Url::create(route('subdomain.index', ['subdomain' => $shop->slug]))
                    ->setPriority(1.0)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate(now())
            );

            // Lokalizacje (community = place)
                Place::whereHas('markers', function ($query) use ($shop) {
                    $query->where('shop_id', $shop->id);
                })
                    ->chunk(1000, function ($places) use ($sitemap, $shop) {
                        foreach ($places as $place) {
                            $sitemap->add(
                                Url::create(route('subdomain.index_gps', [
                                    'subdomain' => $shop->slug,
                                    'community' => $place->slug,
                                ]))
                                    ->setPriority(0.9)
                                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                    ->setLastModificationDate(now())
                            );
                        }
                    });


                $productIds = HotSpot::whereHas('page.leaflets', function ($query) use ($shop) {
                    $query->where('shop_id', $shop->id);
                })
                    ->pluck('product_id')
                    ->filter()
                    ->unique();

                Product::whereIn('id', $productIds)
                    ->where('status', 1)
                    ->chunk(1000, function ($products) use ($sitemap, $shop) {
                        foreach ($products as $product) {
                            $sitemap->add(
                                Url::create(route('subdomain.products.show', [
                                    'subdomain' => $shop->slug,
                                    'slug' => $product->slug
                                ]))
                                    ->setPriority(0.5)
                                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                    ->setLastModificationDate($product->updated_at ?? now())
                            );
                        }
                    });


                Leaflet::where('status', 'published')
                ->where('shop_id', $shop->id)
                ->chunk(1000, function ($leaflets) use ($sitemap, $shop) {
                foreach ($leaflets as $leaflet) {
                    $sitemap->add(
                        Url::create(route('subdomain.leaflet', [
                            'subdomain' => $shop->slug,
                            'data' => date("Y-m-d", strtotime($leaflet->valid_from)),'id' =>$leaflet->id]))
                            ->setPriority(0.6)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setLastModificationDate($leaflet->updated_at ?? now())
                    );
                }
            });

            Marker::with('place', 'shop')
                ->where('shop_id', $shop->id)
                ->chunk(1000, function ($markers) use ($sitemap, $shop) {
                foreach ($markers as $marker) {
                    if (!$marker->place || !$marker->slug) continue;

                    $sitemap->add(
                        Url::create(route('subdomain.shop_address', [
                            'subdomain' => $shop->slug,
                            'community' => $marker->place->slug,
                            'address' => $marker->slug
                        ]))
                            ->setPriority(0.4)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                            ->setLastModificationDate($marker->updated_at ?? now())
                    );
                }

            });


            // Zapisz sitemapkę dla tego sklepu
            $sitemap->writeToFile(public_path("sitemaps/sitemap-{$shop->slug}.xml"));

            $this->info("✅ sitemap-{$shop->slug}.xml zapisany");

            // (opcjonalnie) Poczekaj 1 sekundę
            sleep(1);
        });

        return Command::SUCCESS; // ✅ Po zakończeniu wszystkich sklepów
    }
}
