<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Encoders\AvifEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{


    public function  calculateDimensionsFromUrl(string $imageUrl, int $width = 1040, int $height = 1500): ?array
    {
        $response = Http::get($imageUrl);

        if ($response->failed()) {
            return null;
        }

        $image = Image::read($response->body());

        return $this->calculateDimensions($image, $width, $height);
    }



    /**
     * Przelicza proporcjonalnie nowe wymiary obrazu z ograniczeniami max: 1040x1500
     */
    public function calculateDimensions($image, int $width, int $height): array

    {
        $originalWidth = $image->width();
        $originalHeight = $image->height();
        $ratio = $originalWidth / $originalHeight;

        if ($originalWidth > $originalHeight) {
            $newWidth = $width;
            $newHeight = (int) round($width / $ratio);
            if ($newHeight > $height) {
                $newHeight = $height;
                $newWidth = (int) round($height * $ratio);
            }
        } else {
            $newHeight = $height;
            $newWidth = (int) round($height * $ratio);
            if ($newWidth > $width) {
                $newWidth = $width;
                $newHeight = (int) round($width / $ratio);
            }
        }

        return [$newWidth, $newHeight];
    }

    /**
     * Skaluje i zapisuje obraz jako WebP i AVIF w `storage/app/public/...`
     */
    public function convertAndStore($source, $pathWithoutExtension, int $width = 1040, int $height = 1500): array
    {

        try {

            // 1. Rozpoznanie, czy źródło to URL
            if (Str::startsWith($source, ['http://', 'https://'])) {
                $response = Http::get($source);

                if ($response->failed()) {
                    Log::warning('❌ Nie udało się pobrać obrazu z URL', ['url' => $source]);
                    return [];
                }

                $image = Image::read($response->body());
            } else {
                // 2. Jeśli nie URL, zakładamy że to już jest zawartość pliku
                $image = Image::read($source);
            }

            [$newWidth, $newHeight] = $this->calculateDimensions($image, $width, $height);

            $image->resize($newWidth, $newHeight);

            $jpgPath = $pathWithoutExtension . '.jpg';
            $jpgImage = $image->encode(new JpegEncoder(quality: 65));
            Storage::disk('public')->put($jpgPath, (string) $jpgImage);


            // WebP
            $webpPath = $pathWithoutExtension . '.webp';
            $webpImage = $image->encode(new WebpEncoder(quality: 80));
            Storage::disk('public')->put($webpPath, (string) $webpImage);

            // AVIF
            $avifPath = $pathWithoutExtension . '.avif';
            $avifImage = $image->encode(new AvifEncoder(quality: 80));
            Storage::disk('public')->put($avifPath, (string) $avifImage);

            return [
                'width' => $newWidth,
                'height' => $newHeight,
                'jpg_path' => $jpgPath,
                'webp_path' => $webpPath,
                'avif_path' => $avifPath,
            ];
        } catch (\Throwable $e) {
            Log::warning('❌ Nie udało się pobrać obrazu', ['url' => $imageUrl]);
            return [];
        }
    }
}

