<?php

namespace App\Services;

use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Collection;

class VoucherImportService
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
           }
    public function importLogosFromTradedoubler(int $width = 120, int $height = 44)
    {
        $token = config('services.tradedoubler.token');
        $url = "https://api.tradedoubler.com/1.0/vouchers.json?token=".$token;

        $response = Http::get($url);

        if ($response->successful()) {
            $array = $response->json();

            $logos = [];

            foreach ($array as $voucher) {
                if (!empty($voucher['logoPath']) && $voucher['logoPath'] !== 'http://') {

                    $imageResponse = Http::get($voucher['logoPath']);

                    if ($imageResponse->failed()) {
                        continue; // pomiń uszkodzony obraz
                    }

                    $path = 'images/vouchers/logo/logo_' . uniqid();

                    $result = $this->imageService->convertAndStore(
                        $voucher['logoPath'], // URL
                        $path,                // ścieżka bez rozszerzenia
                        $width,                  // szerokość
                        $height                    // wysokość
                    );

                    if (!empty($result)) {
                        $logos[] = $result;
                    }
                }
            }

            return response()->json(['logos' => $logos]);
        }

        return response()->json(['error' => 'Błąd pobierania danych-'. $url], 500);
    }

    public function updateLogosFromTradedoubler($programId = null,int $width = 120, int $height = 44): \Illuminate\Support\Collection
    {
        $token = config('services.tradedoubler.token');
        $url = "https://api.tradedoubler.com/1.0/vouchers.json?token={$token}";

        $response = Http::get($url);

        if ($response->failed()) {
            Log::error('Nie udało się pobrać danych z Tradedoubler');
            return collect();
        }

        $programs = [];


        if ($programId) {
            $programs[] = collect($response->json())->firstWhere('programId', $programId);
        } else {
            foreach ($response->json() as $voucher) {
                $programs[] = $voucher;
            }
            $programs = collect($programs)->unique('programId')->values();
        }

        return $programs;
    }

    public function updateLogosFromTradetracker($programId = null,int $width = 120, int $height = 44): \Illuminate\Support\Collection
    {
        $token = config('services.tradetracker.token');
        $url=  "https://pf.tradetracker.net/?aid={$token}&encoding=utf-8&type=json&fid=-5&categoryType=2&additionalType=2";

        $response = Http::get($url);

        if ($response->failed()) {
            Log::error('Nie udało się pobrać danych z Tradedoubler');
            return collect();
        }

        $programs = [];

        if ($programId) {
            $programs[] = collect($response->json())->firstWhere('campaignID', $programId);
        } else {
            foreach ($response->json() as $vouchers) {
                foreach ($vouchers as $voucher) {
                    $programs[] = $voucher;
                }
            }
            $programs = collect($programs)->unique('campaignID')->values();
        }

        return $programs;
    }

    public function updateVouchersFromTradetracker($programId = null,int $width = 120, int $height = 44): \Illuminate\Support\Collection
    {
        $token = config('services.tradetracker.token');
        $url=  "https://pf.tradetracker.net/?aid={$token}&encoding=utf-8&type=json&fid=-5&categoryType=2&additionalType=2";

        $response = Http::get($url);

        if ($response->failed()) {
            Log::error('Nie udało się pobrać danych z Tradedoubler');
            return collect();
        }

        $programs = [];

        if ($programId) {
            $programs[] = collect($response->json())->firstWhere('campaignID', $programId);
        } else {
            foreach ($response->json() as $vouchers) {
                foreach ($vouchers as $voucher) {
                    $programs[] = $voucher;
                }
            }
            $programs = collect($programs)->filter(function ($program) {
                $date = $program['properties']['validToDate'][0] ?? null;
                return $date && now('Europe/Warsaw')->lte($date);
            })->values();
        }

        return $programs;
    }

    public function updateVouchersFromTradedoubler($programId = null,int $width = 120, int $height = 44): \Illuminate\Support\Collection
    {
        $token = config('services.tradedoubler.token');
        $url = "https://api.tradedoubler.com/1.0/vouchers.json?token={$token}";

        $response = Http::get($url);

        if ($response->failed()) {
            Log::error('Nie udało się pobrać danych z Tradedoubler');
            return collect();
        }

        $programs = [];

        if ($programId) {
            $programs[] = collect($response->json())->firstWhere('programId', $programId);
        } else {
            foreach ($response->json() as $voucher) {
                $programs[] = [
                    "id" => $voucher['id'],
                    "sourceId" => $voucher['sourceId'] ?? null,
                    "programId" => $voucher['programId'],
                    "programName" => $voucher['programName'],
                    "updateDate" => Carbon::createFromTimestampMs((int) $voucher['updateDate'])->toDateTimeString(),
                    "publishStartDate" => Carbon::createFromTimestampMs((int) $voucher['publishStartDate'])->toDateTimeString(),
                    "publishEndDate" => Carbon::createFromTimestampMs((int) $voucher['publishEndDate'])->toDateTimeString(),
                    "startDate" => Carbon::createFromTimestampMs((int) $voucher['startDate'])->toDateTimeString(),
                    "endDate" => Carbon::createFromTimestampMs((int) $voucher['endDate'])->toDateTimeString(),
                    "title" => $voucher['title'],
                    "shortDescription" => $voucher['shortDescription'],
                    "description" => $voucher['description'],
                    "voucherTypeId" => $voucher['voucherTypeId'],
                    "defaultTrackUri" => $voucher['defaultTrackUri'],
                    "siteSpecific" => $voucher['siteSpecific'],
                    "landingUrl" => $voucher['landingUrl'] ?? null,
                    "discountAmount" => $voucher['discountAmount'],
                    "isPercentage" => $voucher['isPercentage'],
                    "publisherInformation" => $voucher['publisherInformation'],
                    "languageId" => $voucher['languageId'],
                    "exclusive" => $voucher['exclusive'],
                    "currencyId" => $voucher['currencyId'],
                    "logoPath" => $voucher['logoPath'] ?? null,
                                ];
            }

            $programs = collect($programs)->filter(function ($program) {
                $date =  $program['publishEndDate'] ?? null;
                return $date && now('Europe/Warsaw')->lte($date);
            })->values();
        }

        return $programs;
    }

}

