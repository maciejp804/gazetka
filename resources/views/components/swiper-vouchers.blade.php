@props(['swiperClass' => 'leafletPromo', 'link'=> '#', 'title' => 'Brak'])

<x-h2-title class="flex" :link="$link">{!! $title !!}</x-h2-title>

<div class="w-full">
    <div class="swiper {{$swiperClass}}">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-16">
            @for($i=1; $i<=126; $i++)
                <x-voucher-slide class="swiper-slide"/>
            @endfor
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev 3xs:!hidden"></div>
        <div class="swiper-button-next 3xs:!hidden"></div>

    </div>
</div>

<x-see-more class="lg:hidden pb-2" :link="$link">Zobacz wszystkie</x-see-more>

