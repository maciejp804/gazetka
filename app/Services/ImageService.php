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

            // JPG
            $jpgPath = $pathWithoutExtension . '.jpg';
            $jpgImage = $image->encode(new JpegEncoder(quality: 65));
            Storage::disk('public')->put($jpgPath, (string) $jpgImage);

            // WebP
            $webpPath = $pathWithoutExtension . '.webp';
            $webpImage = $image->encode(new WebpEncoder(quality: 80));
            Storage::disk('public')->put($webpPath, (string) $webpImage);

            // AVIF tylko poza "blogs"
            if (!str_contains($pathWithoutExtension, 'blogs')) {
                $avifPath = $pathWithoutExtension . '.avif';
                $avifImage = $image->encode(new AvifEncoder(quality: 80));
                Storage::disk('public')->put($avifPath, (string) $avifImage);
            }

            return [
                'width' => $newWidth,
                'height' => $newHeight,
                'jpg_path' => $jpgPath,
                'webp_path' => $webpPath,
                'avif_path' => $avifPath ?? null,
            ];

        } catch (\Throwable $e) {
            Log::warning('❌ Nie udało się przetworzyć obrazu', [
                'source' => $source,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }


    public function cropAndStore($source, $pathWithoutExtension, int $x, int $y, int $width, int $height, int $imageWidth, int $imageHeight): array
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
            [$cropX, $cropY, $cropWidth, $cropHeight] = $this->calculateImageDimensions($image->width(), $image->height(), $imageWidth, $imageHeight, $x, $y, $width, $height);
//            dd($cropX, $cropY, $cropWidth, $cropHeight);

            // 3. Przycinanie obrazu na podstawie współrzędnych


            $image->crop($cropWidth, $cropHeight, $cropX, $cropY);

            // 4. Zapisz obraz w formacie JPG
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
                'path' => $pathWithoutExtension
            ];
        } catch (\Throwable $e) {
            Log::warning('❌ Nie udało się obciąć obrazu', ['url' => $source, 'error' => $e->getMessage()]);
            return [];
        }
    }

    public function calculateImageDimensions(int $naturalWidth, int $naturalHeight, int $imageWidth, int $imageHeight, int $x, int $y, int $width, int $height): array
    {
        // Obliczanie współrzędnych przycięcia w oryginalnych wymiarach obrazu
        $cropX = round(($naturalWidth * $x) / $imageWidth);
        $cropY = round(($naturalHeight * $y) / $imageHeight);

        // Obliczanie szerokości i wysokości przycięcia w oryginalnych wymiarach obrazu
        $cropWidth = round(($width * $naturalWidth) / $imageWidth);
        $cropHeight = round(($height * $naturalHeight) / $imageHeight);

        return [$cropX, $cropY, $cropWidth, $cropHeight];
    }
}

