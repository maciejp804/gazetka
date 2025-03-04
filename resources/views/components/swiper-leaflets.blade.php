@props(['swiperClass', 'buttonClass'=> 0, 'dataContainerId' => null, 'leaflets'])

{{--<div class="w-full">--}}
    <div class="swiper {{$swiperClass}}" id="{{$dataContainerId}}">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-8 flex relative">
           @foreach($leaflets as $leaflet)

                @if(!is_array($leaflet))

                    <x-leaflet-slide
                        class="swiper-slide flex w-50 flex-col"
                        style="width: 200px;"
                        :valid_from="$leaflet->valid_from"
                        :valid_to="$leaflet->valid_to"
                        :logo="$leaflet->shop->logo_xs"
                        :name="$leaflet->shop->name"
                        :slug="$leaflet->shop->slug"
                        :id="$leaflet->id"
                        :page="1"
                        :image_path="$leaflet->cover->path"
                        :webp_path="$leaflet->cover->webp_path"
                        :avif_path="$leaflet->cover->avif_path"

                    />
                @else
                    @foreach($leaflet['pages'] as $item)
                        <x-leaflet-slide
                            class="swiper-slide"
                            :valid_from="$item['clicks'][0]['valid_from']"
                            :valid_to="$item['clicks'][0]['valid_to']"
                            :logo="$leaflet['logo']"
                            :name="$leaflet['name']"
                            :slug="$leaflet['slug']"
                            :id="$leaflet['leaflet_id']"
                            :page="$item['page_number']"
                            :image="$item['page_image']"
                        />
                    @endforeach
                @endif
           @endforeach
        </div>

        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <x-button-next
            class="button-next-{{$swiperClass}}-{{$buttonClass}}"
            size="w-4 h-4"
            colour="gray-500"
        />
        <x-button-prev
            class="button-prev-{{$swiperClass}}-{{$buttonClass}}"
            size="w-4 h-4"
            colour="gray-500"
        />
    </div>
{{--</div>--}}
