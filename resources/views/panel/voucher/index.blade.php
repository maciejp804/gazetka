<x-layout-panel>

    <x-header-back/>

    <header class="flex justify-between bg-white shadow mb-6">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Vouchers</h1>
        </div>
        <div class="flex items-center px-4">
            <x-buttons.primary-a :url="route('vouchers.create')">Dodaj voucher</x-buttons.primary-a>
        </div>

    </header>
    <div class="mx-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($vouchers as $voucher)
                @php
                    $imagePath = $voucher->image ? $voucher->image . '.webp' : null;
                    $imageStorePath = $voucher->voucherStore->image ?  $voucher->voucherStore->image . '.webp' : null;
                @endphp
                <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between hover:shadow-md transition">
                    <div class="grid grid-cols-3">
                        <div class="col-span-2">
                            @if($imagePath && Storage::disk('public')->exists($imagePath))
                                <picture>
                                    <source srcset="{{ Storage::url($voucher->image.'.avif') }}" type="image/avif">
                                    <source srcset="{{ Storage::url($voucher->image.'.webp') }}" type="image/webp">
                                    <img src="{{ Storage::url($voucher->image.'.jpg') }}"
                                         class="w-20 h-20 rounded-full object-cover"
                                         width="120" height="120"
                                         alt="{{$voucher->name}}">
                                </picture>
                            @else
                                {{-- Przycisk "Dodaj grafikę" --}}
                                <form action="{{ route('vouchers.uploadImage', $voucher) }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 border border-dashed border-gray-300 relative group overflow-hidden">
                                    @csrf
                                    <label for="upload-offer-{{ $voucher->id }}" class="cursor-pointer flex flex-col items-center justify-center text-gray-500 text-sm group-hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Oferta
                                    </label>
                                    <input id="upload-offer-{{ $voucher->id }}" type="file" name="image" class="hidden" onchange="this.form.submit()">
                                </form>
                            @endif
                        </div>
                        <div class="col-span-1">
                            @if($imageStorePath && Storage::disk('public')->exists($imageStorePath))
                                <img src="{{ asset('storage/' . $voucher->voucherStore->image.'.webp') }}" alt="Miniatura" class="h-20 object-contain rounded-full  mx-auto">
                            @else
                                {{-- Przycisk "Dodaj grafikę" --}}
                                <form action="{{ route('vouchers.uploadLogo', $voucher) }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 border border-dashed border-gray-300 relative group overflow-hidden">
                                    @csrf
                                    <label for="upload-logo-{{ $voucher->id }}" class="cursor-pointer flex flex-col items-center justify-center text-gray-500 text-sm group-hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Logo
                                    </label>
                                    <input id="upload-logo-{{ $voucher->id }}" type="file" name="imageLogo" class="hidden" onchange="this.form.submit()">
                                </form>
                            @endif

                        </div>

                    </div>
                    <div class="text-center">
                        <h2 class="font-bold text-lg mb-1">{{ $voucher->title }}</h2>
                        <p class="text-gray-500 text-sm">{{ $voucher->description}}</p>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('vouchers.edit', ['voucher' => $voucher]) }}" class="inline-block text-sm px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Edytuj
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</x-layout-panel>
