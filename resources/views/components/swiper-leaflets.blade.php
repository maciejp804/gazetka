@props(['swiperClass'])

<div class="w-full">
    <div class="swiper {{$swiperClass}}">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-8">
            @for($i=1; $i<=12; $i++)
                <x-leaflet-slide class="swiper-slide"/>
            @endfor
        </div>

        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="button-next-swiper absolute hidden lg:flex top-[29%] right-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg">
            <div class="flex self-center justify-center w-6 h-6 rounded-full">
                <x-header.svg svg="chevron-right" size="5" colour="blue-550"/>
            </div>
        </div>
        <div class="button-prev-swiper absolute hidden lg:flex top-[29%] left-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg">
            <div class="flex self-center justify-center w-6 h-6 rounded-full">
                <x-header.svg svg="chevron-left" size="5" colour="blue-550"/>
            </div>
        </div>
        <div class="button-prev-swiper 3xs:!hidden lg:!flex"></div>
        <div class="button-next-swiper 3xs:!hidden lg:!flex"></div>
    </div>
</div>
