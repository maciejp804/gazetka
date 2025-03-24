@props(['swiperClass' => 'leafletPromo', 'title' => 'Brak', 'mainRoute' => '#', 'leaflets', 'dataContainerId' => null])

<x-swiper-leaflets :swiperClass="$swiperClass" :leaflets="$leaflets" :data-container-id="$dataContainerId"/>

<x-see-more class="lg:hidden pb-2" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>

