@props(['swiperClass' => 'leafletPromo'])
<div class="w-full">
    <div class="swiper {{$swiperClass}}">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-16">
            @for($i=1; $i<=126; $i++)
                <x-voucher class="swiper-slide"/>
            @endfor
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev 3xs:!hidden"></div>
        <div class="swiper-button-next 3xs:!hidden"></div>

    </div>
</div>

