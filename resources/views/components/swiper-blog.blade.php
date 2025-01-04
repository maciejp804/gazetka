@props(['title' => 'Brak', 'mainRoute' => 'main.index'])
<x-h2-title class="flex" :main-route="$mainRoute">{!! $title !!}</x-h2-title>
<div class="w-full">
<div class="swiper swiper-blog">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper h-full mb-10">
    @for($i=0; $i<10; $i++)
        <div class="swiper-slide">
            <a href="/abc-zakupowicza/porady/chleb">
                <div class="flex w-full">
                    <img class="w-full h-40 2xs:h-48 object-cover rounded" src="{{asset('assets/images/statics/blog.png')}}" alt="pro-img1">
                </div>
                <div class="text-xs text-gray-600 pt-2">
                    <span>Jan. 8, 2024</span>
                </div>
                <h3 class="text-black font-bold text-sm py-2">
                     Lorem ipsum dolor sit amet consectetur
                </h3>
                <div class="text-xs text-gray-600">
                    <span class="old-price span_doglm7">Dolor sit amet, consectetur adipiscing elit. Ut posuere, urna nec vehicula.</span>
                </div>
            </a>
        </div>
    @endfor
    </div>
</div>
</div>
<x-see-more class="lg:hidden" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>
