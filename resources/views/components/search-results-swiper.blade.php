{{-- Wyniki dla gazetek w swiper --}}
@if($searchType == 'leaflets')

    @foreach($results as $item)
{{--        @dd($item)--}}
        <x-leaflet-slide
            class="swiper-slide"
            :valid_from="$item->valid_from"
            :valid_to="$item->valid_to"
            :updated_at="$item->updated_at"
            :logo="$item->shop->logo_xs"
            :name="$item->shop->name"
            :slug="$item->shop->slug"
            :id="$item->id"
            :page="1"
            :image_path="$item->path"
            :webp_path="$item->webp_path"
            :avif_path="$item->avif_path"
        />
    @endforeach
@endif
