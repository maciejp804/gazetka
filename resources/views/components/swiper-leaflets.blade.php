@props(['swiperClass',  'dataContainerId' => null, 'leaflets'])

<div id="skeleton-slider-{{$swiperClass}}" class="flex w-full relative mb-4 h-140 2xs:h-184 md:h-96 lg:h-99">
    <!-- Skeleton screen -->
    <div  class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-x-4 gap-y-12 w-96 1xs:w-102.5 xs:w-110.75 sm:w-152 md:w-184 lg:w-238 xl:w-257">
        @for($i = 0; $i < 4; $i++)
            <div {{$attributes->merge(['class' => 'border border-gray-200 rounded p-2 mb-5 relative w-full'])}}>
                <div class="relative bg-white flex items-center justify-center group overflow-hidden">
                    <div class="w-full">
                        <div class="block w-full h-40 2xs:h-52 xs:h-52 sm:h-60 md:h-56 2lg:h-60 bg-gray-200 rounded animate-pulse"></div>
                    </div>
                </div>

                {{-- Skeleton dla treści pod obrazkiem --}}
                <div class="py-2 text-center hover:bg-white hover:opacity-20">
                    <div class="w-8 h-8 mx-auto bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-4 bg-gray-200 rounded my-2 w-3/4 mx-auto animate-pulse"></div>
                    <div class="h-3 bg-gray-200 rounded w-1/2 mx-auto animate-pulse"></div>
                </div>

                {{-- Skeleton dla ikon social media --}}
                <div class="flex absolute justify-center w-full left-0 gap-3 z-20">
                    <div class="border rounded-full w-7 h-7 bg-gray-200 flex justify-center -mt-1 shadow-2xl animate-pulse"></div>
                    <div class="border rounded-full w-7 h-7 bg-gray-200 flex justify-center -mt-1 animate-pulse"></div>
                    <div class="border rounded-full w-7 h-7 bg-gray-200 flex justify-center -mt-1 animate-pulse"></div>
                </div>
            </div>
        @endfor
    </div>
</div>

{{--<div class="w-full">--}}
    <div class="swiper {{$swiperClass}} !hidden relative" id="{{$dataContainerId}}-{{$swiperClass}}">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-8 flex relative">
           @foreach($leaflets as $leaflet)

                @if(!is_array($leaflet))

                    <x-leaflet-slide
                        class="swiper-slide flex w-50 flex-col"
                        style="width: 200px;"
                        :valid_from="$leaflet->valid_from"
                        :valid_to="$leaflet->valid_to"
                        :updated_at="$leaflet->updated_at"
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
                            :updated_at="$item['clicks'][0]['updated_at']"
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
