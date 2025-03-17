@props(['blogCategory', 'sum', 'buttonClass'])

<div id="skeleton-slider" class="w-full relative mb-4 h-10.5">
    <!-- Skeleton screen -->
    <div  class="flex">
        @for($i = 0; $i < 3; $i++)
            <div class="swiper-slide px-2 lg:px-4 py-2 border mr-4 rounded !w-auto bg-gray-300 animate-pulse">
                <div class="h-7 w-20"></div>
            </div>
        @endfor
    </div>
</div>


<div id="actual-slider" class="swiper swiper-category-blog w-full relative mb-4 h-10.5 !hidden">
    <div class="swiper-wrapper ">

            <div
                class="swiper-slide px-2 lg:px-4 py-2 border mr-1
                @if(request()->is('abc-zakupowicza'))
                bg-white
                @else
                bg-gray-200 hover:bg-gray-100
               @endif
                rounded !w-auto"
            >
                <a class="text-xs lg:text-sm" href="{{route('main.blogs')}}">Wszystkie ({{$sum}})</a>
            </div>

            @foreach($blogCategory as $category)

                <div class="swiper-slide px-2 lg:px-4 py-2 border
                @if(request()->is('abc-zakupowicza/'.$category->slug)) bg-white @else bg-gray-200 hover:bg-gray-100 @endif
                rounded !w-auto">
                    <a class="text-xs lg:text-sm" href="{{route('main.blogs.category', ['category' => $category->slug])}}">
                        {{$category->name}} ({{$category->blogs_count}})


                    </a>
                </div>
            @endforeach

    </div>

{{--    <div class="button-next-{{$buttonClass}} absolute top-0 right-0 bg-gradient-to-r from-transparent to-white w-10 h-full z-10 justify-end">--}}
{{--        <div class="flex self-center justify-center w-6 h-6 rounded-full">--}}
{{--            <x-header.svg svg="chevron-right" size="5" colour="blue-550"/>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="top-0 left-0 bg-gradient-to-l from-transparent to-white w-10 h-full z-10 button-prev-{{$buttonClass}} absolute flex justify-start">--}}
{{--        <div class="flex">--}}
{{--            <x-header.svg svg="chevron-left" size="5" colour="blue-550"/>--}}
{{--        </div>--}}
{{--    </div>--}}

</div>

