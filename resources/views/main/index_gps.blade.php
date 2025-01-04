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
                <x-swiper-leaflets-promo
                    button-class="1"
                    :leaflets="$leaflets"
                    main-route="main.leaflets"/>
            </x-section>

            <x-section>
                <x-swiper-info :items="$static_description"/>
            </x-section>

            <x-section>
                <x-swiper
                    :items="$shops"
                    button-class="1"
                    type="retailers"
                    title="Sieci handlowe w {{$place->name_locative}}"
                    main-route="main.retailers"
                />
            </x-section>

            <x-section>
                <x-city-descripton image="/build/assets/poznan-D9MWgM2z.png" bg="bg-white"/>
            </x-section>

            <x-section>
                <x-swiper
                    :items="$products"
                    type="products"
                    button-class="2"
                    title="Najlepsze promocje w {{$place->name_locative}}"
                    main-route="main.products"
                    :uri="route('main.product',['slug' => 'pomidory', 'id' => 1])"
                />
            </x-section>

            <x-section>
                <x-h2-title
                    class="flex"
                    :see-more-status="false"
                    main-route="main.index">
                    Sklepy w pobliżu Twojej lokalizacji
                </x-h2-title>
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
                <x-swiper
                    :items="$shops"
                    button-class="3"
                    type="retailers"
                    title="Sieci handlowe w {{$place->name_locative}}"
                    main-route="main.retailers"
                />
            </x-section>

            <x-section>
                <x-swiper-category
                    button-class="1"
                    title="Kategorie sieci handlowych"
                    :items="$shop_categories"
                    category-route="main.retailers.category"
                    main-route="main.retailers"
                />
            </x-section>

            <x-section class="bg-gray-200 rounded py-4">
                <x-h2-title
                    class="flex"
                    main-route="main.maps">
                    Gazetki promocyjne w największych polskich miastach
                </x-h2-title>

                <x-cities-list
                    main-route="main.index"
                    :items="$places"
                    />
            </x-section>

            <x-section>
                <x-swiper-vouchers
                    swiper-class="vouchers-swiper-promo"
                    title="Kupony rabatowe"
                    :items="$vouchers"
                    main-route="main.vouchers"
                    />
            </x-section>

            <x-ad-1 class="my-5"/>

            <x-section>
                <x-h2-title class="flex">Przeglądaj gazetki i katalogi</x-h2-title>
                <div class="filter-box flex flex-col gap-4 mb-4 lg:flex-row">
                    <x-select id="category-select" :items="$leaflets_category" placeholder="Kategoria" type="leaflets"/>
                    <x-select id="time-select" :items="$leaflets_time" placeholder="Sortuj..."/>
                    <x-search placeholder="Wpisz nazwę sieci... " :border="true"
                              input-id="search-input-leaflet"
                              result-id="results-box-leaflet"
                              data-search-type="leaflets"
                              data-container-id="leaflet-swiper"
                    >
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <x-swiper-leaflets swiper-class="leaflet" data-container-id="leaflet-swiper" :leaflets="$leaflets" type="leaflets"/>
                <x-see-more class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-swiper-blog title="Ostatnie wpisy blogowe"/>
            </x-section>

            <x-ad-1 class="my-5"/>
        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <x-section class="flex-col mx-4 xl:m-auto">
        <div class="bg-gray-200 rounded py-4 mb-5 sm:py-20 ">
            <x-about class="1xl:w-265 lg:m-auto"/>
        </div>
        <x-descripton :items="$descriptions"/>
        <x-faq/>
    </x-section>

</x-layout>
