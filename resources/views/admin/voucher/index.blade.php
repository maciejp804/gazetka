<x-layout-panel>

    <x-admin.header-back/>

    <header class="bg-white shadow mb-6">
        <div class="flex justify-between mx-auto max-w-7xl">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Vouchers</h1>
            </div>
            <div class="flex items-center px-4">
                <x-buttons.primary-a :url="route('admin.vouchers.create')">Dodaj voucher</x-buttons.primary-a>
            </div>
        </div>
    </header>

    <div class="mx-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($vouchers as $voucher)
                @php
                    $imagePath = $voucher->image ? $voucher->image . '.webp' : null;
                    $imageStorePath = $voucher->voucherStore->image ?  $voucher->voucherStore->image . '.webp' : null;
                    $exists = $imagePath && Storage::disk('public')->exists($imagePath);
                    $existsLogo = $imageStorePath && Storage::disk('public')->exists($imageStorePath);
                @endphp
                <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between hover:shadow-md transition">
                    <div class="grid grid-cols-4">
                        <div class="col-span-2 relative flex justify-center">
                            @if($exists)
                                    <img src="{{ Storage::url($voucher->image.'.webp') }}"
                                         class="w-full h-full object-cover"
                                         width="120" height="120"
                                         alt="{{$voucher->name}}">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <form action="{{ route('admin.vouchers.upload.image', $voucher) }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 bg-opacity-50 border border-dashed border-gray-300 relative group overflow-hidden">
                                            @csrf
                                            <label for="upload-offer-{{ $voucher->id }}" class="cursor-pointer flex flex-col items-center justify-center text-gray-500 text-1xs group-hover:text-blue-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Edytuj zdjęcie
                                            </label>
                                            <input id="upload-offer-{{ $voucher->id }}" type="file" name="image" class="hidden" onchange="this.form.submit()">
                                        </form>
                                    </div>
                            @else
                                {{-- Przycisk "Dodaj grafikę" --}}
                                <form action="{{ route('admin.vouchers.upload.image', $voucher) }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 border border-dashed border-gray-300 relative group overflow-hidden">
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
                        <div class="col-span-2 relative flex justify-center">
                            <img src="{{ Storage::url($voucher->voucherStore->image.'.webp') }}"
                                 class="w-full h-20 object-cover"
                                 alt="{{ $voucher->voucherStore->name }}">

                            <div class="absolute inset-0 flex items-center justify-center">
                                <form action="{{ route('admin.vouchers.upload.logo', $voucher) }}" method="POST" enctype="multipart/form-data"
                                      class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 bg-opacity-50 border border-dashed border-gray-300 relative group overflow-hidden">
                                    @csrf
                                    <label for="upload-logo-{{ $voucher->id }}"
                                           class="cursor-pointer flex flex-col items-center justify-center text-gray-500 text-1xs group-hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        {{ $existsLogo ? 'Edytuj zdjęcie' : 'Logo' }}
                                    </label>
                                    <input id="upload-logo-{{ $voucher->id }}" type="file" name="image" class="hidden" onchange="this.form.submit()">
                                </form>
                            </div>
                        </div>


                    </div>
                    <div class="text-center">
                        <h2 class="font-bold text-lg mb-1">{{ $voucher->title }}</h2>
                        <p class="text-gray-500 text-sm">{{ $voucher->description}}</p>
                    </div>

                    <div class="mt-4 text-center justify-around flex">
                        <a href="{{ route('admin.vouchers.edit', ['voucher' => $voucher]) }}" class="inline-block text-sm px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Edytuj
                        </a>
                        <a href="{{$voucher->url}}" class="inline-block text-sm px-4 py-2 bg-orange-400 text-white rounded hover:bg-orange-300 transition" target="_blank">
                            Link do oferty
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</x-layout-panel>
