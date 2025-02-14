<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Leaflet;
use App\Models\LeafletCover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\AvifEncoder;
use Intervention\Image\Encoders\WebpEncoder;
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

        $leaflets = Leaflet::with('shop')->where('valid_from', '<=', now())->where('valid_to', '>=', now())->get();

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


}
