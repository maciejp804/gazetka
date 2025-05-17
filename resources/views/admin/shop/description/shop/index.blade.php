@php use Illuminate\Support\Str; @endphp
<x-layout-panel>
    <x-admin.header-back />


    <header class="bg-white shadow mb-2">
        <div class="flex justify-between mx-auto max-w-7xl">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Opisy dla sieci handlowych</h1>
            </div>
        </div>
    </header>
    <x-admin.breadcrumbs :breadcrumbs="$breadcrumbs"/>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mx-4">
        @foreach($shops as $shop)
            <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between hover:shadow-md transition">
                <div class="flex justify-center">
                    <img src="{{ asset_from_storage($shop->image, 'webp') }}"
                             alt="{{ $shop->name }}"
                             class="w-20 h-20 object-contain rounded-full mx-auto">
                </div>
                <div class="text-center mt-2">
                    <h2 class="font-semibold text-lg">{{ $shop->name }}</h2>
                </div>
                <div class="mt-4 text-center">
                    @if($shop->hasDescription)
                        <x-buttons.primary-a :url="route('admin.products.description.shop.manageShop', [$product, $shop])">Zarządzaj</x-buttons.primary-a>
                    @else
                        <x-buttons.primary-a :url="route('admin.products.description.shop.addShop', [$product, $shop])">Dodaj</x-buttons.primary-a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-layout-panel>
