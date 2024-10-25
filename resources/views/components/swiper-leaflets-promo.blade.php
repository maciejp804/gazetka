@props(['swiperClass' => 'leafletPromo', 'title' => 'Brak', 'link' => '#'])

<x-h2-title class="hidden lg:flex" :link="$link">{!! $title !!}</x-h2-title>

<x-swiper-leaflets :swiperClass="$swiperClass"/>

<x-see-more class="lg:hidden pb-2" :link="$link">Zobacz wszystkie</x-see-more>

