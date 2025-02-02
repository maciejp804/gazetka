@props(['adsStatus' => false, 'pages', 'type', 'subdomain', 'shop', 'productsInLeaflets'])

@if($type == 'products-leaflet')
    <div {{$attributes->merge(['class' => 'w-full'])}}">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
            @if($productsInLeaflets->count() > 0)
                @foreach($productsInLeaflets as $shopWithProducts)
                    @foreach($shopWithProducts['pages'] as $item)
                        <div class="flex m-auto w-36 2xs:w-44 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-52 xl:w-56 1xl:w-48">
                            <x-leaflet-slide
                                class="relative"
                                :valid_from="$item['clicks'][0]['valid_from']"
                                :valid_to="$item['clicks'][0]['valid_to']"
                                :type="$type"
                                :logo="$shopWithProducts['logo']"
                                :name="$shopWithProducts['name']"
                                :slug="$shopWithProducts['slug']"
                                :id="$shopWithProducts['leaflet_id']"
                                :page="$item['page_number']"
                                :image="$item['page_image']"
                            />
                        </div>
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
