@props(['title' => 'Brak', 'items', 'categoryRoute', 'mainRoute', 'swiperClass'])

<x-h2-title :main-route="$mainRoute" class="flex">{!! $title !!}</x-h2-title>

<div class="w-full">
    <div class="swiper {{$swiperClass}} relative">

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

