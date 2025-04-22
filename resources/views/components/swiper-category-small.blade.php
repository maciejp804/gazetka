@props(['swiperClass', 'items', 'category', 'categoryRoute', 'mainRoute', 'dataContainerId'])

<div {{$attributes->merge(['class'=> "w-full"])}}>
    <div id="skeleton-slider-{{$swiperClass}}" class="flex w-full relative h-20  lg:h-28">
        <!-- Skeleton screen -->
        <div  class="grid grid-cols-4 2xs:grid-cols-5 sm:grid-cols-10 gap-x-1 2xs:gap-x-2 1xl:gap-x-4 gap-y-1 w-full">
        @for($i=0; $i<= 3; $i++)
            <x-skeleton.category-small-slide-skeleton/>
        @endfor
        </div>
    </div>


    <div class="swiper {{$swiperClass}} !hidden" id="{{$dataContainerId}}-{{$swiperClass}}">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full">
            <div class="swiper-slide group ">
                <div class="flex flex-col gap-y-2 text-center aspect-square justify-center w-full rounded-full border border-gray-200
                    @if(request()->is('produkty/'.$category->slug))
                        bg-blue-550
                    @endif
                    ">
                    <div class="aspect-square rounded-full flex justify-center group-hover:bg-blue-550 group-hover:bg-opacity-50">
                        @if(request()->is('produkty/'.$category->slug))
                            <span class="self-center w-full">
                    <img class="w-3/4 rounded-full m-auto" src="{{ asset('assets/images/categories/default.webp') }}" alt="pro-img1">
                </span>
                        @else
                            <a class="self-center w-full" href="{{route('main.products.category', ['category' => $category->slug])}}">
                                <img class="w-3/4 rounded-full m-auto" src="{{ asset('assets/images/categories/default.webp')}}" alt="pro-img1">
                            </a>
                        @endif

                    </div>
                </div>
                <div class="text-center">
                    <h3 class="text-gray-800 text-xs">
                        <a href="{{route('main.products.category', ['category' => $category->slug])}}" class="font-semibold
                        @if(!request()->is('produkty/'.$category->slug))
                        group-hover:font-bold
                        @endif
                        ">Wszystkie</a>
                    </h3>
                </div>
            </div>
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

            <!-- If we need navigation buttons -->
            <div class="next-swiper-{{$swiperClass}} absolute flex top-[29%] right-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg">
                <div class="flex self-center justify-center w-6 h-6 rounded-full">
                    <x-header.svg svg="chevron-right" size="w-5 h-5" colour="blue-550"/>
                </div>
            </div>
            <div class="prev-swiper-{{$swiperClass}} absolute flex top-[29%] left-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg">
                <div class="flex self-center justify-center w-6 h-6 rounded-full">
                    <x-header.svg svg="chevron-left" size="w-5 h-5" colour="blue-550"/>
                </div>
            </div>


    </div>
</div>

