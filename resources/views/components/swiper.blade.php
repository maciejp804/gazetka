@props(['image', 'name', 'offer', 'uri' => 'http://dino.gazetkapromocyjna.local','hoverDesc'=> 'Gazetka promocyjna <strong>Biedronka</strong>', 'swiperClass' => 'mySwiper'])

<div class="w-full">
    <div class="swiper {{$swiperClass}}">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-10">
            @for($i=0; $i<=10; $i++)
                <!-- Slides -->
                <div class="swiper-slide group hidden">
                    <div class="flex flex-col gap-y-2 text-center aspect-square justify-center w-full rounded border border-gray-200 ">
                        <div class="aspect-square rounded flex justify-center">
                            <a class="self-center w-full" href="{{ $uri }}">
                                <img class="w-1/2 m-auto" src="{{ $image }}" alt="pro-img1">
                            </a>
                            <x-heart-button class="border" iClass="text-gray-300 self-center hover:text-blue-550 transition duration-300 ease-in"/>
                        </div>
                        <div class="opacity-0 absolute w-full flex bg-blue-550 aspect-square rounded border border-blue-550 transition duration-500 hover:opacity-100">
                            <div class="flex flex-col justify-center gap-y-6 aspect-square">
                                <a href="{{ $uri }}" class="flex justify-center aspect-square self-center w-10 h-10 bg-blue-400 rounded-full text-white hover:text-blue-550 transition duration-500 ease-in">
                                    <i class="fa fa-solid fa-search self-center"></i>
                                </a>
                                <a href="{{ $uri }}" class="text-white text-sm">
                                    <span>{!! $hoverDesc !!}</span>
                                </a>
                            </div>

                            <!--{% check_like item request as liked %}-->
                            <x-heart-button class="border" iClass="text-blue-550 self-center hover:text-orange-500 transition duration-300 ease-in"/>

                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-gray-800 text-xs">
                            <a href="{{ $uri }}" class="font-semibold group-hover:font-bold">{{ $name }}</a>
                        </h3>
                        <div class="text-gray-500 group-hover:font-semibold text-xs">
                            <span class="old-price">{{ $offer }}</span>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev !hidden"></div>
        <div class="swiper-button-next !hidden"></div>

    </div>
</div>


