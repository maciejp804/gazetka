<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Place;
use App\Models\Voivodeship;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;
use App\Models\Blog;


class GenerateMainSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate-main';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generuje sitemapę dla domeny głównej';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $sitemap = Sitemap::create();
        $places = Place::all();
        $voivodeships = Voivodeship::all();
        $categories = Category::all();


        // Strona główna
        $sitemap->add(
            Url::create(route('main.index'))
                ->setPriority(1.0)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate(now())
        );
        // Strona główna z lokalizacją
        foreach ($places as $place) {
            $sitemap->add(
                Url::create(route('main.index.gps', ['community' => $place->slug]))
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                    ->setLastModificationDate($place->updated_at ?? now())
            );
        }

        // Produkty (ogólnodostępne)
        $sitemap->add(
            Url::create(route('main.products'))
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate(now())
        );

        $product_categories = $categories->where('type', '=', 'product')
            ->where('parent_id', '=', null);
        foreach ($product_categories as $product_category){
            $sitemap->add(
                Url::create(route('main.products.category', ['category' => $product_category->slug]))
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($product_category->updated_at ?? now())
            );

            $product_subcategories = $categories->where('type', '=', 'product')
                ->where('parent_id', '=', $product_category->id);
            foreach ($product_subcategories as $sub_category) {
                $sitemap->add(
                    Url::create(route('main.products.subcategory', ['category' => $product_category->slug, 'subcategory' => $sub_category->slug]))
                        ->setPriority(0.6)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setLastModificationDate($product_category->updated_at ?? now())
                );
            }
        }


        Product::where('status', '=', 1)->chunk(1000, function ($products) use ($sitemap) {
            foreach ($products as $product) {
                $sitemap->add(
                    Url::create(route('main.product', $product->slug))
                        ->setPriority(0.5)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setLastModificationDate($product->updated_at ?? now())
                );
            }
        });

        // Kupony (ogólnodostępne)
        $sitemap->add(
            Url::create(route('main.vouchers'))
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setLastModificationDate(now())
        );

        $voucher_categories = $categories->where('type', '=', 'voucher')
            ->where('parent_id', '=', null);
        foreach ($voucher_categories as $voucher_category) {
            $sitemap->add(
                Url::create(route('main.vouchers.category', ['category' => $voucher_category->slug]))
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($voucher_category->updated_at ?? now())
            );
        }

        // Sieci handlowe (ogólnodostępne)
        $sitemap->add(
            Url::create(route('main.retailers'))
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setLastModificationDate(now())
        );

        $shop_categories = $categories->where('type', '=', 'shop')
            ->where('parent_id', '=', null);
        foreach ($shop_categories as $shop_category) {
            $sitemap->add(
                Url::create(route('main.retailers.category', ['category' => $shop_category->slug]))
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($shop_category->updated_at ?? now())
            );
        }

        // Gazetki (ogólnodostępne)
        $sitemap->add(
            Url::create(route('main.leaflets'))
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate(now())
        );

        $product_categories = $categories->where('type', '=', 'product')
            ->where('parent_id', '=', null);
        foreach ($product_categories as $product_category){
            $sitemap->add(
                Url::create(route('main.leaflets.category', ['category' => $product_category->slug]))
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($product_category->updated_at ?? now())
            );

        }

        // Gazetki (ogólnodostępne)
        $sitemap->add(
            Url::create(route('main.blogs'))
                ->setPriority(0.6)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setLastModificationDate(now())
        );

        $blog_categories = $categories->where('type', '=', 'blog')
            ->where('parent_id', '=', null);
        foreach ($blog_categories as $blog_category){
            $sitemap->add(
                Url::create(route('main.blogs.category', ['category' => $blog_category->slug]))
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($blog_category->updated_at ?? now())
            );

        }

        Blog::with('category')->where('status', '=', 'published')->chunk(1000, function ($blogs) use ($sitemap) {
            foreach ($blogs as $blog) {
                $sitemap->add(
                    Url::create(route('main.blogs.article', ['category' => $blog->category->slug, 'article' => $blog->slug]))
                        ->setPriority(0.5)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setLastModificationDate($blog->updated_at ?? now())
                );
            }
        });

        $product_categories = $categories->where('type', '=', 'product')
            ->where('parent_id', '=', null);
        foreach ($product_categories as $product_category){
            $sitemap->add(
                Url::create(route('main.leaflets.category', ['category' => $product_category->slug]))
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setLastModificationDate($product_category->updated_at ?? now())
            );

        }

        // Strony statyczne
        $sitemap->add(
            Url::create(route('main.contact'))
                ->setPriority(0.3)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setLastModificationDate(now())
        );
        $sitemap->add(
            Url::create(route('main.about'))
                ->setPriority(0.3)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setLastModificationDate(now())
        );
        $sitemap->add(
            Url::create(route('main.maps'))
                ->setPriority(0.3)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setLastModificationDate(now())
        );

        foreach ($voivodeships as $voivodeship) {
            $sitemap->add(
            Url::create(route('main.maps.voivodeship', ['category' => $voivodeship->slug]))
                ->setPriority(0.2)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                ->setLastModificationDate(now())
        );
        }


        $sitemap->writeToFile(public_path('sitemaps/sitemap-main.xml'));

        $this->info('✅ sitemap-main.xml zapisany');
        return Command::SUCCESS;
    }
}
