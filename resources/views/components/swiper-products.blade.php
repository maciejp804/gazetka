@props(['type' => 'base', 'items' => '' ,'image' => '', 'name' => '', 'offer' => '',
'hoverDesc'=> 'Gazetka promocyjna <strong>Biedronka</strong>', 'swiperClass' => 'mySwiper',
'link' => '#', 'title' => 'Missing title', 'mainRoute', 'dataContainerId' => ''])

<x-h2-title class="flex" :main-route="$mainRoute">{!! $title !!}</x-h2-title>
<div class="w-full relative">
    <div id="skeleton-slider-{{$swiperClass}}" class="flex w-full relative mb-3 h-101 2xs:h-112 1xs:h-128 xs:h-99 sm:h-126 md:h-60 lg:h-64 ">
        <!-- Skeleton screen -->
        <div class="grid grid-cols-2 xs:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-x-1 1xs:gap-x-6 xs:gap-x-2.5 md:gap-x-1 lg:gap-x-4 gap-y-1 w-96 1xs:w-102.5 xs:w-110.75 sm:w-152 md:w-184 lg:w-238 xl:w-257">
            @for($i=0; $i<=3; $i++)
                <x-skeleton.product-slide-skeleton />
            @endfor
        </div>
    </div>

    <div class="swiper {{$swiperClass}} !hidden relative" id="{{$dataContainerId}}-{{$swiperClass}}">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-10">
            @if($type === 'base')
                @for($i=0; $i<=10; $i++)
                    <!-- Slides -->
                    <x-base-slide :item="$item" :type="$type" :image="$image" :name="$name" :offer="$offer" :hover-desc="$hoverDesc"/>
                @endfor
            @else
                @foreach($items as $item)
                    <!-- Slides -->

                    <x-product
                        class="swiper-slide"
                        :valid_from="$item['valid_from']"
                        :valid_to="$item['valid_to']"
                        :product_image="$item['product_image'] ?: $item['page_image']"
                        :product_name="$item['product_name']"
                        :product_slug="$item['product_slug']"
                        :promo_price="$item['promo_price'] ?: null"
                        :shop_image="$item['shop_image']"
                        :shop_slug="$item['shop_slug']"
                        :page_number="$item['page_number']"
                        :leaflet_id="$item['leaflet_id']"
                    />
                @endforeach
             @endif
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
</div>

<x-see-more class="lg:hidden" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>


