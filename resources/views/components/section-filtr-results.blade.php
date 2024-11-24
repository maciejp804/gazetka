@props(['adsStatus' => false, 'items', 'dataContainerId', 'type'])
@if($type == 'leaflet')

    <div {{$attributes->merge(['class' => 'w-full'])}} id="{{$dataContainerId}}">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
            @if(count($items) > 0)
                @foreach($items as $item)
                    <div class="flex m-auto w-36 2xs:w-44 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-52 xl:w-56 1xl:w-48">
                        <x-leaflet-slide class="relative" :leaflet="$item"/>
                    </div>
                    @if($adsStatus === true)
                        @switch($loop->iteration)
                            @case(5)
                                <x-ad-1 class="hidden lg:grid lg:col-span-5"/>
                                @break

                            @case(3)
                                <x-ad-1 class="hidden sm:grid sm:col-span-3 lg:hidden"/>
                                @break
                            @case(2)
                            @case(6)
                            @case(12)
                                <x-ad-1 class="col-span-2 sm:hidden"/>
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

@if($type == 'retailer')
    <div class="flex justify-center w-full" id="{{$dataContainerId}}">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
            @foreach($items as $item)

                @php
                    if ($item['offers'] == 0)
                    {
                        $offer = 'Brak ofert';
                    } elseif ($item['offers'] == 1){
                        $offer = $item['offers']. ' oferta';
                    } elseif ($item['offers'] > 1 && $item['offers'] < 5)
                    {
                        $offer = $item['offers']. ' oferty';
                    } else {
                         $offer = $item['offers']. ' ofert';
                    }

                @endphp

                <div class="w-34 2xs:w-44 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-50 xl:w-48">
                    <x-retailer-slide class="relative" :image="$item['logo']" :name="$item['name']" :offer="$offer"/>
                </div>
                @if($adsStatus === true)
                    @switch($loop->iteration)
                        @case(5)
                            <x-ad-1 class="hidden lg:grid lg:col-span-5"/>
                            @break

                        @case(3)
                            <x-ad-1 class="hidden sm:grid sm:col-span-3 lg:hidden"/>
                            @break
                        @case(2)
                        @case(6)
                        @case(12)
                            <x-ad-1 class="col-span-2 sm:hidden"/>
                            @break
                    @endswitch
                @endif
            @endforeach

        </div>
    </div>
@endif


@if($type == 'product')
    <div class="flex justify-center w-full" id="{{$dataContainerId}}">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
            @foreach($items as $item)
               <div class="w-34 2xs:w-40 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-50 xl:w-48">
                    <x-product class="relative"
                               :item="$item"
                               :hoverDesc="$item['name']"
                               :id=1

                    />
                </div>
                @if($adsStatus === true)
                    @switch($loop->iteration)
                        @case(5)
                            <x-ad-1 class="hidden lg:grid lg:col-span-5"/>
                            @break

                        @case(3)
                            <x-ad-1 class="hidden sm:grid sm:col-span-3 lg:hidden"/>
                            @break
                        @case(2)
                        @case(6)
                        @case(12)
                            <x-ad-1 class="col-span-2 sm:hidden"/>
                            @break
                    @endswitch
                @endif
            @endforeach
        </div>
    </div>
@endif

@if($type == 'voucher')
    <div class="w-full mb-10" id="{{$dataContainerId}}">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($items as $item)
                <div class="w-full sm:w-72 md:w-80 lg:w-75 2lg:w-80 m-auto">
                    <x-voucher-slide class="mb-10"
                                     :item="$item"
                    />
                </div>
                @if($adsStatus === true)
                    @switch($loop->iteration)
                        @case(6)
                            <x-ad-1 class="hidden lg:grid lg:col-span-3"/>
                            @break

                        @case(3)
                            <x-ad-1 class="hidden sm:grid sm:col-span-3 lg:hidden"/>
                            @break
                        @case(2)
                        @case(6)
                        @case(12)
                            <x-ad-1 class="col-span-1 sm:hidden"/>
                            @break
                    @endswitch
                @endif
            @endforeach

        </div>
    </div>
@endif
