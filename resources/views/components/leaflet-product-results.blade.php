@props(['adsStatus' => false, 'pages', 'type', 'subdomain', 'shop', 'productsInLeaflets'])

@if($type == 'products-leaflet')
    <div {{$attributes->merge(['class' => 'w-full'])}}">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
            @if($productsInLeaflets->count() > 0)
                @foreach($productsInLeaflets as $shopWithProducts)
                    @foreach($shopWithProducts['pages'] as $item)
{{--                        @dd($productsInLeaflets)--}}

                            <x-leaflet-slide
                                class="relative"
                                :valid_from="$item['clicks'][0]['valid_from']"
                                :valid_to="$item['clicks'][0]['valid_to']"
                                :updated_at="$item['clicks'][0]['updated_at']"
                                :type="$type"
                                :logo="$shopWithProducts['shop_image']"
                                :name="$shopWithProducts['name']"
                                :slug="$shopWithProducts['slug']"
                                :id="$shopWithProducts['leaflet_id']"
                                :page="$item['page_number']"
                                :image_path="$item['page_image']"
                                :avif_path="$item['page_image']"
                                :webp_path="$item['page_image']"
                            />

                    @endforeach
                    @if($adsStatus === true)
                        @switch($loop->iteration)
                            @case(5)
                                <x-ad-1 class="hidden lg:grid lg:col-span-5 lg:my-5"/>
                                @break

                            @case(3)
                                <x-ad-1 class="hidden sm:grid sm:col-span-3 sm:my-5 lg:hidden"/>
                                @break
                            @case(2)
                            @case(6)
                            @case(12)
                                <x-ad-1 class="col-span-2 my-5 sm:hidden"/>
                                @break
                        @endswitch
                    @endif
                @endforeach
            @else
                <p class="flex justify-center w-full p-4 text-gray-500 text-sm">Brak aktualnych ofert</p>
            @endif
        </div>
    </div>
@endif
