@props(['swiperClass' => 'leafletPromo', 'mainRoute', 'title' => 'Brak', 'items'])

<x-h2-title class="flex" :main-route="$mainRoute">{!! $title !!}</x-h2-title>

<div class="w-full">
    <div class="swiper {{$swiperClass}}">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-16">
            @foreach($items as $item)
                <x-voucher-slide class="swiper-slide" :item="$item"/>
            @endforeach
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev 3xs:!hidden"></div>
        <div class="swiper-button-next 3xs:!hidden"></div>

    </div>
</div>

<x-see-more class="lg:hidden pb-2" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>

