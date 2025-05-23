@props(['adsStatus' => false, 'pages', 'type', 'subdomain', 'shop', 'productsInLeaflets'])

@if($type == 'products-leaflet')
    <div {{$attributes->merge(['class' => 'w-full'])}}">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
{{--            @dd($productsInLeaflets)--}}
            @if($productsInLeaflets->count() > 0)

                @foreach($productsInLeaflets as $item)

{{--                @dd($item['valid_from']);--}}

                            <x-leaflet-slide
                                class="relative"
                                :valid_from="$item['valid_from']"
                                :valid_to="$item['valid_to']"
                                :updated_at="$item['updated_at']"
                                :type="$type"
                                :logo="$item['shop_image']"
                                :name="$item['name']"
                                :slug="$item['slug']"
                                :id="$item['leaflet_id']"
                                :page="$item['page_number']"
                                :image_path="$item['page_image']"
                                :avif_path="$item['page_image']"
                                :webp_path="$item['page_image']"
                                :width="250"
                                height="335"
                            />


                    @if($adsStatus === true)
                        @switch($loop->iteration)
                            @case(10)
                                {{-- Reklama pozioma - 1--}}
                                <div class="hidden lg:grid lg:col-span-5 lg:my-5 lg:min-h-75 mx-auto">
                                    <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                    <x-admanager
                                        slot-name="subdomain_middle_desktop_2"
                                        :overrides="['page' => 'subdomain.index']"
                                    />
                                </div>
                                @break
                            @case(3)
                                {{-- Reklama pozioma - 1--}}
                                <div class="hidden sm:grid sm:col-span-3 sm:my-5 sm:min-h-75 mx-auto lg:hidden">
                                    <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                    <x-admanager
                                        slot-name="subdomain_middle_desktop_1"
                                        :overrides="['page' => 'subdomain.index']"
                                    />
                                </div>
                                @break
                            @case(2)
                                {{-- Reklama pozioma mobile- 1--}}
                                <div class="col-span-2 my-5 min-h-70 mx-auto sm:hidden">
                                    <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                    <x-admanager
                                        slot-name="subdomain_middle_mobile_1"
                                        :overrides="['page' => 'subdomain.index']"
                                    />
                                </div>
                                @break
                            @case(6)
                                {{-- Reklama pozioma mobile- 2--}}
                                <div class="col-span-2 my-5 min-h-70 mx-auto sm:hidden">
                                    <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                    <x-admanager
                                        slot-name="subdomain_middle_mobile_2"
                                        :overrides="['page' => 'subdomain.index']"
                                    />
                                </div>
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
