@props(['items'])

<div class="w-full">
        <div class="swiper swiper-info">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full">
        @foreach($items as $item)
                <div class="swiper-slide item cursor-auto">
                    <div class="w-full bg-gray-100 rounded relative">
                        <div class="flex flex-col gap-y-2 text-center aspect-square justify-center">
                            <div>
                                <img src="{{ $item->url }}" class="flex !w-14 m-auto " alt="image">
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
    </div>
</div>
