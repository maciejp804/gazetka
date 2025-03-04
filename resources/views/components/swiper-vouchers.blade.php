@props(['swiperClass' => 'leafletPromo', 'mainRoute', 'title' => 'Brak', 'items', 'buttonClass'])

<x-h2-title class="flex" :main-route="$mainRoute">{!! $title !!}</x-h2-title>

<div class="w-full">
    <div id="skeleton-slider-vouchers" class="w-full relative mb-4 h-80">
        <!-- Skeleton screen -->
        <div  class="flex">
            @for($i = 0; $i < 2; $i++)
                <div class="swiper-slide px-2 lg:px-4 py-2 border mr-5 rounded !w-auto bg-gray-300 animate-pulse">
                    <div class="h-80 w-72"></div>
                </div>
            @endfor
        </div>
    </div>

    <div id="actual-slider-vouchers" class="swiper {{$swiperClass}} !hidden">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-16">
            @foreach($items as $item)
                <x-voucher-slide class="swiper-slide" :item="$item"/>
            @endforeach
        </div>


        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <x-button-next
            class="button-next-{{$swiperClass}}-{{$buttonClass}}"
            size="w-4 h-4"
            colour="gray-500"
        />
        <x-button-prev
            class="button-prev-{{$swiperClass}}-{{$buttonClass}}"
            size="w-4 h-4"
            colour="gray-500"
        />

    </div>
</div>

<x-see-more class="lg:hidden pb-2" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>

