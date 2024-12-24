<div>
    {{-- Wyniki dla produktów --}}
    @if(isset($products) && count($products) > 0)
        <div class="mx-4 py-1 text-xs font-base text-gray-400">Produkty</div>
        @foreach($products as $product)
            <a href="#" class="block px-4 py-1 hover:bg-gray-100 cursor-pointer text-sm text-gray-700 item">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="inline-block w-6 h-6 mr-2">
                {{ $product->name }}
            </a>
        @endforeach
    @endif

    {{-- Wyniki dla sklepów --}}
    @if(isset($retailers) && count($retailers) > 0)
        <div class="mx-4 py-1 text-xs font-base text-gray-400 mt-2
         @if(isset($products) && count($products) > 0))
        border-t border-gray-200
        @endif
        ">Sklepy</div>
        @foreach($retailers as $retailer)
            <a href="#" class="block px-4 py-1 hover:bg-gray-100 cursor-pointer text-sm text-gray-700 item">
                <img src="{{ $retailer['logo'] }}" alt="{{ $retailer['name'] }} logo" class="inline-block w-6 h-6 mr-2">
                {{ $retailer['name'] }}
            </a>
        @endforeach
    @endif

    {{-- Wyniki dla miejscowości --}}
    @if(isset($places) && count($places) > 0)
        <div class="mx-4 py-1 text-xs font-base text-gray-400 mt-2 border-t border-gray-200">Miejscowości</div>
        @foreach($places as $place)
            <a href="{{route('main.index.gps', ['community' => $place->slug])}}" class="block px-4 py-1 hover:bg-gray-100 cursor-pointer text-sm text-gray-700 item">
                {{ $place['name'] }}
            </a>
        @endforeach
    @endif
</div>
