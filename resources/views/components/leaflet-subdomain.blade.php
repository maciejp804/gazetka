@props(['swiperClass' => 'leafletPromo', 'isMobile', 'pages', 'inserts', 'ads', 'insertData'])
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
                                <x-slide :index="$index" :is-mobile="$isMobile" :pages="$pages"/>
                                @else <!-- Środkowe slajdy -->
                                <x-slide :index="$index-1" :is-mobile="$isMobile" :pages="$pages"/>
                                @if (isset($pages[$index]))
                                    <x-slide :index="$index" :is-mobile="$isMobile" :pages="$pages"/>
                                @else
                                    <x-slide-empty />
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Inserty --}}
                    @if(in_array($index + 1, $inserts))
                        <div class="absolute top-0 left-0 w-full z-50 pointer-events-none">
                            <div class="sub-swiper w-full">
                                <div class="sub-swiper-wrapper swiper-wrapper flex">
                                    <x-insert-slide-empty />
                                    <x-insert-slide :index="$index + 1" :inserts="$inserts" :insertData="$insertData"/>
                                    <x-insert-slide-empty />
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Inserty End --}}
                </div>
                @if((in_array($index + 1, $ads)))
                    <div class="swiper-slide cursor-grab" data-hash="ads">
                        <!-- /7894359647/Mobile_300x600_1 -->
                        <div id='div-gpt-ad-1728582925576-0' style='width: 300px; height: 600px;'>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    setTimeout(() => {
                                        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1728582925576-0'); });
                                    }, {{ $timeout ?? 200 }}); // Domyślnie timeout to 200 ms
                                });
                            </script>
                        </div>
                    </div>
                @endif
            @endfor
        @else
            @for ($index = 0; $index < count($pages); $index++)
                <!-- Urządzenie mobilne -->
                <div class="swiper-slide relative"  data-hash="{{$index + 1}}" data-history="{{$index + 1}}">
                    <div class="swiper-zoom-container">
                        <div class="swiper-zoom-target">
                            <div class="{{ $class }} w-full">
                            <x-slide :index="$index" :is-mobile="$isMobile" :pages="$pages"/>
                            </div>
                        </div>
                    </div>
                    {{-- Inserty --}}
                    @if(in_array($index, $inserts))
                        <div class="absolute top-0 left-0 w-full h-full z-50 pointer-events-none">
                            <div class="sub-swiper h-full w-full">
                                <div class="sub-swiper-wrapper swiper-wrapper">
                                    <x-insert-slide :index="$index" :inserts="$inserts" :insertData="$insertData" data="2"/>
                                    <x-insert-slide-empty />
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- Inserty End --}}
                </div>
            @endfor
        @endif
    </div>

    <div class="swiper-button-prev sub-swiper-next"></div>
    <div class="swiper-button-next sub-swiper-next"></div>

</div>



