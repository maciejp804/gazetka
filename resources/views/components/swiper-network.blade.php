@props(['title', 'image', 'name', 'offer'])

<x-h2-title link="/sieci-handlowe-wszystkie,0" class="flex">{{ $title }}</x-h2-title>
<div class="w-full">
    <div class="swiper category-swiper">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-10">
            @for($i=1; $i<=10; $i++)
                <!-- Slides -->
                <div class="swiper-slide group">
                    <div class="flex flex-col gap-y-2 text-center aspect-square justify-center w-full rounded-full border border-gray-200  ">
                        <div class="aspect-square rounded-full flex justify-center group-hover:bg-blue-550 group-hover:bg-opacity-50">
                            <a class="self-center w-full" href="#">
                                <img class="w-3/4 rounded-full m-auto" src="{{ $image }}" alt="pro-img1">
                                <img class="absolute left-0 top-0 invisible opacity-0 aspect-square" src="https://hoian.pl/assets/image/pro/solid-color-image.png" alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-gray-800 text-xs">
                            <a href="#" class="font-semibold group-hover:font-bold">{{ $name }}</a>
                        </h3>
                        <div class="text-gray-500 group-hover:font-semibold text-xs"><span class="old-price">{{ $offer }}</span></div>
                    </div>
                </div>
            @endfor
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev !hidden"></div>
        <div class="swiper-button-next !hidden"></div>

        <!-- If we need scrollbar -->
        <div class="swiper-scrollbar"></div>
    </div>
</div>
<x-see-more class="lg:hidden" href="#">Zobacz wszystkie</x-see-more>

