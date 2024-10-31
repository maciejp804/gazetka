@props(['image', 'name', 'offer', 'uri' => 'http://dino.gazetkapromocyjna.local',
'hoverDesc'=> 'Gazetka promocyjna <strong>Biedronka</strong>', 'swiperClass' => 'mySwiper',
'link' => '#', 'title' => 'Missing title', 'buttonClass'])

<x-h2-title class="flex" :link="$link">{!! $title !!}</x-h2-title>

<div class="w-full relative">
    <div class="swiper {{$swiperClass}} hidden">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-10">
            @for($i=0; $i<=10; $i++)
                <!-- Slides -->
                <x-base-slide :image="$image" :name="$name" :offer="$offer" :uri="$uri" :hover-desc="$hoverDesc"/>
            @endfor

        </div>

        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <x-button-next
            class="button-next-{{$buttonClass}}"
            size="4"
            colour="gray-500"
        />
        <x-button-prev
            class="button-prev-{{$buttonClass}}"
            size="4"
            colour="gray-500"
        />


    </div>

</div>

<x-see-more class="lg:hidden" :link="$link">Zobacz wszystkie</x-see-more>


