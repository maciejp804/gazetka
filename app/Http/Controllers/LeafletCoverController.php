<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Leaflet;
use App\Models\LeafletCover;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Encoders\AvifEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;

class LeafletCoverController extends Controller
{
    public function storeCover(Request $request, Leaflet $leaflet)
    {
        $file = $request->file('cover_image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = 'leaflets/covers/' . $filename;

        // Zapis oryginalnego obrazu
        Storage::disk('public')->put($path, file_get_contents($file));

        // Konwersja do WebP i AVIF (poprawiona wersja)
        $webpPath = 'leaflets/covers/' . time() . '.webp';
        $avifPath = 'leaflets/covers/' . time() . '.avif';

        $image = Image::read($file);
        $webpImage = $image->encode('webp', 80);
        $avifImage = $image->encode('avif', 80);

        Storage::disk('public')->put($webpPath, (string) $webpImage);
        Storage::disk('public')->put($avifPath, (string) $avifImage);





        // Zapis do bazy danych
        $cover = LeafletCover::create([
            'leaflet_id' => $leaflet->id,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'webp_path' => $webpPath,
            'avif_path' => $avifPath,
            'width' => $image->width(),
            'height' => $image->height(),
            'alt_text' => 'Okładka gazetki ' . $leaflet->title
        ]);

        return response()->json(['message' => 'Okładka dodana!', 'cover' => $cover]);
    }

    public function storeCoverFromUrl(Request $request)
    {

        $leaflets = Leaflet::with('shop')->where('valid_from', '>=', '2024-12-31')->where('valid_to', '>=', now())->get();

//        $leaflets = Leaflet::with('shop')->get();

        foreach ($leaflets as $leaflet) {
            // URL obrazu (otrzymany w request lub wpisany na sztywno dla testów)

            $imageUrl = $leaflet->image_cover;

            // Pobierz zawartość obrazu przez HTTP
            $response = Http::get($imageUrl);

            if ($response->failed()) {
                return response()->json(['error' => 'Nie udało się pobrać obrazu'], 400);
            }

            // Zapisz plik tymczasowo
            $filename = uniqid() . '.jpg';
            $path = 'leaflets/covers/' . $filename;
            Storage::disk('public')->put($path, $response->body());

            // Wczytaj obraz do przetwarzania
            $image = Image::read(storage_path('app/public/' . $path));

            // Konwersja do WebP
            $webpPath = 'leaflets/covers/' . uniqid() . '.webp';
            $webpImage = $image->encode(new WebpEncoder(quality: 80));
            Storage::disk('public')->put($webpPath, (string)$webpImage);

            // Konwersja do AVIF
            $avifPath = 'leaflets/covers/' . uniqid() . '.avif';
            $avifImage = $image->encode(new AvifEncoder(quality: 80));
            Storage::disk('public')->put($avifPath, (string)$avifImage);


            // Zapis do bazy danych
            $cover = LeafletCover::create([
                'leaflet_id' => $leaflet->id,
                'original_name' => '1.jpg',
                'path' => $path,
                'webp_path' => $webpPath,
                'avif_path' => $avifPath,
                'width' => $image->width(),
                'height' => $image->height(),
                'alt_text' => 'Okładka gazetki ' . $leaflet->title
            ]);


        }


        return response()->json(['message' => 'Okładka dodana!', 'cover' => $cover]);
    }

    public function storePage()
    {
        $leaflets = Leaflet::with('shop')
            ->where('valid_from', '>=', '2024-12-31')
            ->where('valid_to', '>=', now())
            ->where('id', 77)
            ->whereHas('shop', function ($query){
                $query->where('id', 4)->orWhere('id', 8);
            })->get();


        foreach ($leaflets as $leaflet) {
            $i = 1;
            $baseUrl = 'https://gazetkapromocyjna.com.pl/' . $leaflet->shop->slug . '/' . $leaflet->number . '/pages/large/';
            $baseUrl = 'https://cdn.ipaper.io/iPaper/Papers/a6f12cf7-5e78-4123-a14c-77dc634f16eb/Pages/'.$i.'/Zoom.jpg?Policy=eyJTdGF0ZW1lbnQiOlt7IlJlc291cmNlIjoiaHR0cHM6Ly9jZG4uaXBhcGVyLmlvL2lQYXBlci9QYXBlcnMvYTZmMTJjZjctNWU3OC00MTIzLWExNGMtNzdkYzYzNGYxNmViL1BhZ2VzLyoiLCJDb25kaXRpb24iOnsiRGF0ZUxlc3NUaGFuIjp7IkFXUzpFcG9jaFRpbWUiOjE3NDI0NDUzMTZ9fX1dfQ__&Signature=Ry2ygFWCPPPsHxr1zcdY-zrc1qHnCpSLGBiVDEjAAMtIgYxd41IFklZvZ69uuSfvOS0FSbFkUNHZ~f4pWLXQg59Pu8ZKeVg~gCoJoHfih~58pRg5J~B4JNTl4Jl8B9yMyFgbc4asbjUJdnhq0IJ-2zWJS1G7xteUAs20o4qCWOQ_&Key-Pair-Id=APKAIPGQN6BDBMBZ2LCA';
            while (true) {
                $imageUrl = $baseUrl . $i . '.jpg';
                $imageUrl = 'https://cdn.ipaper.io/iPaper/Papers/4e51e951-9cc8-41b0-8f2a-c2e8d60e0fde/Pages/'.$i.'/Zoom.jpg?Policy=eyJTdGF0ZW1lbnQiOlt7IlJlc291cmNlIjoiaHR0cHM6Ly9jZG4uaXBhcGVyLmlvL2lQYXBlci9QYXBlcnMvNGU1MWU5NTEtOWNjOC00MWIwLThmMmEtYzJlOGQ2MGUwZmRlL1BhZ2VzLyoiLCJDb25kaXRpb24iOnsiRGF0ZUxlc3NUaGFuIjp7IkFXUzpFcG9jaFRpbWUiOjE3NDI0NDY5OTd9fX1dfQ__&Signature=iRpch0rp2iXpijLnoO-2Fll1fgpr6JOHv8vLVrJ9xHUtYBie2wfQF~6Wrtpt6SjVOvlyHa87ZQ5e0NMogL7~t-rvcos9F0jNX5Q8NC1jyEW2n6h0ub~8~dtI394De4RlXNvf4IT2GPOaVXo6myjtGWn62vjDWRBc~mOXeR03YCk_&Key-Pair-Id=APKAIPGQN6BDBMBZ2LCA';
                // Pobranie obrazu
                $response = Http::get($imageUrl);
                if ($response->failed()) {
                    break; // Jeśli obraz nie istnieje, przerwij pętlę
                }

                $image = Image::read($response->body());

                // Pobierz oryginalne wymiary obrazu
                $originalWidth = $image->width();
                $originalHeight = $image->height();

                // Oblicz współczynnik proporcji
                $ratio = $originalWidth / $originalHeight;

                // Obliczanie nowych wymiarów z zachowaniem proporcji
                if ($originalWidth > $originalHeight) {
                    // Obraz poziomy – max 1040px szerokości
                    $newWidth = 1040;
                    $newHeight = (int) round(1040 / $ratio);
                    if ($newHeight > 1500) {
                        $newHeight = 1500;
                        $newWidth = (int) round(1500 * $ratio);
                    }
                } else {
                    // Obraz pionowy – max 600px wysokości
                    $newHeight = 1500;
                    $newWidth = (int) round(1500 * $ratio);
                    if ($newWidth > 1040) {
                        $newWidth = 1040;
                        $newHeight = (int) round(1040 / $ratio);
                    }
                }

                // Przeskalowanie obrazu do obliczonych wymiarów
                $image = $image->resize($newWidth, $newHeight);

                $path = 'leaflets/pages/' . uniqid();

                // Zapisz plik tymczasowo

                $jpgPath = $path . '.jpg';
                $jpgImage = $image->encode(new JpegEncoder(quality: 65));
                Storage::disk('public')->put($jpgPath, (string) $jpgImage);


                // Konwersja do WebP
                $webpPath = $path . '.webp';
                $webpImage = $image->encode(new WebpEncoder(quality: 70));
                Storage::disk('public')->put($webpPath, (string)$webpImage);

                // Konwersja do AVIF
                $avifPath = $path . '.avif';
                $avifImage = $image->encode(new AvifEncoder(quality: 70));
                Storage::disk('public')->put($avifPath, (string)$avifImage);

                // Usuń oryginalny plik JPG po przetworzeniu (opcjonalnie)
//                Storage::disk('public')->delete($path);

                // Zapis do bazy danych
                $page = Page::create([
                    'page_number' => $i,
                    'image_path' => $path,
                    'width' => $newWidth,
                    'height' => $newHeight
                ]);

                $leaflet->pages()->attach($page->id, ['sort_order' => $i]);

                $i++;
            }
        }


//            // Pobierz zawartość obrazu przez HTTP
//            $response = Http::get($imageUrl);
//
//            if ($response->failed()) {
//                return response()->json(['error' => 'Nie udało się pobrać obrazu'], 400);
//            }
//
//            // Zapisz plik tymczasowo
//            $filename = uniqid() . '.jpg';
//            $path = 'leaflets/covers/' . $filename;
//            Storage::disk('public')->put($path, $response->body());
//
//            // Wczytaj obraz do przetwarzania
//            $image = Image::read(storage_path('app/public/' . $path));
//
//            // Konwersja do WebP
//            $webpPath = 'leaflets/covers/' . uniqid() . '.webp';
//            $webpImage = $image->encode(new WebpEncoder(quality: 80));
//            Storage::disk('public')->put($webpPath, (string)$webpImage);
//
//            // Konwersja do AVIF
//            $avifPath = 'leaflets/covers/' . uniqid() . '.avif';
//            $avifImage = $image->encode(new AvifEncoder(quality: 80));
//            Storage::disk('public')->put($avifPath, (string)$avifImage);
//
//
//            // Zapis do bazy danych
//            $cover = LeafletCover::create([
//                'leaflet_id' => $leaflet->id,
//                'original_name' => '1.jpg',
//                'path' => $path,
//                'webp_path' => $webpPath,
//                'avif_path' => $avifPath,
//                'width' => $image->width(),
//                'height' => $image->height(),
//                'alt_text' => 'Okładka gazetki ' . $leaflet->title
//            ]);



        return response()->json(['message' => 'OK', 'cover' => $newWidth]);
    }


    protected function imageExists($url) {
        $headers = @get_headers($url);
        return $headers && strpos($headers[0], '200') !== false;
    }

}


