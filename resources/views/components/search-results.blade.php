<div>
    {{-- Wyniki dla produktów --}}
    @if(isset($produkty) && count($produkty) > 0)
        <div class="mx-4 py-1 text-xs font-base text-gray-400">Produkty</div>
        @foreach($produkty as $produkt)
            <a href="#" class="block px-4 py-1 hover:bg-gray-100 cursor-pointer text-sm text-gray-700 item">
                <img src="{{ $produkt['logo'] }}" alt="{{ $produkt['name'] }} logo" class="inline-block w-6 h-6 mr-2">
                {{ $produkt['name'] }}
            </a>
        @endforeach
    @endif

    {{-- Wyniki dla sklepów --}}
    @if(isset($sklepy) && count($sklepy) > 0)
        <div class="mx-4 py-1 text-xs font-base text-gray-400 mt-2 border-t border-gray-200">Sklepy</div>
        @foreach($sklepy as $sklep)
            <a href="#" class="block px-4 py-1 hover:bg-gray-100 cursor-pointer text-sm text-gray-700 item">
                <img src="{{ $sklep['logo'] }}" alt="{{ $sklep['name'] }} logo" class="inline-block w-6 h-6 mr-2">
                {{ $sklep['name'] }}
            </a>
        @endforeach
    @endif

    {{-- Wyniki dla miejscowości --}}
    @if(isset($miejscowosci) && count($miejscowosci) > 0)
        <div class="mx-4 py-1 text-xs font-base text-gray-400 mt-2 border-t border-gray-200">Miejscowości</div>
        @foreach($miejscowosci as $miejscowosc)
            <a href="#" class="block px-4 py-1 hover:bg-gray-100 cursor-pointer text-sm text-gray-700 item">
                {{ $miejscowosc['name'] }}
            </a>
        @endforeach
    @endif
</div>

{{-- Wyniki dla gazetek --}}
@if(isset($gazetki) && count($gazetki) > 0)
    @foreach($gazetki as $gazetka)
        <x-leaflet-slide class="swiper-slide"/>
    @endforeach
@endif
