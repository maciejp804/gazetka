<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Shop;
use App\Models\VoucherStore;
use App\Services\ImageService;
use App\Services\VoucherImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoucherStoreController extends Controller
{

    protected ImageService $imageService;
    protected VoucherImportService $voucherImportService;
    public function __construct(ImageService $imageService, VoucherImportService $voucherImportService)
    {
        $this->imageService = $imageService;
        $this->voucherImportService = $voucherImportService;
    }

    public function create()
    {
        $shops = Shop::where('status', 'active')->get();
        $categories = Category::where("type", "voucher_shop")->get();
        return view('admin.voucher.store.create', [
            'shops' => $shops,
            'categories' => $categories
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'shop_id' => 'integer',
            'category_id' => 'required|integer',
            'name' => 'required|string|max:60',
            'program_id' => 'required|string|max:60',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive,draft',
        ]);

        if ($validated['shop_id'] == 0)
        {
            $validated['shop_id'] = NULL;
        }

        if ($request->hasFile('image')) {
            $path = 'images/vouchers/logo/logo_' . uniqid();
            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path,
                120,
                44
            );
            if (!empty($result)) {
                $validated['image'] = $path;
            }
        }

        VoucherStore::create([
            'shop_id' => $validated['shop_id'],
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'program_id' => $validated['program_id'],
            'status' => $validated['status'],
            'image' => $validated['image'],
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Sklep dla Voucherów został dodany');
    }


    public function import(Request $request)
    {
        $logos = $this->voucherImportService->importLogosFromTradedoubler();

        return !empty($logos)
            ? response()->json(['logos' => $logos])
            : response()->json(['error' => 'Brak wyników lub błąd pobierania'], 500);
    }

    public function updateTradedoubler(Request $request)
    {
        $logos = [];
        $results = $this->voucherImportService->updateLogosFromTradedoubler();

        Log::info('🔁 Start importu voucherów', ['total' => count($results)]);

        foreach ($results as $item) {
            Log::debug('➡️ Przetwarzam programId', ['programId' => $item['programId']]);

            $voucherStore = VoucherStore::where('program_id', $item['programId'])->first();

            $logoUrl = $item['logoPath'] ?? null;
            $image = null;
            $result = [];
            $path = null;
            if (!empty($logoUrl) && $logoUrl !== 'http://' && filter_var($logoUrl, FILTER_VALIDATE_URL)) {
                $path = 'images/vouchers/logo/logo_' . uniqid();
                $result = $this->imageService->convertAndStore(
                    $logoUrl,
                    $path,
                    120,
                    44
                );

                $image = $result['webp_path'] ?? null;
                if (empty($image)) {
                    Log::warning('⚠️ Nieprawidłowy adres logo', ['image' => $image]);
                    $path = null;
                }
                Log::debug('✅ Obraz przetworzony', ['image' => $image]);
            } else {
                Log::warning('⚠️ Nieprawidłowy adres logo', ['logoPath' => $logoUrl]);
            }

            if (empty($voucherStore)) {
                Log::info('🛠 Tworzę nowy VoucherStore', [
                    'name' => $item['programName'],
                    'program_id' => $item['programId'],
                    'image' => $image
                ]);
                try {
                    $voucherStoreCreate = VoucherStore::create([
                        'category_id' => 36,
                        'name' => $item['programName'],
                        'program_id' => $item['programId'],
                        'image' => $path,
                        'status' => 'active',
                        'created_at' => now('Europe/Warsaw'),
                        'updated_at' => now('Europe/Warsaw'),
                    ]);

                    Log::info('🆕 Utworzono nowy VoucherStore', ['programId' => $item['programId']]);
                    $logos[] = [
                        'programId' => $item['programId'],
                        'store' => $voucherStoreCreate->name,
                        'image' => $image,
                    ];

                } catch (\Throwable $e) {
                    Log::error('❌ Błąd przy tworzeniu VoucherStore', [
                        'programId' => $item['programId'],
                        'message' => $e->getMessage()
                    ]);
                }


            } else {
                if (!empty($image)) {
                    $voucherStore->update([
                        'image' => $path,
                        'updated_at' => now('Europe/Warsaw'),
                    ]);

                    Log::info('♻️ Zaktualizowano logo VoucherStore', ['programId' => $item['programId']]);

                    $logos[] = [
                        'programId' => $item['programId'],
                        'store' => $voucherStore->name,
                        'image' => $image,
                    ];
                }
            }
        }

        Log::info('✅ Import zakończony', [
            'z_logo' => count($logos),
            'wszystkie_programy' => count($results),
            'voucherStore_w_bazie' => VoucherStore::count(),
        ]);

        return !empty($logos)
            ? response()->json(['logos' => $logos])
            : response()->json(['error' => 'Brak wyników lub błąd pobierania'], 500);
    }

    public function updateTradetracker(Request $request)
    {
        $logos = [];
        $results = $this->voucherImportService->updateLogosFromTradetracker();

        Log::info('🔁 Start importu voucherów', ['total' => count($results)]);

        foreach ($results as $item) {
            Log::debug('➡️ Przetwarzam programId', ['programId' => $item['campaignID']]);

            $voucherStore = VoucherStore::where('program_id', $item['campaignID'])->first();

            $logoUrl = $item['images'][0] ?? null;
            $image = null;
            $result = [];
            $path = null;
            if (!empty($logoUrl) && $logoUrl !== 'http://' && filter_var($logoUrl, FILTER_VALIDATE_URL)) {
                $path = 'images/vouchers/logo/logo_' . uniqid();
                $result = $this->imageService->convertAndStore(
                    $logoUrl,
                    $path,
                    120,
                    44
                );

                $image = $result['webp_path'] ?? null;
                if (empty($image)) {
                    Log::warning('⚠️ Nieprawidłowy adres logo', ['image' => $image]);
                    $path = null;
                }
                Log::debug('✅ Obraz przetworzony', ['image' => $image]);
            } else {
                Log::warning('⚠️ Nieprawidłowy adres logo', ['logoPath' => $logoUrl]);
            }

            if (empty($voucherStore)) {
                Log::info('🛠 Tworzę nowy VoucherStore', [
                    'name' => $item['properties']['campaignName'],
                    'program_id' => $item['campaignID'],
                    'image' => $image
                ]);
                try {
                    $voucherStoreCreate = VoucherStore::create([
                        'category_id' => 36,
                        'name' => $item['properties']['campaignName'][0],
                        'program_id' => $item['campaignID'],
                        'image' => $path,
                        'status' => 'active',
                        'created_at' => now('Europe/Warsaw'),
                        'updated_at' => now('Europe/Warsaw'),
                    ]);

                    Log::info('🆕 Utworzono nowy VoucherStore', ['programId' => $item['campaignID']]);
                    $logos[] = [
                        'programId' => $item['campaignID'],
                        'store' => $voucherStoreCreate->name,
                        'image' => $image,
                    ];

                } catch (\Throwable $e) {
                    Log::error('❌ Błąd przy tworzeniu VoucherStore', [
                        'programId' => $item['campaignID'],
                        'message' => $e->getMessage()
                    ]);
                }


            } else {
                if (!empty($image)) {
                    $voucherStore->update([
                        'image' => $path,
                        'updated_at' => now('Europe/Warsaw'),
                    ]);

                    Log::info('♻️ Zaktualizowano logo VoucherStore', ['programId' => $item['campaignID']]);

                    $logos[] = [
                        'programId' => $item['campaignID'],
                        'store' => $voucherStore->name,
                        'image' => $image,
                    ];
                }
            }
        }

        Log::info('✅ Import zakończony', [
            'z_logo' => count($logos),
            'wszystkie_programy' => count($results),
            'voucherStore_w_bazie' => VoucherStore::count(),
        ]);

        return !empty($logos)
            ? response()->json(['logos' => $logos])
            : response()->json(['error' => 'Brak wyników lub błąd pobierania'], 500);

    }
}
