@props(['blogCategory', 'sum'])
<div class="hidden swiper swiperCategory w-full pb-10 relative">
    <div class="swiper-wrapper">

            <div
                class="swiper-slide px-2 lg:px-4 py-2 border
                @if(Request::is('abc-zakupowicza'))
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
                @if(Request::is('abc-zakupowicza/'.$category['slug'])) bg-white @else bg-gray-200 hover:bg-gray-100 @endif
                rounded !w-auto">
                    <a class="text-xs lg:text-sm" href="{{route('main.blogs_category')}}">{{$category['name']}} ({{$category['qty']}})</a>
                </div>
            @endforeach

    </div>
    <div class="button-next button-disabled absolute top-0 right-0 bg-gradient-to-r from-transparent to-white w-10 h-full z-10 flex justify-end">
        <div class="flex self-center">
            <x-header.svg svg="chevron-right"/>
        </div>
    </div>
    <div class="button-prev button-disabled absolute top-0 left-0 bg-gradient-to-l from-transparent to-white w-10 h-full z-10 flex justify-start ">
        <div class="flex self-center">
            <x-header.svg svg="chevron-left"/>
        </div>
    </div>
</div>

