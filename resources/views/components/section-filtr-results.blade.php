@props(['adsStatus' => false, 'items', 'dataContainerId', 'type'])

@if($type == 'leaflets')

    <div {{$attributes->merge(['class' => 'w-full'])}} id="{{$dataContainerId}}">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
            @if(count($items) > 0)
                @foreach($items as $item)

                    <div class="flex m-auto w-36 2xs:w-44 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-50">
                        <x-leaflet-slide
                            class="relative w-full"
                            :valid_from="$item->valid_from"
                            :valid_to="$item->valid_to"
                            :updated_at="$item->updated_at"
                            :logo="$item->shop->image"
                            :name="$item->shop->name"
                            :slug="$item->shop->slug"
                            :id="$item->id"
                            :page="1"
                            :image_path="$item->cover->path"
                            :webp_path="$item->cover->webp_path"
                            :avif_path="$item->cover->avif_path"
                            :width="$item->cover->width"
                            :height="$item->cover->height"
                        />
                    </div>
                    @if($adsStatus === true)
                        @switch($loop->iteration)
                            @case(5)
                                {{-- Reklama pozioma - 1--}}
                                <div class="hidden lg:grid lg:col-span-5 lg:my-5 lg:min-h-75 mx-auto">
                                    <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                    <x-admanager
                                        slot-name="subdomain_middle_desktop_3"
                                        :overrides="['page' => 'subdomain.index']"
                                    />
                                </div>
                                @break
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

{{--                    @if($loop->last && $adsStatus && !in_array($loop->iteration, [2, 3, 5, 12]))--}}
{{--                        --}}{{-- Reklama pozioma - 2--}}

{{--                        <div class="hidden lg:grid lg:col-span-5 lg:my-5 min-h-150 mx-auto md:min-h-25 3xl:hidden">--}}
{{--                            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>--}}
{{--                            <x-admanager--}}
{{--                                slot-name="homepage_middle_2"--}}
{{--                                :overrides="['page' => 'main.index']"--}}
{{--                            />--}}
{{--                        </div>--}}
{{--                    @endif--}}

                @endforeach

            @else
                <p class="col-span-2 sm:col-span-3 lg:col-span-5 flex justify-center w-full p-4 text-gray-500 text-sm">Brak aktualnych ofert</p>
            @endif
        </div>
    </div>
@endif

@if($type == 'retailers')
    <div {{$attributes->merge(['class' => 'w-full'])}} id="{{$dataContainerId}}">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
            @if(count($items) > 0)
                @foreach($items as $item)
                    @php
                        if ($item->leaflets_count == 0)
                        {
                            $offer = 'Brak ofert';
                        } elseif ($item->leaflets_count == 1){
                            $offer = $item->leaflets_count. ' oferta';
                        } elseif ($item->leaflets_count > 1 && $item->leaflets_count < 5)
                        {
                            $offer = $item->leaflets_count. ' oferty';
                        } else {
                             $offer = $item->leaflets_count. ' ofert';
                        }

                    @endphp

                    <div class="w-36 2xs:w-44 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-46 2lg:w-50">
                        <x-base-slide :item="$item" :type="$type" :image="$item->image" :name="$item->name" :offer="$offer" :uri="$item->logo" :hover-desc="$item->name"/>

                    </div>
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
                <p class="flex justify-center col-span-2 sm:col-span-3 lg:col-span-5 w-full p-4 text-gray-500 text-sm">Brak aktualnych sklepów w danej kategorii</p>
            @endif
        </div>
    </div>
@endif


@if($type == 'products')
    <div class="w-full" id="{{$dataContainerId}}">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
            @if(count($items) > 0)
                @foreach($items as $item)


                    <x-product
                        :valid_from="$item['valid_from']"
                        :valid_to="$item['valid_to']"
                        :product_image="$item['product_image'] ?: $item['page_image']"
                        :product_name="$item['product_name']"
                        :product_slug="$item['product_slug']"
                        :promo_price="$item['promo_price']"
                        :shop_image="$item['shop_image']"
                        :shop_slug="$item['shop_slug']"
                        :page_number="$item['page_number']"
                        :leaflet_id="$item['leaflet_id']"
                        :leaflet_valid_from="$item['leaflet_valid_from']"
                        :url="$item['url']"

                    />
                    @if($adsStatus === true)
                        @switch($loop->iteration)
                            @case(10)
                                {{-- Reklama pozioma - 1--}}
                                <div class="hidden lg:grid lg:col-span-5 lg:my-5 lg:min-h-75 mx-auto">
                                    <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                    <x-admanager
                                        slot-name="subdomain_middle_desktop_2"
                                        :overrides="['page' => 'main.products']"
                                    />
                                </div>
                                @break
                            @case(3)
                                {{-- Reklama pozioma - 1--}}
                                <div class="hidden sm:grid sm:col-span-3 sm:my-5 sm:min-h-75 mx-auto lg:hidden">
                                    <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                    <x-admanager
                                        slot-name="subdomain_middle_desktop_1"
                                        :overrides="['page' => 'main.products']"
                                    />
                                </div>
                                @break
                            @case(2)
                                {{-- Reklama pozioma mobile- 1--}}
                                <div class="col-span-2 my-5 min-h-70 mx-auto sm:hidden">
                                    <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                    <x-admanager
                                        slot-name="subdomain_middle_mobile_1"
                                        :overrides="['page' => 'main.products']"
                                    />
                                </div>
                                @break
                            @case(6)
                                {{-- Reklama pozioma mobile- 2--}}
                                <div class="col-span-2 my-5 min-h-70 mx-auto sm:hidden">
                                    <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                    <x-admanager
                                        slot-name="subdomain_middle_mobile_2"
                                        :overrides="['page' => 'main.products']"
                                    />
                                </div>
                                @break
                        @endswitch
                    @endif
                @endforeach
                @else
                    <p class="flex justify-center col-span-2 sm:col-span-3 lg:col-span-5 w-full p-4 text-gray-500 text-sm">Brak aktualnych ofert</p>
                @endif
        </div>
    </div>
@endif

@if($type == 'vouchers')
    <div class="w-full" id="{{$dataContainerId}}">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-7 gap-y-5">

            @foreach($items as $item)
                <div class="flex w-full sm:w-72 md:w-80 lg:w-75 2lg:w-80 1xl:w-80 m-auto h-80">
                    <x-voucher-slide
                        :item="$item"
                    />
                </div>
                @if($adsStatus === true)
                    @switch($loop->iteration)
                        @case(6)
                            {{-- Reklama pozioma - 1--}}
                            <div class="hidden lg:grid lg:col-span-3 lg:my-5 lg:min-h-75 mx-auto">
                                <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                <x-admanager
                                    slot-name="subdomain_middle_desktop_2"
                                    :overrides="['page' => 'main.products']"
                                />
                            </div>
                            @break

                        @case(2)
                            {{-- Reklama pozioma mobile- 1--}}
                            <div class="col-span-1 my-5 min-h-70 mx-auto sm:hidden">
                                <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                <x-admanager
                                    slot-name="subdomain_middle_mobile_1"
                                    :overrides="['page' => 'main.products']"
                                />
                            </div>
                            @break

                        @case(6)
                            {{-- Reklama pozioma mobile- 2--}}
                            <div class="col-span-1 my-5 min-h-70 mx-auto sm:hidden">
                                <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                                <x-admanager
                                    slot-name="subdomain_middle_mobile_2"
                                    :overrides="['page' => 'main.products']"
                                />
                            </div>
                            @break
                    @endswitch
                @endif
            @endforeach

        </div>
    </div>

@endif
