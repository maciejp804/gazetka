<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Leaflet;
use App\Models\Marker;
use App\Models\Place;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class RedirectController extends Controller
{
    public function leafletsRedirect($old_slug, $id)
    {
        Log::info('Current Route:', [Route::currentRouteName()]);

        if ($id != 0) {

            // Przykładowa kategoria dla produktu
            $category = Category::where('type', 'product')->where('old_id', $id)->first();

            // Jeśli kategoria nie istnieje, przekieruj na stronę główną
            if (!$category && ($id != 3 && $id != 4 && $id != 5)) {
                return redirect()->route('main.leaflets', [],301)->with('error', 'Podana kategoria nie istnieje');  // Przekierowanie 301
            }

            switch ($id) {
                case 1:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'drogerie-i-apteki') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.leaflets.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 2:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'dom-i-ogrod') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.leaflets.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 3:
                case 4:
                case 5:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'minimarkety' && $old_slug != 'supermarkety' && $old_slug != 'hipermarkety') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.leaflets.category', ['category' => 'artykuly-spozywcze'], 301);  // Przekierowanie 301

                case 6:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'elektromarkety') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.leaflets.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 7:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'sport') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.leaflets.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                default:
                    return redirect()->route('main.leaflets', [], 301);  // Przekierowanie 301
            }
        }

        // Jeśli $id jest równe 0 lub nie pasuje do żadnego przypadku, przekierowanie do głównej strony gazetek
        return redirect()->route('main.leaflets', [], 301);  // Przekierowanie 301
    }


    public function shopRedirect($old_slug, $id)
    {
        Log::info('Current Route:', [Route::currentRouteName()]);

        if ($id != 0) {

            // Przykładowa kategoria dla produktu
            $category = Category::where('type', 'shop')->where('old_id', $id)->first();

            // Jeśli kategoria nie istnieje, przekieruj na stronę główną
            if (!$category && ($id != 3 && $id != 4 && $id != 5)) {
                return redirect()->route('main.retailers', [],301)->with('error', 'Podana kategoria nie istnieje');  // Przekierowanie 301
            }

            switch ($id) {
                case 1:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'drogerie-i-apteki') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.retailers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 2:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'dom-i-ogrod') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.retailers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 3:
                case 4:
                case 5:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'minimarkety' && $old_slug != 'supermarkety' && $old_slug != 'hipermarkety') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.retailers.category', ['category' => 'sklepy-spozywcze'], 301);  // Przekierowanie 301

                case 6:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'elektromarkety') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.retailers.category', ['category' => 'agd-rtv'], 301);  // Przekierowanie 301

                case 7:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'sport') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.retailers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                default:
                    return redirect()->route('main.retailers', [], 301);  // Przekierowanie 301
            }

        }

        // Jeśli $id jest równe 0 lub nie pasuje do żadnego przypadku, przekierowanie do głównej strony gazetek
        return redirect()->route('main.retailers', [], 301);  // Przekierowanie 301
    }

    public function vouchersRedirect($old_slug, $id)
    {
        Log::info('Current Route:', [Route::currentRouteName()]);

        if ($id != 0) {

            // Przykładowa kategoria dla produktu
            $category = Category::where('type', 'voucher')->where('old_id', $id)->first();

            // Jeśli kategoria nie istnieje, przekieruj na stronę główną
            if (!$category) {
                return redirect()->route('main.vouchers', [],301)->with('error', 'Podana kategoria nie istnieje');  // Przekierowanie 301
            }

            switch ($id) {
                case 1:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'moda') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 2:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'dom-i-ogrod') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 3:
                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'zdrowie-i-uroda') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301
                case 4:
                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'ksiazki-czasopisma-i-gry') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301
                case 5:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'dzieci') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 6:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'finanse') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 7:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'agd-rtv-i-elektronika') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 8:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'motoryzacja') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 9:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'sport-i-rekreacja') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 10:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'art-spozywcze') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 11:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'podroze') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 12:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'internet-i-telekomunikacja') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                case 13:

                    // Sprawdzamy, czy slug zgadza się z oczekiwanym
                    if ($old_slug != 'inne') {
                        abort(404);
                    }

                    // Przekierowanie do nowej trasy z wykorzystaniem slug kategorii
                    return redirect()->route('main.vouchers.category', ['category' => $category->slug], 301);  // Przekierowanie 301

                default:
                    return redirect()->route('main.vouchers', [], 301);  // Przekierowanie 301
            }
        }

        // Jeśli $id jest równe 0 lub nie pasuje do żadnego przypadku, przekierowanie do głównej strony gazetek
        return redirect()->route('main.vouchers', [], 301);  // Przekierowanie 301
    }

    public function articleRedirect($slug, $id)
    {
        $blog = Blog::with('category')->where('id', $id)->first();

        if (!$blog)
        {
            abort(404);
        }

        return redirect()->route('main.blogs.article', ['category' => $blog->category->slug,'article' => $blog->slug], 301);
    }

    public function productRedirect($subdomain, $slug, $id)
    {
        $product = Product::where('old_id', $id)->first();

        if (!$product)
        {
            abort(404);
        }

        return redirect()->route('subdomain.products.show', ['subdomain' => $subdomain, 'slug' => $product->slug], 301);
    }

    public function addressRedirect($subdomain, $city, $address, $id)
    {

        Log::info('Current Route:', [Route::currentRouteName()]);

        $marker = Marker::with('place', 'shop')
            ->where('old_id', $id)
            ->whereHas('shop', function ($query) use ($subdomain) {
                $query->where('slug', $subdomain);
            })
            ->first();

        if (!$marker)
        {
            abort(404);
        }

        return redirect()->route('subdomain.shop_address', [
            'subdomain' => $marker->shop->slug,
            'community' => $marker->place->slug,
            'address' => $marker->slug], 301);
    }

    public function leafletRedirect($subdomain, $shop, $data, $id)
    {
        Log::info('Current Route:', [Route::currentRouteName()]);

        $leaflet = Leaflet::with('shop', 'pages', 'cover')
            ->where('number', $id)
            ->whereHas('shop', function ($query) use ($subdomain) {
                $query->where('slug', $subdomain);
            })
            ->whereHas('cover')
            ->whereHas('pages')
            ->first();



        if (!$leaflet)
        {
            abort(404);
        }

        return redirect()->route('subdomain.leaflet', [
            'subdomain' => $leaflet->shop->slug,
            'id' => $leaflet->id], 301);
    }


    public function placeRedirect($slug, $id, $place)
    {
        Log::info('Current Route:', [Route::currentRouteName()]);

            // Pobierz miejscowość na podstawie slugu
            $place = Place::where('slug', $place)->first();

            // Jeśli kategoria lub miejscowość nie istnieje, przekieruj na stronę główną z komunikatem
            if (!$place) {
                return redirect()->route('main.index', [], 301)
                    ->with('error', 'Miejscowość nie istnieje');  // Przekierowanie 301
            }

            return redirect()->route('main.index.gps', ['community' => $place->slug],301);  // Przekierowanie 301

    }


}

