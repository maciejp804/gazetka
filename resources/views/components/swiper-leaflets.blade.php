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
        <div class="swiper-button-prev 3xs:!hidden lg:!flex"></div>
        <div class="swiper-button-next 3xs:!hidden lg:!flex"></div>
    </div>
</div>
