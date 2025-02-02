<x-layout>
     <x-slot:place>
        {{  $place }}
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

                <div class="filter-box flex flex-col gap-4 mb-4 lg:flex-row">
                    <x-select-drpodown-url :items="$product_categories" type="leaflets"/>
                    <x-select id="time-select" :items="$leaflet_sort" placeholder="Sortuj..."/>
                    <x-search placeholder="Wpisz nazwę sieci... " :border="true"
                              input-id="search-input-leaflet"
                              result-id="results-box-leaflet"
                              data-search-type="leaflets"
                              data-container-id="leaflet-container"

                    >
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>

                <x-section-filtr-results :ads-status="true" data-container-id="leaflet-container" :items="$leaflets" type="leaflets"/>

                {{ $leaflets->links('custom-paginator') }}
            </x-section>

            <x-section>
                <x-swiper-category title="Kategorie produktów"
                                   :items="$product_categories"
                                   category-route="main.products.category"
                                   main-route="main.products"
                />
            </x-section>

            <x-section>
                <x-swiper
                    :items="$products"
                    type="products"
                    button-class="1"
                    title="Najczęściej szukane produkty"
                    main-route="main.products"
                    :uri="route('main.product',['slug' => 'pomidory', 'id' => 1])"
                />
            </x-section>



            <x-ad-1 class="my-5"/>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        <x-descripton :items="$descriptions"/>
        <x-faq/>
    </div>

</x-layout>
