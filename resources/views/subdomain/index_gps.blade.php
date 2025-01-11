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

        <div class="w-full 1xl:w-265 m-auto">

            <x-section class="flex flex-col">
                <x-h1-title :h1Title="$h1_title"/>
                <x-header-index-subdomain
                :shop="$shop"/>
            </x-section>


            <x-section>
                <x-h2-title class="flex" :see-more-status="false">Aktualne gazetki i katalogi</x-h2-title>
                <div class="filter-box flex flex-col gap-4 mb-4 h-full lg:flex-row lg:h-12">
                    <x-select id="category-select" :items="$leaflets_category" placeholder="Kategoria" type="leaflets"/>
                    <x-select id="time-select" :items="$leaflets_time" placeholder="Sortuj..."/>
                    <x-search placeholder="Wpisz nazwę sieci... " :border="true" class="hidden"
                              input-id="search-input-leaflet"
                              result-id="results-box-leaflet"
                              data-search-type="leaflets"
                              data-container-id="leaflet-container"
                              value="{{$subdomain}}"

                    >
                        <x-loupe-button href="#"/>
                    </x-search>

                </div>
                <x-section-filtr-results :ads-status="true" data-container-id="leaflet-container" :items="$leaflets" type="leaflets"/>

            </x-section>

            <x-section class="mb-5">
                <x-h2-title class="flex" :see-more-status="false">Sklepy {{$shop->name}} {{$place->name}} </x-h2-title>
                <x-shop-list/>
            </x-section>

            <x-section>
                <x-map :map-id="'mapid'" :latitude="52.4057121" :longitude="16.9313448" :zoom="13" :markers="[
                    ['lat' => 52.4057121, 'lng' => 16.9313448, 'name' => 'biedronka'],
                    ['lat' => 52.4157121, 'lng' => 16.9213448, 'name' => 'lidl'],
                    ['lat' => 52.4257121, 'lng' => 16.9413448, 'name' => 'tchibo'],
                    ['lat' => 52.4257121, 'lng' => 16.9113448, 'name' => 'biedronka'],
                    ['lat' => 52.4057121, 'lng' => 16.9213448, 'name' => 'lidl'],
                ]" />

            </x-section>

            <x-section>
                <x-swiper-vouchers
                    swiper-class="vouchers-swiper-promo"
                    title="Kupony rabatowe"
                    :items="$vouchers"
                    main-route="main.vouchers"/>
            </x-section>

            <x-section>
                <x-swiper
                    :items="$shopsOther"
                    button-class="1"
                    type="retailers"
                    title="Podobne sieci handlowe"
                    main-route="main.retailers"
                />
            </x-section>

            <x-ad-1 class="my-5"/>

        </div>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">

        <x-shop-descripton image="/build/assets/cheery-little-girl-sitting-shopping-cart 1-HAk2Ec6j.png"/>

        <section class="flex flex-col w-full 2lg:w-265 m-auto my-5">
            <x-swiper-blog title="Ostatnie wpisy blogowe"/>
        </section>

        <x-faq/>


    </div>

</x-layout>
