@props(['swiperClass', 'dataContainerId' => null, 'leaflets'])

{{--<div class="w-full">--}}
    <div class="swiper {{$swiperClass}} relative" id="{{$dataContainerId}}">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-8 flex relative">
           @foreach($leaflets as $leaflet)

                @if(!is_array($leaflet))

                    <x-leaflet-slide
                        class="swiper-slide flex w-50 flex-col"
                        style="width: 200px;"
                        :valid_from="$leaflet->valid_from"
                        :valid_to="$leaflet->valid_to"
                        :logo="$leaflet->shop->image"
                        :name="$leaflet->shop->name"
                        :slug="$leaflet->shop->slug"
                        :id="$leaflet->id"
                        :page="1"
                        :image_path="$leaflet->cover->path ?? null"
                        :webp_path="$leaflet->cover->webp_path ?? null"
                        :avif_path="$leaflet->cover->avif_path ?? null"

                    />
                @else
                    @foreach($leaflet['pages'] as $item)
{{--                        @dd($leaflet)--}}
                        <x-leaflet-slide
                            class="swiper-slide"
                            :valid_from="$item['clicks'][0]['valid_from']"
                            :valid_to="$item['clicks'][0]['valid_to']"
                            :logo="$leaflet['shop_image']"
                            :name="$leaflet['name']"
                            :slug="$leaflet['slug']"
                            :id="$leaflet['leaflet_id']"
                            :page="$item['page_number']"
                            :image_path="$item['page_image'] ?? null"
                            :avif_path="$item['page_image'] ?? null"
                            :webp_path="$item['page_image'] ?? null"
                        />
                    @endforeach
                @endif
           @endforeach
        </div>

        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <x-button-next
            class="button-next-{{$swiperClass}}"
            size="w-4 h-4"
            colour="gray-500"
        />
        <x-button-prev
            class="button-prev-{{$swiperClass}}"
            size="w-4 h-4"
            colour="gray-500"
        />
    </div>
{{--</div>--}}
