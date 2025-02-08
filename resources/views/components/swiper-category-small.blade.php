@props(['title' => 'Brak', 'items', 'category', 'categoryRoute', 'mainRoute'])

<div class="w-full">
    <div class="swiper category-swiper-small">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-10">
            @foreach($items as $item)
                <!-- Slides -->
                <x-category-slide-small
                    :item="$item"
                    :category="$category"
                    :category-route="$categoryRoute"
                />
            @endforeach

        </div>

        <!-- If we need pagination -->
{{--        <div class="swiper-pagination"></div>--}}

        <!-- If we need navigation buttons -->
        @if($buttonClass !== 0)
            <!-- If we need navigation buttons -->
            <div class="next-swiper-{{$buttonClass}} absolute flex top-[29%] right-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg">
                <div class="flex self-center justify-center w-6 h-6 rounded-full">
                    <x-header.svg svg="chevron-right" size="w-5 h-5" colour="blue-550"/>
                </div>
            </div>
            <div class="prev-swiper-{{$buttonClass}} absolute flex top-[29%] left-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg">
                <div class="flex self-center justify-center w-6 h-6 rounded-full">
                    <x-header.svg svg="chevron-left" size="w-5 h-5" colour="blue-550"/>
                </div>
            </div>
        @endif

    </div>
</div>

