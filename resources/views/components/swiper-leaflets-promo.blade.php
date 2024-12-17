@props(['swiperClass' => 'leafletPromo', 'title' => 'Brak', 'mainRoute' => '#', 'buttonClass', 'leaflets'])

<x-swiper-leaflets :swiperClass="$swiperClass" :button-class="$buttonClass" :leaflets="$leaflets"/>

<x-see-more class="lg:hidden pb-2" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>

