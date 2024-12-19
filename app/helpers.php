<?php

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\DomCrawler\Crawler;

if (! function_exists('monthReplace')) {
    function monthReplace ($date, $format = 'd-m-Y', $separator = ' '){

        $month_array = array(
            1 => 'STY',
            2 => 'LUT',
            3 => 'MAR',
            4 => 'KWI',
            5 => 'MAJ',
            6 => 'CZE',
            7 => 'LIP',
            8 => 'SIE',
            9 => 'WRZ',
            10 => 'PAŹ',
            11 => 'LIS',
            12 => 'GRU',

        );

        // format daty jest YYYY-mm-dd
        $day = date('j', strtotime($date));
        $month = $month_array[date('n', strtotime($date))];
        $year = date('Y', strtotime($date));

        // wyciągnąć miesiąc z daty i zamienić zgodnie z tablicą
        //zamienić miesiąć z liczby na litery
        if ($format === 'd-m-Y') {
            return $day . $separator . $month . $separator . $year;
        } elseif ($format === 'd-m') {
            return $day . $separator . $month;
        }
    }
}

if (!function_exists('getUrlData')) {
    function getUrlData($type): stdClass
    {
        $urlData = new stdClass();

        switch ($type) {
            case 'vouchers':
                $urlData->urlType = 'kupony-rabatowe';
                $urlData->routeName = 'main.vouchers.category';
                break;

            case 'products':
                $urlData->urlType = 'produkty';
                $urlData->routeName = 'main.products.category';
                break;

            case 'retailers':
                $urlData->urlType = 'sieci-handlowe';
                $urlData->routeName = 'main.retailers.category';
                $urlData->routeNameSubdoamin = 'subdomain.index';
                break;

            case 'leaflets':
                $urlData->urlType = 'gazetki-promocyjne';
                $urlData->routeName = 'main.leaflets.category';
                break;

            default:
                $urlData->urlType = 'default';
                $urlData->routeName = 'main.default';
                break;
        }

        return $urlData;
    }
}


if (!function_exists('validationDate'))
{
    function validationDate($endDate, $startDate = NULL, $createDate = NULL)
    {
        $dataNow = new DateTime('now'); // przykład bieżącej daty
        $dataEnd = new DateTime($endDate); // przykład końcowej daty
        $dataStart = new DateTime($startDate);
        $dataCreate = new DateTime($createDate);
        $diff = $dataEnd->diff($dataNow);

        $new = false;
        if ($createDate !== NULL) {
            $diff2 = $dataCreate->diff($dataNow);
            if($diff2->invert == 0 && $diff2->days < 1 )
            {
                $new = true;
            }
        }



        if($dataStart > $dataNow){
            return ['end'=>'Nadchodzaca oferta', 'classes' => 'bg-blue-500', 'new' => $new];
        }
            // Sprawdź, czy data końcowa jest w przyszłości
            if ($dataEnd > $dataNow) {
                $classes = 'bg-green-500';
                if ($diff->days > 30) {
                    $miesiace = $diff->y * 12 + $diff->m;
                    if ($miesiace > 4) {
                        $toEnd = "Aktualna $miesiace miesięcy";
                    } elseif ($miesiace > 1) {
                        $toEnd = "Ważne jeszcze $miesiace miesiące";
                    } else {
                        $toEnd = "Ważne jeszcze $miesiace miesiąc";
                    }
                } elseif ($diff->days >= 1) { // Jeśli różnica wynosi co najmniej 1 dzień
                    $dni = $diff->days;

                    if ($dni > 4) {
                        $toEnd = "Ważne jeszcze $dni dni";
                    } elseif ($dni > 1) {
                        $toEnd = "Ważne jeszcze $dni dni";
                    } else {
                        $toEnd = "Ważne jeszcze $dni dzień";
                        $classes = 'bg-yellow-600';
                    }
                } elseif ($diff->h > 0 || $diff->i > 0) { // Jeśli różnica wynosi mniej niż 1 dzień
                    $godziny = $diff->h;
                    $minuty = $diff->i;
                    $classes = 'bg-yellow-600';
                    if ($godziny > 1) {
                        $toEnd = "Ważne jeszcze $godziny godzin";
                    } elseif ($godziny === 1) {
                        $toEnd = "Ważne jeszcze $godziny godzina";
                    } else {
                        $toEnd = "Ważne jeszcze $minuty minut";
                    }
                } else {
                    $toEnd = "Oferta już się kończy";
                    $classes = 'bg-red-500';
                }
            } else {
                $toEnd = "Termin już upłynął";
                $classes = 'bg-red-500';
            }
        return ['end'=> $toEnd, 'classes' => $classes, 'new' => $new];

    }
}

if (! function_exists('siteValidator'))
{
    function siteValidator ($site, $place = null)
    {
        try {
            $descriptions = SiteType::with(['descriptions','questions', 'meta'])->where('name',$site)
                ->where('place_id', '=', $place)->firstOrFail();

        } catch (ModelNotFoundException $e) {
            $descriptions = new SiteType();
        }

             return $descriptions;
    }
}
if (! function_exists('calculateDistance')) {
    function calculateDistance($point1, $point2) {
        $lat1 = $point1[0];
        $lon1 = $point1[1];
        $lat2 = $point2[0];
        $lon2 = $point2[1];

        $earthRadius = 6371; // Średnia odległość od środka Ziemi do jej powierzchni w kilometrach

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }
}

if (! function_exists('weekday')) {

    function weekday()
    {
        return match (date('N')){
          1,2,3,4,5 => 'weekdays',
            6 => 'saturday',
            7 => 'sunday',
            default => 'null'
        };

    }

}

if (! function_exists('localSlug')) {

    function localSlug ($placesAll)
    {

        if(isset($_COOKIE['local'])){
            $cookie = $_COOKIE['local'];

            $cookieJson = json_decode($cookie, true);
            $cookieLat = $cookieJson['lat'];
            $cookieLng = $cookieJson['lng'];

            $placesCookie = $placesAll->where('name', $cookieJson['place']);

            if ($placesCookie->isEmpty()) {
                // Brak miejsc o danej nazwie, znajdź najbliższe
                $minDistance = PHP_INT_MAX;
                $closestPlace = null;

                foreach ($placesAll as $place) {
                    // Oblicz odległość pomiędzy współrzędnymi z ciasteczka a miejscem w bazie danych
                    $distance = calculateDistance([$place->lat, $place->lng], [$cookieLat, $cookieLng]);

                    // Sprawdź czy aktualne miejsce jest bliżej niż poprzednie
                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                        $closestPlace = $place;
                    }
                }
            } elseif ($placesCookie->count() == 1) {
                // Tylko jedno miejsce o danej nazwie
                $closestPlace = $placesCookie->first();
            } else {
                // Wiele miejsc o danej nazwie, znajdź najbliższe
                $minDistance = PHP_INT_MAX;
                $closestPlace = null;

                foreach ($placesCookie as $place) {
                    // Oblicz odległość pomiędzy współrzędnymi z ciasteczka a miejscem w bazie danych
                    $distance = calculateDistance([$place->lat, $place->lng], [$cookieLat, $cookieLng]);

                    // Sprawdź czy aktualne miejsce jest bliżej niż poprzednie
                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                        $closestPlace = $place;
                    }
                }
            }

            return $closestPlace;
        }

        return null;
    }
}



if (! function_exists('setCookies')) {

    function setCookies($closestPlace)
    {
        $minutes = 43200;

        $cookieArray = [
            'place' => $closestPlace->name,
            'district' => $closestPlace->voivodeship->name,
            'lat' => $closestPlace->lat,
            'lng' => $closestPlace->lng
        ];

        $cookieJson = json_encode($cookieArray);
        //dd($cookieJson);
        // Ustaw ciasteczko
        Cookie::queue('local', $cookieJson, $minutes);

        // Zwróć odpowiedź z ustawionym ciasteczkiem
        return true;
    }
}

if (! function_exists('locationsInZone')) {
    function locationsInZone($placesAll, $place, $zone = 20)
    {
        // Dodajemy odległość do każdego elementu kolekcji $placesAll
        $placesAll->each(function ($location) use ($place) {
            $distance = calculateDistance([$location->lat, $location->lng], [$place->lat, $place->lng]);
            $location->distance = $distance; // Dodajemy odległość do każdego miejsca w kolekcji
        });

        // Filtrujemy kolekcję $placesAll, aby uzyskać tylko te lokalizacje oddalone o N km od danej lokalizacji
        $locationsWithinNkm = $placesAll->filter(function ($location) use ($zone) {
            return $location->distance <= $zone; // Zwracamy true tylko dla miejsc oddalonych o N km
        });

        // Sortujemy po odległości
        $locationsWithinNkm = $locationsWithinNkm->sortBy('distance');

        // Zwracamy identyfikatory miejscowości oddalonych o 20 km od danej lokalizacji

        return $locationsWithinNkm->pluck('id');
    }
}


if (! function_exists('storesLocation')) {

    function storesLocation($allStores, $locationsWithinNkmIds)
    {

        //Pobranie sklepów, które są w miejscowościach w promieniu Nkm
        $storesWithinNkm = $allStores->filter(function ($store) use ($locationsWithinNkmIds) {
            return $store->places->pluck('id')->intersect($locationsWithinNkmIds)->isNotEmpty();
        });

        //ID sklepów w promieniu 20km
        $storesWithinNkmIds = $storesWithinNkm->pluck('id');

        $storesLocation=collect();
        $storesLocation->storesWithinNkmIds = $storesWithinNkmIds;
        $storesLocation->storesWithinNkm = $storesWithinNkm;

        return $storesLocation;

    }
}

if (! function_exists('getScrapedContent')) {

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


if (! function_exists('getScrapedContentOwn')) {
    function getScrapedContentOwn($offerUrl)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $offerUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        dd($response);
    }
}

if (! function_exists('findTag')) {

    function findTag($html, $store)
    {

        if ($store === 'rtveuroagd') {

            if ($html['activeProductDetails']['voucherDetails'] === null) {
                $promoCode = null;
            } else {
                $promoCode = $html['activeProductDetails']['voucherDetails']['voucherCode'];
            }

            $h1Tag = $html['frontName'];
            $prices = [];
            if ($html['activeProductDetails']['voucherDetails'] !== null) {
                $price = $html['activeProductDetails']['prices']['voucherDiscountedPrice'];
                $prices[] = ['price' => $html['activeProductDetails']['prices']['lowestPrice']['price'], 'label' => 'Najniższa cena z 30 dni przed obniżką'];
                $prices[] = ['price' => $html['activeProductDetails']['prices']['mainPrice'], 'label' => 'Cena bez kodu:'];
            } elseif ($html['activeProductDetails']['prices']['promotionalPrice'] !== null) {
                $price = $html['activeProductDetails']['prices']['promotionalPrice']['price'];
                $prices[] = ['price' => $html['activeProductDetails']['prices']['lowestPrice']['price'], 'label' => 'Najniższa cena z 30 dni przed obniżką'];
                $prices[] = ['price' => $html['activeProductDetails']['prices']['mainPrice'], 'label' => 'Cena bezpośrednio przed obniżką'];
            } else {
                $price = $html['activeProductDetails']['prices']['mainPrice'];
                $prices = null;
            }

            $price = explode('.', $price);

            $priceWhole = $price[0];
            if (!isset($price[1])) {
                $priceRest = '00';
            } else {
                $priceRest = $price[1];
            }

            foreach ($html['technicalAttributes'][0]['attributes'] as $item) {
                $attributes[] = ['name' => $item['name'], 'values' => $item['value'][0]['name']];
            }

            $imageUrl = $html['images'][2]['url'];
            $offerUrl = $html['seo']['canonical'];

        } elseif ($store === 'media-expert') {
            // W tym przypadku, przykładowo, możemy użyć Symfony DomCrawler do znajdowania znacznika <h1>
            $crawler = new Crawler($html);

            $h1Tag = $crawler->filter('h1')->text();

            // Filtrowanie elementów HTML za pomocą klasy CSS
            $dynamicContent = $crawler->filter('div[class*="dynamic-content"]');

            $elements = $crawler->filter('.promo-code');
            if (count($elements) > 0) {
                $promoCode = $elements->first()->text();
            } else {
                $promoCode = null;
            }

            $elementsWhole = $dynamicContent->filter('.whole');
            $elementsRest = $dynamicContent->filter('.rest');

// Inicjalizuj zmienne na najwyższą cenę i odpowiadający jej indeks
            $priceWholeIndex = null;
            $priceWhole = 0;

// Iteruj przez wszystkie elementy o klasie '.whole' i znajdź najwyższą cenę oraz jej indeks
            $elementsWhole->each(function ($element, $index) use (&$priceWholeIndex, &$priceWhole) {
                $price = $element->text();
                if ($price > $priceWhole) {
                    $priceWhole = $price;
                    $priceWholeIndex = $index;
                }
            });

// Jeśli znaleziono najwyższą cenę, pobierz odpowiadający jej priceRest
            if ($priceWholeIndex !== null) {
                $priceRestElement = $elementsRest->eq($priceWholeIndex); // Pobierz element priceRest z tym samym indeksem co priceWhole
                $priceRest = $priceRestElement->text(); // Pobierz wartość priceRest
            }

            $elements = $dynamicContent->filter('.info-box');

            $prices = [];
            $existingPrices = [];

            $elePrices = $elements->filter('.price');
            $eleLabels = $elements->filter('.label');

            // Sprawdzenie, czy liczba elementów z nazwami ceną i etykietą jest taka sama
            if ($elePrices->count() === $eleLabels->count()) {
                $elePrices->each(function ($elePrice, $i) use ($eleLabels, &$prices, &$existingPrices) {
                    $price = $elePrice->text();
                    $label = $eleLabels->eq($i)->text(); // Pobranie wartości dla tego samego indeksu

                    // Sprawdzenie, czy atrybut już istnieje w tablicy
                    if (!isset($existingPrices[$price])) {
                        $label = trim(str_replace('Prezentowana najniższa cena z 30 dni przed obniżką dla kanału sprzedaży mediaexpert.pl.', '', $label));
                        // Jeśli nie istnieje, dodaj go do tablicy atrybutów i oznacz jako dodany w tablicy istniejących atrybutów
                        $prices[] = ['price' => $price, 'label' => $label];
                        $existingPrices[$price] = true;
                    }
                });
            }


            // Przetwarzanie atrybutów
            $attributes = [];
            $existingAttributes = []; // Tablica do przechowywania już dodanych atrybutów

            $elements = $crawler->filter('.attribute-name');
            $elementsValues = $crawler->filter('.attribute-values');

            // Sprawdzenie, czy liczba elementów z nazwami atrybutów i wartościami jest taka sama
            if ($elements->count() === $elementsValues->count()) {
                $elements->each(function ($element, $i) use ($elementsValues, &$attributes, &$existingAttributes) {
                    if (count($attributes) >= 10) {
                        return false; // Przerwij iterację, jeśli liczba atrybutów przekroczyła 10
                    }

                    $name = $element->text();
                    $value = $elementsValues->eq($i)->text(); // Pobranie wartości dla tego samego indeksu

                    // Sprawdzenie, czy atrybut już istnieje w tablicy
                    if (!isset($existingAttributes[$name])) {
                        // Jeśli nie istnieje, dodaj go do tablicy atrybutów i oznacz jako dodany w tablicy istniejących atrybutów
                        $attributes[] = ['name' => $name, 'values' => $value];
                        $existingAttributes[$name] = true;
                    } else {
                        // Jeśli atrybut już istnieje, dodaj tylko wartość do istniejącej pary
                        $existingIndex = array_search($name, array_column($attributes, 'name'));
                        $attributes[$existingIndex]['values'] .= ', ' . $value;
                    }
                });
            }


            $divsWithImages = $crawler->filter('div[src*="https://prod-api.mediaexpert.pl/api/images/gallery_500_500/thumbnails/images"]')->first();
            $imageUrl = $divsWithImages->attr('src');
            $offerUrl = null;
        } elseif ($store === 'home-you') {
            $promoCode = null;

            $crawler = new Crawler($html);

            $h1Tag = $crawler->filter('h1')->text();

            $images = $crawler->filter('img');

            $imageUrl = '';
            // Przetwórz znalezione znaczniki <img>
            $images->each(function ($node) use (&$imageUrl) {
                // Pobierz atrybut 'src' każdego znacznika <img>
                $src = $node->attr('src');
                // Zrób coś z atrybutem 'src' (np. wyświetl go lub przetwórz)

                if ((str_contains($src, 'https://media.home-you.com/catalog/product/'))) {

                    $imageUrl = preg_split('/\?/', $src)[0];
                    return false; // Przerwij funkcję each()

                }
            });

            $priceElement = $crawler->filterXPath('//div[@data-cy="undefined_price"]');

            // Sprawdź, czy znaleziono element
            if ($priceElement->count() > 0) {
                // Pobierz tekst z elementu, usuń znaki nieliterowe i przecinki, a następnie zamień kropkę na przecinek
                $priceText = $priceElement->text();
                $priceText = str_replace([' ', ',', 'zł'], ['', '.', ''], $priceText);
                $price = preg_split('/\./', $priceText);
                $priceWhole = $price[0];
                if (!isset($price[1])) {
                    $priceRest = '00';
                } else {
                    $priceRest = $price[1];
                }

            } else {
                $priceWhole = '00';
                $priceRest = '00';
            }
            $prices = [];
            $priceElement = $crawler->filterXPath('//div[@data-cy="undefined_price_old"]');

            if ($priceElement->count() > 0) {
                // Pobierz tekst z elementu, usuń znaki nieliterowe i przecinki, a następnie zamień kropkę na przecinek
                $priceText = $priceElement->text();
                $priceText = str_replace([' ', ',', 'zł'], ['', '.', ''], $priceText);
                $prices[] = ['price' => $priceText, 'label' => 'Cena regularna'];
            }
            $priceElement = $crawler->filterXPath('//span[@data-cy="product_price_average"]');
            if ($priceElement->count() > 0) {
                // Pobierz tekst z elementu, usuń znaki nieliterowe i przecinki, a następnie zamień kropkę na przecinek
                $priceText = $priceElement->text();
                $priceText = str_replace([' ', ',', 'zł'], ['', '.', ''], $priceText);
                $prices[] = ['price' => $priceText, 'label' => 'Najniższa cena z 30 dni przed obniżką'];
            }

            $attributes = [];


            $offerUrl = null;
        } elseif ($store === 'lidl') {

            $promoCode = null;
            $h1Tag = $html[0]['fullTitle'];

            $priceText = str_replace([' ', ',', 'zł'], ['', '.', ''], $html[0]['price']['price']);
            $price = preg_split('/\./', $priceText);
            $priceWhole = $price[0];
            if (!isset($price[1])) {
                $priceRest = '00';
            } else {

                $priceRest = str_pad($price[1], 2, '0', STR_PAD_RIGHT);

            }
            $prices = [];
            if (isset($html[0]['price']['oldPrice'])) {
                $prices[] = ['price' => $html[0]['price']['oldPrice'], 'label' => '* Najniższa cena z 30 dni przed obniżką'];
            }
            // Przetwarzanie atrybutów
            $attributes = [];
            if (isset($html[0]['keyfacts']['description'])) {
                $attributesText = str_replace(['#0050aa'], ['white'], $html[0]['keyfacts']['description']); // Tablica do przechowywania już dodanych atrybutów
                $attributes = $attributesText;
            } else {
                $attributesText = str_replace(['#0050aa'], ['white'], $html[0]['keyfacts']['supplementalDescription']); // Tablica do przechowywania już dodanych atrybutów
                $attributes = $attributesText;
            }

            //dd($existingAttributes);

            $imageUrl = $html[0]['image'];
            $offerUrl = 'https://www.lidl.pl' . $html[0]['canonicalPath'];

        }


// Tworzenie struktury danych do zwrócenia
        $dataArray = [
            'promoCode' => $promoCode,
            'h1Tag' => $h1Tag,
            'priceWhole' => $priceWhole,
            'priceRest' => $priceRest,
            'attributes' => $attributes,
            'prices' => $prices,
            'imageUrl' => $imageUrl,
            'offerUrl' => $offerUrl,
            'store' => $store,

        ];

        return $dataArray;


    }
}

if (! function_exists('bgRemover')) {
    function bgRemover($imageUrl)
    {
        $client = new Client();
        $res = $client->post('https://api.remove.bg/v1.0/removebg', [
            'multipart' => [
                [
                    'name' => 'image_file',
                    'contents' => fopen($imageUrl, 'r')
                ],
                [
                    'name' => 'size',
                    'contents' => 'auto'
                ]
            ],
            'headers' => [
                'X-Api-Key' => 'jnFLRVmii2udmB3AGN9MWQZo'
            ]
        ]);

        $fp = fopen("assets/image/templates/mediaexpert-1.png", "wb");
        fwrite($fp, $res->getBody());
        fclose($fp);

        return 'assets/image/templates/mediaexpert-1.png';
    }
}

if (! function_exists('region')) {
    function region($store, $url, $filename = 2, $affUrl = null, $x = 10, $y = 10, $width = 440, $height = 580, $class = 'link')
    {
        if ($affUrl === null) {
            if($store === 'media-expert') {
                $affUrl = 'https://clkpl.tradedoubler.com/click?p(237638)a(2387415)g(21260760)url(' . $url . ')';
            }
            if($store === 'rtveuroagd') {
                $affUrl = 'https://clkpl.tradedoubler.com/click?p(118512)a(2387415)g(18030892)url(' . $url . ')';
            }
            if($store === 'home-you') {
                $affUrl = 'https://clkpl.tradedoubler.com/click?p(330299)a(2387415)g(25241040)url(' . $url . ')';
            }
            if($store === 'lidl') {
                $affUrl = 'https://clkpl.tradedoubler.com/click?p(298327)a(2387415)g(24558098)url(' . $url . ')';
            }
        }
        $fileDataArray = array();
        $dataArray = array(
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height,
            'class'=> $class,
            'data' => array(
                'url' => $affUrl)
        );
        $fileDataArray[] = $dataArray;
        $fileDataJson = json_encode($fileDataArray);
        $fp = fopen(storage_path('app/public/regions/'.$store.'/'.$filename.'.json'), "wb");
        fputs($fp, $fileDataJson);
        fclose($fp);

    }

}
