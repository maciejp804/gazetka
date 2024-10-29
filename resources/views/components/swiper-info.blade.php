@php
$info = array(
    1 => [
        'url' =>'https://hoian.pl/assets/image/pro/001-badge 1.png',
        'title' => 'Ponad 20 lat<br>doświadczenia',
        'titleHover' => 'Indywidualne podejście<br> do klienta <br>',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit dolor sit amet lorem.'
    ],
    2 => [
        'url' =>'https://hoian.pl/assets/image/pro/userstar.png',
        'title' => 'Indywidualne<br>podejście do klienta',
        'titleHover' => 'Indywidualne podejście<br> do klienta <br>',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit dolor sit amet lorem.'
    ],
    3 => [
        'url' =>'https://hoian.pl/assets/image/pro/003-sketch 1.png',
        'title' => 'Wyjątkowe <br>marki',
        'titleHover' => 'Indywidualne podejście<br> do klienta <br>',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit dolor sit amet lorem.'
    ],
    4 => [
        'url' =>'https://hoian.pl/assets/image/pro/004-newspapers 1.png',
        'title' => 'Ponad 1000<br>gazetek',
        'titleHover' => 'Indywidualne podejście<br> do klienta <br>',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit dolor sit amet lorem.'
    ],
    5 => [
        'url' =>'https://hoian.pl/assets/image/pro/005-hot-sale 1.png',
        'title' => 'Najlepsze<br>oferty',
        'titleHover' => 'Indywidualne podejście<br> do klienta <br>',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit dolor sit amet lorem.'
    ],

);
$count = count($info);

 @endphp
<div class="w-full">
    <div class="swiper swiper-info">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full">
        @for($i=1; $i<=$count; $i++)
        <div class="swiper-slide item">
            <div class="w-full bg-gray-100 rounded relative">
                <div class="flex flex-col gap-y-2 text-center aspect-square justify-center">
                    <div>
                        <a href="#">
                            <img src="{{ $info[$i]['url'] }}" class="flex !w-14 m-auto " alt="image">
                        </a>
                    </div>
                    <div>
                        <span class="font-semibold text-xs text-gray-700">{!! $info[$i]['title'] !!}</span>
                    </div>
                </div>
                <div class="absolute opacity-0 top-0 left-0 h-full w-full transition duration-500 bg-blue-550 hover:opacity-100 rounded">
                    <div class="text-gray-300 text-center flex flex-col aspect-square gap-y-1 justify-center font-semibold text-1xs">
                        <span class="font-semibold">{!! $info[$i]['titleHover'] !!}</span>
                        <span class="font-normal">{{$info[$i]['description']}}</span>
                    </div>
                </div>
            </div>
        </div>
        @endfor
        </div>
    </div>
</div>
