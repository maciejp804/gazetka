<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\VoucherStore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VoucherService
{

    protected VoucherImportService $voucherImportService;

    public function __construct(VoucherImportService $voucherImportService)
    {
        $this->voucherImportService = $voucherImportService;
    }

    public function updateVouchersTradedoubler()
    {
        $logos = [];
        $results = $this->voucherImportService->updateVouchersFromTradedoubler();

        Log::info('🔁 Start importu voucherów', ['total' => count($results)]);
        $dispatchedCount = 0;
        foreach ($results as $item) {

            Log::debug('➡️ Przetwarzam ID', ['ID' => $item['id']]);

            $vouchers = Voucher::where('voucher_id', $item['id'])->first();
            $code = $item['code'] ?? null;

//                    $conditions = '' ?? null;

            if (empty($vouchers)) {
                Log::info('🛠 Tworzę nowy Voucher', [
                    'name' => $item['programName'],
                    'ID' => $item['id'],
                ]);
                try {
                    $voucherStore = VoucherStore::where('program_id', $item['programId'])->first();

                    $voucherCreate = Voucher::create([
                        'category_id' => 36,
                        'voucher_store_id' => $voucherStore->id,
                        'voucher_id' => $item['id'],
                        'title' => $item['title'],
                        'body' => $item['description'],
                        'url' => $item['defaultTrackUri'],
                        'code' => $code,
//                        'conditions' => $conditions,
                        'valid_from' =>  Carbon::parse($item['publishStartDate']) ?: null,
                        'valid_to' =>  Carbon::parse($item['publishEndDate']) ?: null,
                        'created_at' => now('Europe/Warsaw'),
                        'updated_at' => now('Europe/Warsaw'),
                    ]);

                    Log::info('🆕 Utworzono nowy Voucher', ['programId' => $item['id']]);
                    $logos[] = [
                        'programId' => $item['id'],
                        'voucher' => $voucherCreate->voucher_store_id,
                        'description' =>  $item['description'],
                    ];

                } catch (\Throwable $e) {
                    Log::error('❌ Błąd przy tworzeniu Voucher', [
                        'programId' => $item['id'],
                        'message' => $e->getMessage()
                    ]);
                }

            } else {
                $vouchers->update([
                    'title' => $item['title'],
                    'body' => $item['description'],
                    'url' => $item['defaultTrackUri'],
                    'code' => $code,
//                    'conditions' => $conditions,
                    'valid_from' =>  Carbon::parse($item['publishStartDate']) ?: null,
                    'valid_to' =>  Carbon::parse($item['publishEndDate']) ?: null,
                    'updated_at' => now('Europe/Warsaw'),
                ]);
                Log::info('♻️ Zaktualizowano Voucher', ['programId' => $item['id']]);

                $logos[] = [
                    'programId' => $vouchers->id,
                    'voucher' => $vouchers->voucher_store_id,
                    'description' => $item['description'],
                ];
            }
            $dispatchedCount++;
        }

        Log::info('✅ Import zakończony', [
            'z_logo' => count($logos),
            'wszystkie_programy' => count($results),
            'voucherStore_w_bazie' => Voucher::count(),
        ]);

        Voucher::where('valid_to', '<', now())->delete();

        return $dispatchedCount;
    }

    public function updateVouchersTradetracker()
    {
        $logos = [];
        $results = $this->voucherImportService->updateVouchersFromTradetracker();

        Log::info('🔁 Start importu voucherów', ['total' => count($results)]);
        $dispatchedCount = 0;
        foreach ($results as $item) {
            Log::debug('➡️ Przetwarzam ID', ['ID' => $item['ID']]);

            $vouchers = Voucher::where('voucher_id', $item['ID'])->first();

            $code = $item['properties']['voucherCode'][0] ?? null;

            $conditions = $item['properties']['conditions'][0] ?? null;

            if (empty($vouchers)) {
                Log::info('🛠 Tworzę nowy VoucherStore', [
                    'name' => $item['properties']['campaignName'][0],
                    'ID' => $item['ID'],
                ]);
                try {
                    $voucherStore = VoucherStore::where('program_id', $item['campaignID'])->first();

                    $voucherCreate = Voucher::create([
                        'category_id' => 36,
                        'voucher_store_id' => $voucherStore->id,
                        'voucher_id' => $item['ID'],
                        'title' => $item['name'],
                        'body' => $item['description'],
                        'url' => $item['URL'],
                        'code' => $code,
                        'conditions' => $conditions,
                        'valid_from' => $item['properties']['validFromDate'][0] ?: null,
                        'valid_to' => $item['properties']['validToDate'][0] ?: null,
                        'created_at' => now('Europe/Warsaw'),
                        'updated_at' => now('Europe/Warsaw'),
                    ]);

                    Log::info('🆕 Utworzono nowy Voucher', ['programId' => $item['ID']]);
                    $logos[] = [
                        'programId' => $item['ID'],
                        'voucher' => $voucherCreate->voucher_store_id,
                        'description' =>  $item['description'],
                    ];

                } catch (\Throwable $e) {
                    Log::error('❌ Błąd przy tworzeniu Voucher', [
                        'programId' => $item['ID'],
                        'message' => $e->getMessage()
                    ]);
                }

            } else {
                $vouchers->update([
                    'title' => $item['name'],
                    'body' => $item['description'],
                    'url' => $item['URL'],
                    'code' => $code,
                    'conditions' => $conditions,
                    'valid_from' => $item['properties']['validFromDate'][0] ?: null,
                    'valid_to' => $item['properties']['validToDate'][0] ?: null,
                    'updated_at' => now('Europe/Warsaw'),
                ]);
                Log::info('♻️ Zaktualizowano Voucher', ['programId' => $item['ID']]);

                $logos[] = [
                    'programId' => $vouchers->id,
                    'voucher' => $vouchers->voucher_store_id,
                    'description' => $item['description'],
                ];
            }
            $dispatchedCount++;
        }

        Log::info('✅ Import zakończony', [
            'z_logo' => count($logos),
            'wszystkie_programy' => count($results),
            'voucherStore_w_bazie' => Voucher::count(),
        ]);

        Voucher::where('valid_to', '<', now())->delete();

        return $dispatchedCount;
    }

}
