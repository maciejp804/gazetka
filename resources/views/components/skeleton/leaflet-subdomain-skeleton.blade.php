@props(['swiperClass' => 'leafletPromo', 'leaflet', 'isMobile', 'pages', 'inserts', 'ads'])
@php

    if($isMobile)
        $class = 'mobile-slide';
    else
        $class = 'flex flex-row';

@endphp
<div id="skeleton-slider-{{$swiperClass}}" class="flex flex-col justify-center w-full relative mb-3 h-126 2xs:h-186">
    <div class="skeleton m-auto w-1/5 h-12 mb-2 bg-gray-300 rounded"></div> <!-- Skeleton for slide -->
    @if(!$isMobile)
        <div class="p-2 w-full h-full flex justify-around">
            <div class="skeleton w-2/5 bg-gray-300 rounded animate-pulse"></div> <!-- Skeleton for slide -->
            <div class="skeleton w-2/5 bg-gray-300 rounded animate-pulse"></div> <!-- Skeleton for slide -->
        </div>
    @else
        <div class="p-2 w-full h-full flex justify-center">
            <div class="w-10/12 bg-gray-300 rounded animate-pulse"></div> <!-- Skeleton for slide -->
        </div>

    @endif
</div>

