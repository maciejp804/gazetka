@props(['title' => 'Brak', 'items', 'categoryRoute', 'mainRoute', 'swiperClass', 'dataContainerId'])

<x-h2-title :main-route="$mainRoute" class="flex">{!! $title !!}</x-h2-title>

<div class="w-full">
    <div id="skeleton-slider-{{$swiperClass}}" class="flex w-full relative h-64 2xs:h-71 sm:h-37.5 md:h-40 mb-10">
        <!-- Skeleton screen -->
        <div  class="grid grid-cols-3 xs:grid-cols-4 sm:grid-cols-5 lg:grid-cols-7 gap-x-1 2xs:gap-2.5 1xl:gap-x-6 gap-y-1 w-full">
            @for($i=0; $i<= 4; $i++)
                <x-skeleton.category-slide-skeleton/>
            @endfor
        </div>
    </div>





    <div class="swiper {{$swiperClass}} relative !hidden" id="{{$dataContainerId}}-{{$swiperClass}}">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-10">
            @foreach($items as $item)
                <!-- Slides -->
                <x-category-slide
                    :item="$item"
                    :category-route="$categoryRoute"
                />
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
<x-see-more class="lg:hidden" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>

