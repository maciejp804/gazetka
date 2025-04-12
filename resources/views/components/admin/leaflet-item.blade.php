@props(['items'])
@foreach($items as $item)
    @php
        $coverExists = $item['cover'] && Storage::disk('public')->exists($item['cover'] . '.webp');
        @endphp

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="aspect-[12/12] bg-gray-100 flex items-center justify-center group relative">
            @if($coverExists)
                <img src="{{ Storage::url($item['cover'] . '.webp') }}" alt="Okładka" class="w-full h-full object-cover">
            @else
                <span class="text-gray-400">Brak okładki</span>
            @endif

            <a href="{{ route('admin.leaflets.manage', $item['id']) }}"
               class="hidden invisible absolute w-full h-full rounded justify-center 2xs:flex group-hover:bg-black group-hover:bg-opacity-50 group-hover:visible duration-300 ease-in">
                <div class="hidden text-white group-hover:flex self-center justify-center font-bold text-xs w-24 h-8 bg-blue-550 rounded duration-300">
                    <span class="flex self-center">Zarządzaj</span>
                </div>
            </a>
        </div>

        <div class="p-4 space-y-2">
            <h3 class="font-semibold text-lg">{{ $item['title'] }}</h3>
            <p class="text-sm text-gray-500">
                {{ $item['shop_name'] }}<br>
                {{ $item['valid_from'] }} – {{ $item['valid_to'] }}
            </p>
            <div class="flex justify-center items-center mt-2">
                <x-buttons.primary-a :url="route('admin.leaflets.manage', $item['id'])">Zarządzaj</x-buttons.primary-a>
            </div>
        </div>
    </div>
@endforeach
