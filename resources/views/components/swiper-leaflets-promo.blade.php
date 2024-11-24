@props(['swiperClass' => 'leafletPromo', 'title' => 'Brak', 'link' => '#', 'buttonClass', 'leaflets'])

<x-swiper-leaflets :swiperClass="$swiperClass" :button-class="$buttonClass" :leaflets="$leaflets"/>

<x-see-more class="lg:hidden pb-2" :link="$link">Zobacz wszystkie</x-see-more>

