@props(['type' => 'base', 'items' => '' ,'image' => '', 'name' => '', 'offer' => '',
'hoverDesc'=> 'Gazetka promocyjna <strong>Biedronka</strong>', 'swiperClass' => 'mySwiper',
'link' => '#', 'title' => 'Missing title', 'mainRoute'])

<x-h2-title class="flex" :main-route="$mainRoute">{!! $title !!}</x-h2-title>
<div class="w-full relative">
    <div class="swiper {{$swiperClass}} relative">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-10">
            @if($type === 'base')
                @for($i=0; $i<=10; $i++)
                    <!-- Slides -->
                    <x-base-slide :item="$item" :type="$type" :image="$image" :name="$name" :offer="$offer" :hover-desc="$hoverDesc"/>
                @endfor
            @elseif($type === 'retailers')
                @foreach($items as $item)
                    @php
                        if ($item->leaflets_count == 0)
                        {
                            $offer = 'Brak ofert';
                        } elseif ($item->leaflets_count == 1){
                            $offer = $item->leaflets_count. ' oferta';
                        } elseif ($item->leaflets_count > 1 && $item->leaflets_count< 5)
                        {
                            $offer = $item->leaflets_count. ' oferty';
                        } else {
                             $offer = $item->leaflets_count. ' ofert';
                        }

                    @endphp
                    <!-- Slides -->
                    <x-base-slide :item="$item" :type="$type" :image="$item->image" :name="$item->name" :offer="$offer"  :hover-desc="$item->name"/>
                @endforeach
            @elseif($type === 'products')
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


