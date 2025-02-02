<x-layout>
    <x-slot:place>
        {{ $place }}
    </x-slot:place>
    <x-slot:page_title>
        {{  $page_title }}
    </x-slot:page_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>


    <x-ad-1 class="my-5"/>
    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <x-div-1060>

            <x-section>
                <x-h1-title :h1Title="$h1_title"/>

                <x-swiper-leaflets-promo
                    button-class="1"
                    :leaflets="$leaflets_promo"
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
                    title="Sieci handlowe"
                    main-route="main.retailers"
                />
            </x-section>

            <x-section>
                <x-swiper
                    :items="$products"
                    type="products"
                    button-class="2"
                    title="Najlepsze promocje"
                    main-route="main.products"/>
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
                    :items="$places"
                    />
                <x-see-more class="lg:hidden pb-2" main-route="main.maps">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-swiper-vouchers
                    button-class="1"
                    swiper-class="vouchers-swiper-promo"
                    title="Kupony rabatowe"
                    :items="$vouchers"
                    main-route="main.vouchers"/>
            </x-section>

            <x-ad-1 class="mb-5"/>

            <x-section>
                <x-h2-title class="flex " main-route="main.leaflets">Przeglądaj gazetki i katalogi</x-h2-title>
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
                <x-swiper-leaflets
                    button-class="1"
                    swiper-class="leaflet"
                    data-container-id="leaflet-swiper"
                    :leaflets="$leaflets"
                    type="leaflet"/>
                <x-see-more class="lg:hidden pb-2" main-route="main.leaflets">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-swiper-blog
                    button-class="1"
                    title="Ostatnie wpisy blogowe"
                    main-route="main.blogs"/>
            </x-section>

            <x-ad-1 class="mb-5"/>
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
