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
                    <x-select-drpodown-url :items="$product_categories" type="products"/>
                    <x-select id="time-select" :items="$product_sort" placeholder="Sortuj..."/>
                    <x-search placeholder="Wpisz nazwę produktu... " :border="true"
                              input-id="search-input-products"
                              result-id="results-box-products"
                              data-search-type="products"
                              data-container-id="products-container"

                    >
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <x-section-filtr-results :ads-status="true" data-container-id="products-container" :items="$products" type="products"/>
                {{ $products->links('custom-paginator') }}
            </x-section>

            <x-section>
                <x-swiper-category
                    button-class="1"
                    swiper-class="category-swiper"
                    title="Kategorie produktów"
                    :items="$product_categories"
                    category-route="main.products.category"
                    main-route="main.products"
                />
            </x-section>


            <x-section>
                <x-h2-title class="flex"  :link="route('main.leaflets')">Najnowsze gazetki promocyjne</x-h2-title>
                <x-swiper-leaflets-promo
                    data-container-id="leaflet-swiper"
                    button-class="1"
                    :leaflets="$leaflets"
                    main-route="main.leaflets"/>
            </x-section>



            <x-ad-1 class="my-5"/>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
         @if($descriptions != null)
            @if($descriptions->content != null)
                <x-description :items="$descriptions"/>
            @endif

            @if($descriptions->faq != null)
                <x-faq :items="$descriptions"/>
            @endif
        @endif
    </div>

</x-layout>
