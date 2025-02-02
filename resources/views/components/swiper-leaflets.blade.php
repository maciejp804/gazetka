@props(['swiperClass', 'buttonClass'=> 0, 'dataContainerId' => null, 'leaflets'])

<div class="w-full">
    <div class="swiper {{$swiperClass}}" id="{{$dataContainerId}}">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-8">
           @foreach($leaflets as $leaflet)

                @if(!is_array($leaflet))
                    <x-leaflet-slide
                        class="swiper-slide"
                        :valid_from="$leaflet->valid_from"
                        :valid_to="$leaflet->valid_to"
                        :logo="$leaflet->shop->logo_xs"
                        :name="$leaflet->shop->name"
                        :slug="$leaflet->shop->slug"
                        :id="$leaflet->id"
                        :page="1"
                        :image="$leaflet->image_cover"
                    />
                @else
                    @foreach($leaflet['pages'] as $item)
                        <x-leaflet-slide
                            class="swiper-slide"
                            :valid_from="$item['clicks'][0]['valid_from']"
                            :valid_to="$item['clicks'][0]['valid_to']"
                            :logo="$leaflet['logo']"
                            :name="$leaflet['name']"
                            :slug="$leaflet['slug']"
                            :id="$leaflet['leaflet_id']"
                            :page="$item['page_number']"
                            :image="$item['page_image']"
                        />
                    @endforeach
                @endif
           @endforeach
        </div>

        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        @if($buttonClass !== 0)
            <!-- If we need navigation buttons -->
            <div class="button-next-swiper-{{$buttonClass}} absolute hidden lg:flex top-[29%] right-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg">
                <div class="flex self-center justify-center w-6 h-6 rounded-full">
                    <x-header.svg svg="chevron-right" size="w-5 h-5" colour="blue-550"/>
                </div>
            </div>
            <div class="button-prev-swiper-{{$buttonClass}} absolute hidden lg:flex top-[29%] left-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg">
                <div class="flex self-center justify-center w-6 h-6 rounded-full">
                    <x-header.svg svg="chevron-left" size="w-5 h-5" colour="blue-550"/>
                </div>
            </div>
        @endif
    </div>
</div>
