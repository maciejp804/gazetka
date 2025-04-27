@props(['swiperClass' => 'leafletPromo', 'mainRoute', 'title' => 'Brak', 'items'])

<x-h2-title class="flex" :main-route="$mainRoute">{!! $title !!}</x-h2-title>

<div class="w-full">
    <div id="skeleton-slider-{{$swiperClass}}" class="flex w-full relative h-173.5 2xs:h-172 1xs:h-174.5 xs:h-165 sm:h-126 md:h-60 lg:h-64 mb-4">
        <!-- Skeleton screen -->
        <div  class="grid grid-cols-1 md:grid-cols-3 grid-rows-2 lg:grid-cols-5 gap-x-1 1xs:gap-x-6 xs:gap-x-2.5 md:gap-x-1 lg:gap-x-4 gap-y-4 w-96 1xs:w-102.5 xs:w-110.75 sm:w-152 md:w-184 lg:w-238 xl:w-257">
            @for($i=0; $i<=1; $i++)
                <x-skeleton.voucher-slide-skeleton />
            @endfor
        </div>
    </div>

    <div id="actual-slider-vouchers" class="swiper {{$swiperClass}}  relative">
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
            class="button-next-{{$swiperClass}}"
            size="w-4 h-4"
            colour="gray-500"
        />
        <x-button-prev
            class="button-prev-{{$swiperClass}}"
            size="w-4 h-4"
            colour="gray-500"
        />

    </div>
</div>

<x-see-more class="lg:hidden pb-2" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>

