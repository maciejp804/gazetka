<x-layout>
     <x-slot:place>
        {{  $place->name }}
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
            :overrides="['page' => 'subdomain.product']"
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

{{--    @dd($product)--}}
            <x-section>
                <x-h1-title :h1Title="$h1_title"/>
                <x-header-product-subdomain :item="$descriptions" :product="$product"/>
            </x-section>


            <x-section>
                <x-h2-title class="flex" :see-more-status="false">Aktualne gazetki z tym produktem w {{$shop->name}}</x-h2-title>
                <x-leaflet-product-results
                    :ads-status="true"
                    :products-in-leaflets="$productsInShopLeaflets"
                    :subdomain="$subdomain"
                    :shop="$shop"
                    type="products-leaflet"/>
            </x-section>

            <x-section class="my-4">
                <x-h2-title class="flex" main-route="main.leaflets" :see-more-status="false">Nie znalazłeś czego szukasz? Sprawdź inne gazetki!</x-h2-title>
                <x-swiper-leaflets-promo
                    swiper-class="leafletSingle"
                    data-container-id="leaflet-swiper"
                    title="Nie znalazłeś czego szukasz? Sprawdź inne gazetki!"
                    :leaflets="$productsInNoShopLeaflets"
                    main-route="main.leaflets"/>
            </x-section>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <div class="hidden mt-5 justify-start xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_right"
                :overrides="['page' => 'subdomain.product']"
            />
        </div>

    </div>

    @if($descriptions)
        <div class="flex-col mx-4 xl:m-auto">
            @if(!empty($descriptions->content))
                <x-description :items="$descriptions"/>
            @endif

            @if(!empty($descriptions->faq))
                <x-faq :items="$descriptions"/>
            @endif
        </div>
    @endif


</x-layout>
