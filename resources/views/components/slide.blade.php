@props(['index' , 'isMobile', 'pages'])
@php

    if($isMobile)
        $class = 'mobile-slide';
    else
        $class = 'flex flex-row';



@endphp

<div class="{{ $class }} relative">

    @foreach($pages[$index]['clicks'] as $page)
        <a class="bg-white/20 absolute rounded hover:bg-white/50 transition duration-500 ease-out z-40 clickable"
        href="{{ $page['url'] }}"
           target="_blank"
           style="top:{{$page['y']}}%; left:{{$page['x']}}%; width:{{$page['width']}}%; height:{{$page['height']}}%; display: block;"
        >
            <div class="absolute top-2 left-1 opacity-100 z-40p-1 rounded-full bg-white flex justify-center">
                <span class="absolute left-0 top-0 bg-blue-550 animate-ping h-6 w-6 rounded-full z-10 flex self-center"></span>
                <div class="z-50 bg-white absolute top-0 left-0 border-blue-550 rounded-full border-2 h-6 w-6 flex justify-center">
                    <x-header.svg svg="plus" class="flex self-center" size="w-4 h-4" colour="fill-blue-550"/>
                </div>

            </div>

        </a>
    @endforeach

    <img src="{{$pages[$index]['img']}}" class="swiper-lazy sm:max-w-[520px] sm:max-h-[750px] lg:max-w-[447px]" loading="lazy" alt="slide" id="slideImg"/>
    <div class="swiper-lazy-preloader"></div>
</div>
