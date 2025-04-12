<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class BackController extends Controller
{

    public function index()
    {
        return view('panel.index');
    }

    public function clickableIndex($shop=null)
    {

        return view('shops.index', data:
            [
                'data' => '',
                'shop' => $shop,
                'image' => '',
            ]);
    }

    public function generator(Request $request)
    {

        if ($_POST['productId'] !== ''){

            switch ($_POST['store']) {
                case 'rtveuroagd':

                    $url_api = "https://www.euro.com.pl/rest/api/products/".$_POST['productId']."/";

                    $scrapedContent = json_decode(getScrapedContent($url_api), true);

                    $data = findTag($scrapedContent, $_POST['store']);
                    $urlOffer = $data['offerUrl'];
                    break;
                case 'lidl':

                    $url_api = "https://www.lidl.pl/p/api/gridboxes/PL/pl?erpNumbers=".$_POST['productId'];
                    $scrapedContent = json_decode(getScrapedContent($url_api), true);
                    $data = findTag($scrapedContent, $_POST['store']);
                    $urlOffer = $data['offerUrl'];
                    break;
            }

        } else {

            // Pobierz zawartość strony za pomocą Scraping API
            $scrapedContent = getScrapedContent($_POST['url']);

            // Przykładowa logika przetwarzania:
            $data = findTag($scrapedContent, $_POST['store']);

            $urlOffer = $_POST['url'];
        }
        $file = $request->file('photo');


        if ($file === null) {
            // Usuwanie tła białego i wstawienie przeźroczystego
            $image = bgRemover($data['imageUrl']);
        } else {
            // Zapisz plik do katalogu na serwerze
            $fileName = $file->getClientOriginalName(); // Pobierz oryginalną nazwę pliku
            $file->move(public_path('uploads'), $fileName); // Zapisz plik w katalogu "uploads" w katalogu publicznym
            $image = 'uploads/'.$fileName;

        }

        // Tworzenie pliku z regionem
        region($_POST['store'], $urlOffer, $_POST['filename']);

        // Zwróć widok lub odpowiedź HTTP w zależności od potrzeb


        return view('components.back-end.'.$_POST['store'].'.one',compact('data', 'image'));
    }






}
