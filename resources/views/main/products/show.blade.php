<x-layout>
     <x-slot:place>
        {{  $place }}
    </x-slot:place>
    <x-slot:meta_title>
        {{  $meta_title }}
    </x-slot:meta_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>


    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>
    {{-- Reklama pozioma pod header --}}
    <div class="hidden 3xs:flex 3xs:w-full 3xs:min-h-25 2xs:min-h-70 my-5 mx-auto justify-center md:min-h-75">
        <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
        <x-admanager
            slot-name="homepage_header"
            :overrides="['page' => 'main.product']"
        />
    </div>
    <div class="flex justify-center">

        {{-- Reklama pionowa po lewej stronie --}}
        <div class="hidden mt-5 justify-end xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_left"
                :overrides="['page' => 'main.product']"
            />
        </div>

        <x-div-1060>

            <x-section>
                <x-h1-title :h1Title="$h1_title"/>

                <x-header-product-domain :product="$product" :products-in-leaflets="$productInLeaflets" :ratingCount="$ratingCount" :averageRating="$averageRating" :model="$model" :descriptions="$descriptions"/>
            </x-section>
            @if(isset($products) && $products->isNotEmpty())
                <x-section>
                    <x-swiper-products
                        :items="$products"
                        type="products"
                        button-class="1"
                        data-container-id="product-swiper"
                        swiper-class="swiper-product"
                        title="Produkty z tej samej kategorii"
                        main-route="main.products"
                    />
                </x-section>

            @endif

            <x-section>
                <x-swiper-vouchers
                    button-class="1"
                    swiper-class="vouchers-swiper-promo"
                    title="Kupony rabatowe"
                    :items="$vouchers"
                    main-route="main.vouchers"/>
            </x-section>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <div class="hidden mt-5 justify-start xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_right"
                :overrides="['page' => 'main.product']"
            />
        </div>

    </div>

    <div class="flex-col mx-4 xl:m-auto">

        @if($descriptions)
            @if(!empty($descriptions->content))
                <x-description :items="$descriptions"/>
            @endif

            @if(!empty($descriptions->faq))
                <x-faq :items="$descriptions"/>
            @endif
        @endif


    </div>
    <x-slot:scripts>
        @vite(['resources/js/rating.js'])
    </x-slot:scripts>

</x-layout>
