@props(['items', 'swiperClass'])

<div class="w-full">
    <div id="skeleton-slider-{{$swiperClass}}" class="flex w-full relative h-101 2xs:h-112 1xs:h-128 xs:h-99 sm:h-126 md:h-60 lg:h-48">
        <!-- Skeleton screen -->
        <div  class="grid grid-cols-2 xs:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-x-1 1xs:gap-x-6 xs:gap-x-2.5 md:gap-x-1 lg:gap-x-4 gap-y-1 w-96 1xs:w-102.5 xs:w-110.75 sm:w-152 md:w-184 lg:w-238 xl:w-257">
            @for($i=0; $i<=3; $i++)
                <x-skeleton.info-slide-skeleton />
            @endfor
        </div>
    </div>

        <div class="swiper {{$swiperClass}} !hidden relative" id="{{$dataContainerId}}-{{$swiperClass}}">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full">
        @foreach($items as $item)
                <div class="swiper-slide item cursor-auto">
                    <div class="w-full bg-gray-100 rounded relative">
                        <div class="flex flex-col gap-y-2 text-center aspect-square justify-center">
                            <div>
                                <img src="{{ $item->url }}" class="flex !w-14 m-auto " alt="image" loading="lazy">
                            </div>
                            <div>
                                <span class="font-semibold text-sm lg:text-base text-gray-700">{!! $item->title !!}</span>
                            </div>
                        </div>
                        <div class="absolute opacity-0 top-0 left-0 h-full w-full transition duration-500 bg-blue-550 hover:opacity-100 rounded">
                            <div class="text-gray-300 text-center flex flex-col aspect-square gap-y-1 justify-center font-semibold text-sm lg:text-base">
                                <span class="font-semibold">{!! $item->titleHover !!}</span>
                                <span class="font-normal">{{$item->description}}</span>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
        </div>

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
