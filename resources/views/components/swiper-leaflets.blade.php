@props(['swiperClass', 'buttonClass'=> 0, 'dataContainerId' => null, 'leaflets'])

<div class="w-full">
    <div class="swiper {{$swiperClass}}" id="{{$dataContainerId}}">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-8">
           @foreach($leaflets as $leaflet)
                <x-leaflet-slide class="swiper-slide" :leaflet="$leaflet"/>
           @endforeach
        </div>

        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        @if($buttonClass !== 0)
            <!-- If we need navigation buttons -->
            <div class="button-next-swiper-{{$buttonClass}} absolute hidden lg:flex top-[29%] right-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg">
                <div class="flex self-center justify-center w-6 h-6 rounded-full">
                    <x-header.svg svg="chevron-right" size="5" colour="blue-550"/>
                </div>
            </div>
            <div class="button-prev-swiper-{{$buttonClass}} absolute hidden lg:flex top-[29%] left-1 w-8 h-8 z-20 cursor-pointer bg-gray-100 border border-gray-200 rounded-full justify-center hover:bg-gray-200 shadow-lg">
                <div class="flex self-center justify-center w-6 h-6 rounded-full">
                    <x-header.svg svg="chevron-left" size="5" colour="blue-550"/>
                </div>
            </div>
        @endif
    </div>
</div>
