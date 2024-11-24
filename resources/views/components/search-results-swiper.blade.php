{{-- Wyniki dla gazetek w swiper --}}
@if(isset($leaflets) && count($leaflets) > 0)
    @foreach($leaflets as $leaflet)
        <x-leaflet-slide class="swiper-slide" :leaflet="$leaflet"/>
    @endforeach
@endif
