@props(['swiperClass' => 'leafletPromo', 'title' => 'Brak', 'link' => '#'])

<x-swiper-leaflets :swiperClass="$swiperClass"/>

<x-see-more class="lg:hidden pb-2" :link="$link">Zobacz wszystkie</x-see-more>

