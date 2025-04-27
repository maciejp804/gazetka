@props(['swiperClass' => 'leafletPromo', 'leaflet', 'isMobile', 'pages', 'inserts', 'ads'])
@php

    if($isMobile)
        $class = 'mobile-slide';
    else
        $class = 'flex flex-row';

@endphp


<div class="swiper {{ $swiperClass }} relative !hidden" id="swiper-container">
    <div class="flex relative h-10">
        <div class="swiper-pagination"></div>
    </div>
    <div class="swiper-wrapper">
        @if(!$isMobile)
            @for ($index = 0; $index <= count($pages); $index += 2)
{{--                @dd($pages[$index])--}}
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
