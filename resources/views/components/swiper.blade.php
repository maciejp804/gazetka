@props(['type' => 'base', 'items' => '' ,'image' => '', 'name' => '', 'offer' => '', 'uri' => 'http://dino.gazetkapromocyjna.local',
'hoverDesc'=> 'Gazetka promocyjna <strong>Biedronka</strong>', 'swiperClass' => 'mySwiper',
'link' => '#', 'title' => 'Missing title', 'buttonClass', 'mainRoute'])

<x-h2-title class="flex" :main-route="$mainRoute">{!! $title !!}</x-h2-title>

<div class="w-full relative">
    <div class="swiper {{$swiperClass}}">

        <!-- Additional required wrapper -->
        <div class="swiper-wrapper h-full mb-10">
            @if($type === 'base')
                @for($i=0; $i<=10; $i++)
                    <!-- Slides -->
                    <x-base-slide :item="$item" :type="$type" :image="$image" :name="$name" :offer="$offer" :hover-desc="$hoverDesc"/>
                @endfor
            @elseif($type === 'retailers')
                @foreach($items as $item)
                    <!-- Slides -->
                    <x-base-slide :item="$item" :type="$type" :image="$item->logo" :name="$item->name" offer="1 oferta"  :hover-desc="$item->name"/>
                @endforeach
            @elseif($type === 'products')
                @foreach($items as $item)
                    <!-- Slides -->
                    <x-product
                        class="relative swiper-slide"
                        :valid_from="$item['valid_from']"
                        :valid_to="$item['valid_to']"
                        :product_image="$item['product_image']"
                        :product_name="$item['product_name']"
                        :product_slug="$item['product_slug']"
                        :promo_price="$item['promo_price']"
                        :logo_xs="$item['logo_xs']"
                    />
                @endforeach
             @endif


        </div>

        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <x-button-next
            class="button-next-{{$buttonClass}}"
            size="w-4 h-4"
            colour="gray-500"
        />
        <x-button-prev
            class="button-prev-{{$buttonClass}}"
            size="w-4 h-4"
            colour="gray-500"
        />


    </div>
</div>

<x-see-more class="lg:hidden" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>


