@props(['swiperClass' => 'leafletPromo', 'title' => 'Brak', 'link' => '#', 'buttonClass'])

<x-swiper-leaflets :swiperClass="$swiperClass" :button-class="$buttonClass"/>

<x-see-more class="lg:hidden pb-2" :link="$link">Zobacz wszystkie</x-see-more>

