@props(['swiperClass' => 'leafletPromo', 'leaflet', 'isMobile', 'pages', 'inserts', 'ads'])
@php

    if($isMobile)
        $class = 'mobile-slide';
    else
        $class = 'flex flex-row';

@endphp

<div id="preloader">Loading...</div>
<div class="swiper {{ $swiperClass }} relative" style="display: none">
    <div class="flex relative h-10">
        <div class="swiper-pagination"></div>
    </div>
    <div class="swiper-wrapper">
        @if(!$isMobile)
            @for ($index = 0; $index <= count($pages); $index += 2)

                <div class="swiper-slide cursor-grab z-20 relative" data-hash="{{$index + 1}}" data-history="{{$index + 1}}">
                    <div class="swiper-zoom-container">
                        <div class="swiper-zoom-target">
                            <div class="{{ $class }} w-full">
                                @if ($index == 0) <!-- Pierwszy slajd -->

                                <x-slide-empty />
                                <x-slide :index="$index" :is-mobile="$isMobile" :pages="$pages[$index]"/>
                                @else <!-- Środkowe slajdy -->
                                <x-slide :index="$index-1" :is-mobile="$isMobile" :pages="$pages[$index-1]"/>
                                @if (isset($pages[$index]))
                                    <x-slide :index="$index" :is-mobile="$isMobile" :pages="$pages[$index]"/>
                                @else
                                    <x-slide-empty />
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    {{--Inserty--}}
                    @foreach($inserts as $insert)
                        @if($insert->pivot->after == $index-1)
                            <div class="absolute top-0 left-0 w-full z-50 pointer-events-none">
                                <div class="sub-swiper w-full">
                                    <div class="sub-swiper-wrapper swiper-wrapper flex">
                                        <x-insert-slide-empty />
                                        <x-insert-slide :index="$index-1" :insert="$insert"/>
                                        <x-insert-slide-empty />
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                {{--Inserty End--}}
                </div>
                @foreach($ads as $ad)
                    @if($ad->pivot->after_page == $index - 1)
                        <div class="swiper-slide cursor-grab  !flex justify-center self-center" data-hash="ads">
                            {!! $ad->render() !!}
                        </div>
                    @endif
                @endforeach
            @endfor
        @else
            @for ($index = 0; $index < count($pages); $index++)
                <!-- Urządzenie mobilne -->
                <div class="swiper-slide relative"  data-hash="{{$index + 1}}" data-history="{{$index + 1}}">
                    <div class="swiper-zoom-container">
                        <div class="swiper-zoom-target">
                            <div class="{{ $class }} w-full">
                                <x-slide :index="$index" :is-mobile="$isMobile" :pages="$pages[$index]"/>
                            </div>
                        </div>
                    </div>
                    {{--Inserty--}}
                    @foreach($inserts as $insert)
                        @if($insert->pivot->after == $index)
                            <div class="absolute top-0 left-0 w-full h-full z-50 pointer-events-none">
                                <div class="sub-swiper h-full w-full">
                                    <div class="sub-swiper-wrapper swiper-wrapper">
                                        <x-insert-slide :index="$index" :insert="$insert" data="2"/>
                                        <x-insert-slide-empty />
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    {{--Inserty End--}}
                </div>
                @foreach($ads as $ad)
                    @if($ad->pivot->after_page == $index - 1)
                        <div class="swiper-slide cursor-grab !flex justify-center self-center" data-hash="ads">
                            {!! $ad->render() !!}
                        </div>
                    @endif
                @endforeach
            @endfor
        @endif
    </div>

    <div class="swiper-button-prev sub-swiper-next"></div>
    <div class="swiper-button-next sub-swiper-next"></div>

</div>
{{--@props(['swiperClass' => 'leafletPromo', 'leaflet', 'isMobile', 'pages', 'inserts', 'ads', 'insertData'])--}}

{{--@php--}}
{{--    if($isMobile) {--}}
{{--        $class = 'mobile-slide';--}}
{{--    } else {--}}
{{--        $class = 'flex flex-row';--}}
{{--    }--}}
{{--    $pages = $leaflet->pages->chunk(1);--}}
{{--@endphp--}}

{{--<div id="preloader">Loading...</div>--}}
{{--<div class="swiper {{ $swiperClass }} relative" style="display: none">--}}
{{--    <div class="flex relative h-10">--}}
{{--        <div class="swiper-pagination"></div>--}}
{{--    </div>--}}
{{--    <div class="swiper-wrapper">--}}
{{--        @if(!$isMobile)--}}
{{--            @foreach($pages->chunk(2) as $chunkIndex => $chunk)--}}
{{--                <div class="swiper-slide cursor-grab z-20 relative" data-hash="{{ $chunkIndex + 1 }}" data-history="{{ $chunkIndex + 1 }}">--}}
{{--                    <div class="swiper-zoom-container">--}}
{{--                        <div class="swiper-zoom-target">--}}
{{--                            <div class="{{ $class }} w-full">--}}
{{--                                @if ($chunkIndex == 0) <!-- Pierwszy slajd -->--}}
{{--                                <x-slide-empty />--}}
{{--                                <x-slide :index="0" :is-mobile="$isMobile" :pages="$chunk[0]" />--}}
{{--                                @else <!-- Środkowe slajdy -->--}}
{{--                                <x-slide :index="($chunkIndex * 2) - 1" :is-mobile="$isMobile" :pages="$chunk[0]" />--}}
{{--                                @isset($chunk[1])--}}
{{--                                    <x-slide :index="($chunkIndex * 2)" :is-mobile="$isMobile" :pages="$chunk[1]" />--}}
{{--                                @else--}}
{{--                                    <x-slide-empty />--}}
{{--                                @endisset--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                     Inserty --}}
{{--                    @if(in_array($chunkIndex + 1, $inserts))--}}
{{--                        <div class="absolute top-0 left-0 w-full z-50 pointer-events-none">--}}
{{--                            <div class="sub-swiper w-full">--}}
{{--                                <div class="sub-swiper-wrapper swiper-wrapper flex">--}}
{{--                                    <x-insert-slide-empty />--}}
{{--                                    <x-insert-slide :index="$chunkIndex + 1" :inserts="$inserts" :insertData="$insertData" />--}}
{{--                                    <x-insert-slide-empty />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                     Inserty End --}}
{{--                </div>--}}
{{--                @if(in_array($chunkIndex + 1, $ads))--}}
{{--                    <div class="swiper-slide cursor-grab" data-hash="ads">--}}
{{--                        <!-- /7894359647/Mobile_300x600_1 -->--}}
{{--                        <div id='div-gpt-ad-1728582925576-0' style='width: 300px; height: 600px;'>--}}
{{--                            <script>--}}
{{--                                document.addEventListener('DOMContentLoaded', function() {--}}
{{--                                    setTimeout(() => {--}}
{{--                                        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1728582925576-0'); });--}}
{{--                                    }, {{ $timeout ?? 200 }}); // Domyślnie timeout to 200 ms--}}
{{--                                });--}}
{{--                            </script>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        @else--}}
{{--            @foreach($pages as $index => $page)--}}
{{--                <!-- Urządzenie mobilne -->--}}
{{--                <div class="swiper-slide relative" data-hash="{{ $index + 1 }}" data-history="{{ $index + 1 }}">--}}
{{--                    <div class="swiper-zoom-container">--}}
{{--                        <div class="swiper-zoom-target">--}}
{{--                            <div class="{{ $class }} w-full">--}}
{{--                                <x-slide :index="$index" :is-mobile="$isMobile" :pages="$page" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                     Inserty --}}
{{--                    @if(in_array($index, $inserts))--}}
{{--                        <div class="absolute top-0 left-0 w-full h-full z-50 pointer-events-none">--}}
{{--                            <div class="sub-swiper h-full w-full">--}}
{{--                                <div class="sub-swiper-wrapper swiper-wrapper">--}}
{{--                                    <x-insert-slide :index="$index" :inserts="$inserts" :insertData="$insertData" />--}}
{{--                                    <x-insert-slide-empty />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                     Inserty End --}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--    </div>--}}

{{--    <div class="swiper-button-prev sub-swiper-next"></div>--}}
{{--    <div class="swiper-button-next sub-swiper-next"></div>--}}
{{--</div>--}}
