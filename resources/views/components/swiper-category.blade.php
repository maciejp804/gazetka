@props(['title' => 'Brak', 'image', 'name', 'offer', 'link' => '#', 'uri'])

<x-h2-title :link="$link" class="flex">{!! $title !!}</x-h2-title>

<div class="w-full">
    <div class="swiper category-swiper">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-10">
            @for($i=1; $i<=10; $i++)

                <!-- Slides -->
                <x-category-slide :image="$image" :name="$name" :offer="$offer" />
            @endfor
        </div>

        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev !hidden"></div>
        <div class="swiper-button-next !hidden"></div>

    </div>
</div>
<x-see-more class="lg:hidden" :link="$link">Zobacz wszystkie</x-see-more>

