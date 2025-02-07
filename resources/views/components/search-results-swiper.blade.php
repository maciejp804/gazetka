{{-- Wyniki dla gazetek w swiper --}}
@if($searchType == 'leaflets')
    @foreach($results as $item)
        <x-leaflet-slide
            class="swiper-slide"
            :valid_from="$item->valid_from"
            :valid_to="$item->valid_to"
            :logo="$item->shop->logo_xs"
            :name="$item->shop->name"
            :slug="$item->shop->slug"
            :id="$item->id"
            :page="1"
            :image="$item->image_cover"
        />
    @endforeach
@endif
