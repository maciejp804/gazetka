@props(['title' => 'Brak', 'items', 'categoryRoute', 'mainRoute'])

<x-h2-title :main-route="$mainRoute" class="flex">{!! $title !!}</x-h2-title>

<div class="w-full">
    <div class="swiper category-swiper">

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
        <div class="swiper-button-prev !hidden"></div>
        <div class="swiper-button-next !hidden"></div>

    </div>
</div>
<x-see-more class="lg:hidden" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>

