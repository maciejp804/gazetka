@php use Illuminate\Support\Str; @endphp
<x-layout-panel>
    <x-admin.header-back />


    <header class="bg-white shadow mb-2">
        <div class="flex justify-between mx-auto max-w-7xl">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Sieci handlowe</h1>
            </div>
            <div class="flex items-center px-4">
                <x-buttons.primary-a :url="route('admin.shops.create')">Dodaj sieć handlową</x-buttons.primary-a>
            </div>
        </div>
    </header>
    <x-admin.breadcrumbs :breadcrumbs="$breadcrumbs"/>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mx-4">
        @foreach($shops as $shop)
            <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between hover:shadow-md transition">
                <div class="flex justify-center">
                    @if($shop->image)
                            <img src="{{ asset_from_storage($shop->image, 'webp') }}"
                                 alt="{{ $shop->name }}"
                                 class="w-20 h-20 object-contain rounded-full mx-auto">
                    @else
                        {{-- Przycisk "Dodaj grafikę" --}}
                        <form action="#" method="POST" enctype="multipart/form-data" class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 border border-dashed border-gray-300 relative group overflow-hidden">
                            @csrf
                            <label for="upload-offer-{{ $shop->id }}" class="cursor-pointer flex flex-col items-center justify-center text-gray-500 text-sm group-hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Oferta
                            </label>
                            <input id="upload-offer-{{ $shop->id }}" type="file" name="image" class="hidden" onchange="this.form.submit()">
                        </form>
                    @endif
                </div>
                <div class="text-center mt-2">
                    <h2 class="font-semibold text-lg">{{ $shop->name }}</h2>
                </div>
                <div class="mt-4 text-center">
                    <x-buttons.primary-a :url="route('admin.shops.edit', $shop)">Zarządzaj</x-buttons.primary-a>
                </div>
            </div>
        @endforeach
    </div>
</x-layout-panel>
