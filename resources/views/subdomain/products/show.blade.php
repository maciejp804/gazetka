<x-layout>
     <x-slot:place>
        {{  $place->name }}
    </x-slot:place>
    <x-slot:page_title>
        {{  $page_title }}
    </x-slot:page_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>


    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>

    <x-ad-1 class="my-5"/>
    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <x-div-1060>


            <x-section>
                <x-h1-title :h1Title="$h1_title"/>
                <x-header-product-subdomain/>
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
                    class="leafletSingle"
                    button-class="1"
                    title="Nie znalazłeś czego szukasz? Sprawdź inne gazetki!"
                    :leaflets="$productsInNoShopLeaflets"
                    main-route="main.leaflets"/>
            </x-section>


            <x-ad-1/>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">

        @if($descriptions)
            <x-faq :items="$descriptions"/>
        @endif

    </div>

</x-layout>
