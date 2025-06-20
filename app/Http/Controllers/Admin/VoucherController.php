<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Voucher;
use App\Models\VoucherStore;
use App\Services\ImageService;
use App\Services\VoucherImportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VoucherController extends Controller
{


    protected ImageService $imageService;
    protected VoucherImportService $voucherImportService;
    public function __construct(ImageService $imageService, VoucherImportService $voucherImportService)
    {
        $this->imageService = $imageService;
        $this->voucherImportService = $voucherImportService;
    }

    public function index(Request $request)
    {

        $vouchers = Voucher::with('voucherStore')->get();
        return view('admin.voucher.index',['vouchers'=>$vouchers]);
    }
    public function create()
    {
        $stores = VoucherStore::where('status', 'active')->get();
//        $voucher = Voucher::where('status', 'active')->find(1);
        $categories = Category::where('status', 'active')->where('type', 'voucher')->get();
        return view('admin.voucher.create', [
//          'voucher' => $voucher,
            'stores' => $stores,
            'categories' => $categories,
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'code' => 'nullable|string|max:255',
            'conditions' => 'nullable|string|max:255',
            'status' => 'required|in:active,expired,draft',
            'is_featured' => 'nullable|boolean',
            'voucher_store_id' => 'required|exists:voucher_stores,id',
            'category_id' => 'required|exists:categories,id',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = 'images/vouchers/offers/offer_' . uniqid();
            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path,
                120,
                120
            );
            if (!empty($result)) {
                $validated['image'] = $path;
            }
        }

        Voucher::create([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'url' => $validated['url'],
            'code' => $validated['code'],
            'conditions' => $validated['conditions'],
            'status' => $validated['status'],
            'is_featured' => $validated['is_featured'] ?? 0,
            'voucher_store_id' => $validated['voucher_store_id'],
            'category_id' => $validated['category_id'],
            'valid_from' => $validated['valid_from'],
            'valid_to' => $validated['valid_to'],
            'image' => $validated['image'],
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Kupon został dodany.');
    }

    public function edit(Voucher $voucher)
    {
        $stores = VoucherStore::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->where('type', 'voucher')->get();

        return view('admin.voucher.edit', [
            'voucher' => $voucher,
            'stores' => $stores,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Voucher $voucher)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'body' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'code' => 'nullable|string|max:255',
            'conditions' => 'nullable|string|max:255',
            'status' => 'required|in:active,expired,draft',
            'is_featured' => 'nullable|boolean',
            'voucher_store_id' => 'required|exists:voucher_stores,id',
            'category_id' => 'required|exists:categories,id',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = 'images/vouchers/offers/offer_' . uniqid();
            $result = app(ImageService::class)->convertAndStore(
                $request->file('image')->getContent(),
                $path,
                120,
                120
            );
            if (!empty($result)) {
                $validated['image'] = $path;
            }
        }

        $voucher->update($validated);

        return redirect()->route('admin.vouchers.index')->with('update', 'Kupon został zaktualizowany.');
    }

    public function destroy(Voucher $voucher)
    {
        // Jeśli chcesz też usunąć obrazek ze storage
        if ($voucher->image && Storage::disk('public')->exists($voucher->image . '.webp')) {
            Storage::disk('public')->delete([$voucher->image . '.webp', $voucher->image . '.avif', $voucher->image . '.jpg']);
        }

        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Sieć została usunięta.');
    }


    public function uploadImage(Request $request, Voucher $voucher)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $pathWithoutExtension = 'images/vouchers/offers/offer_' . uniqid();

        $result = app(ImageService::class)->convertAndStore(
            $request->file('image')->getContent(),
            $pathWithoutExtension,
            120,
            120
        );

        if (!empty($result)) {
            // zapisujemy tylko path bez rozszerzenia
            $voucher->update([
                'image' => $pathWithoutExtension
            ]);
        }

        return back()->with('success', 'Grafika została zapisana.');
    }

    public function uploadLogo(Request $request, Voucher $voucher)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);
        $voucher = Voucher::with('voucherStore')->find($voucher->id);

        $pathWithoutExtension = 'images/vouchers/logo/logo_' . uniqid();

        $result = app(ImageService::class)->convertAndStore(
            $request->file('image')->getContent(),
            $pathWithoutExtension,
            120,
            120
        );



        if (!empty($result)) {

            if($voucher->voucherStore->image)
            {
                Storage::disk('public')->delete([
                    $voucher->voucherStore->image . '.webp', $voucher->voucherStore->image . '.jpg', $voucher->voucherStore->image . '.avif'
                ]);
            }

            // zapisujemy tylko path bez rozszerzenia
            $voucher->voucherStore->update([
                'image' => $pathWithoutExtension
            ]);
        }

        return back()->with('success', 'Grafika została zapisana.');
    }


}
