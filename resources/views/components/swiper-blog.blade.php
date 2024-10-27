@props(['title' => 'Brak', 'link' => '#'])
<x-h2-title class="flex" :link="$link">{!! $title !!}</x-h2-title>

<div class="swiper swiper-blog">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper h-full mb-10">
    @for($i=0; $i<10; $i++)
        <div class="swiper-slide">
            <div class="tr-pro-img member">
                <a href="#">
                    <img class="rounded-xl" src="http://165.232.144.14/media/blogs/5_ltC1WKM.png" alt="pro-img1">
                </a>
            </div>
            <div>
                <div class="text-xs text-gray-600 pt-2">
                    <span>Jan. 8, 2024</span>
                </div>
                <h3 class="text-black font-bold text-sm py-2">
                    <a href="#">Lorem ipsum dolor sit amet consectetur</a></h3>
                <div class="text-xs text-gray-600">
                    <span class="old-price span_doglm7">Dolor sit amet, consectetur adipiscing elit. Ut posuere, urna nec vehicula.</span>
                </div>
            </div>
        </div>
    @endfor
    </div>
</div>

<x-see-more class="lg:hidden" :link="$link">Zobacz wszystkie</x-see-more>
