<div>
    {{-- Wyniki dla produktów --}}
    @if(isset($products) && count($products) > 0)
        @if($searchType !== 'admin-products')
        <div class="mx-4 py-1 text-xs font-base text-gray-400">Produkty</div>
        @endif
        @foreach($products as $product)
            @if($searchType !== 'admin-products')
                <a href="{{route('main.product', ['slug' => $product->slug])}}" class="block px-4 py-1 hover:bg-gray-100 cursor-pointer text-sm text-gray-700 item">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image.'.webp') }}" alt="{{ $product->name }}" class="inline-block w-6 h-6 mr-2">
                    @endif
                    {{ $product->name }}
                </a>
            @else
                    <form action="{{route('admin.leaflets.page.product.add',[$leafletId])}}" method="POST" id="add-product-form-{{ $product->id }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="page_id" value="{{ $pageId }}">
                        <input type="hidden" name="leaflet_id" value="{{ $leafletId }}">
                        <a href="#" onclick="document.getElementById('add-product-form-{{ $product->id }}').submit();"
                           class="block px-4 py-1 hover:bg-gray-100 cursor-pointer text-sm text-gray-700 item">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image.'.webp') }}" alt="{{ $product->name }}" class="inline-block w-6 h-6 mr-2">
                            @endif
                            {{ $product->name }}
                        </a>
                    </form>
            @endif

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
            <a href="{{route('subdomain.index', ['subdomain' => $retailer->slug])}}" class="block px-4 py-1 hover:bg-gray-100 cursor-pointer text-sm text-gray-700 item">
                <img src="{{ $retailer['image'] }}" alt="{{ $retailer['name'] }} logo" class="inline-block w-6 h-6 mr-2">
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
