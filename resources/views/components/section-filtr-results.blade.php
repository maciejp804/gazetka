@props(['adsStatus' => false, 'items', 'dataContainerId', 'type'])

@if($type == 'leaflets')

    <div {{$attributes->merge(['class' => 'w-full'])}} id="{{$dataContainerId}}">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
            @if(count($items) > 0)
                @foreach($items as $item)
                    <div class="flex m-auto w-36 2xs:w-44 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-52 xl:w-56 1xl:w-50">
                        <x-leaflet-slide
                            class="relative w-full"
                            :valid_from="$item->valid_from"
                            :valid_to="$item->valid_to"
                            :logo="$item->shop->logo_xs"
                            :name="$item->shop->name"
                            :slug="$item->shop->slug"
                            :id="$item->id"
                            :page="1"
                            :image_path="$item->cover->path"
                            :webp_path="$item->cover->webp_path"
                            :avif_path="$item->cover->avif_path"
                        />
                    </div>
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
                        if ($item->ranking == 0)
                        {
                            $offer = 'Brak ofert';
                        } elseif ($item->ranking == 1){
                            $offer = $item->ranking. ' oferta';
                        } elseif ($item->ranking > 1 && $item->ranking < 5)
                        {
                            $offer = $item->ranking. ' oferty';
                        } else {
                             $offer = $item->ranking. ' ofert';
                        }

                    @endphp

                    <div class="w-36 2xs:w-44 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-46 2lg:w-50">
                        <x-base-slide :item="$item" :type="$type" :image="$item->logo" :name="$item->name" offer="1 oferta" :uri="$item->logo" :hover-desc="$item->name"/>

                    </div>
                    @if($adsStatus === true)
                        @switch($loop->iteration)
                            @case(5)
                                <x-ad-1 class="hidden lg:grid lg:col-span-5 lg:my-3"/>
                                @break

                            @case(3)
                                <x-ad-1 class="hidden sm:grid sm:col-span-3 sm:my-3 lg:hidden"/>
                                @break
                            @case(2)
                            @case(6)
                            @case(12)
                                <x-ad-1 class="col-span-2 my-3 sm:hidden"/>
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
                    {{--                    @dd($item->product_slug)--}}
                    <x-product
                        :valid_from="$item['valid_from']"
                        :valid_to="$item['valid_to']"
                        :product_image="$item['product_image']"
                        :product_name="$item['product_name']"
                        :product_slug="$item['product_slug']"
                        :promo_price="$item['promo_price']"
                        :logo_xs="$item['logo_xs']"
                    />
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
                    <p class="flex justify-center col-span-2 sm:col-span-3 lg:col-span-5 w-full p-4 text-gray-500 text-sm">Brak aktualnych ofert</p>
                @endif
        </div>
    </div>
@endif

@if($type == 'vouchers')
    <div class="w-full" id="{{$dataContainerId}}">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-7 gap-y-5">

            @foreach($items as $item)
                <div class="w-full sm:w-72 md:w-80 lg:w-75 2lg:w-80 1xl:w-80 m-auto h-80">
                    <x-voucher-slide
                        :item="$item"
                    />
                </div>
                @if($adsStatus === true)
                    @switch($loop->iteration)
                        @case(6)
                            <x-ad-1 class="hidden lg:grid lg:col-span-3 lg:my-5"/>
                            @break

                        @case(3)
                            <x-ad-1 class="hidden"/>
                            @break
                        @case(2)
                        @case(6)
                        @case(12)
                            <x-ad-1 class="col-span-1 my-5 sm:col-span-2 lg:hidden"/>
                            @break
                    @endswitch
                @endif
            @endforeach

        </div>
    </div>

@endif
