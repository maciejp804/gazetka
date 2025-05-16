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
            :overrides="['page' => 'main.products.category']"
        />
    </div>

    <div class="flex justify-center">

        {{-- Reklama pionowa po lewej stronie --}}
        <div class="hidden mt-5 justify-end xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_left"
                :overrides="['page' => 'main.products.category']"
            />
        </div>

        <x-div-1060>

            <x-section>
                <x-h1-title :h1Title="$h1_title"/>

                <div class="filter-box flex flex-col mb-4">
                    <div class="flex flex-col gap-4 mb-4 lg:flex-row">
                        <x-select-drpodown-url :items="$product_categories" :category="$category" type="products"/>
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

                    @if($subcategories->count() > 0)
                        <x-swiper-category-small
                            data-container-id="small-category"
                            swiper-class="category-swiper-small"
                            data-subcategory="{{$subcategory}}"
                            :items="$subcategories"
                            :category="$category"
                            category-route="main.products.subcategory"
                            main-route="main.products"
                        />
                    @endif
                </div>


                <x-section-filtr-results :ads-status="true" data-container-id="products-container" :items="$products" type="products"/>
                {{ $products->links('custom-paginator') }}
            </x-section>

            <x-section>
                <x-h2-title class="flex"  main-route="main.leaflets">Najnowsze gazetki promocyjne</x-h2-title>
                <x-swiper-leaflets-promo
                    data-container-id="leaflet-swiper"
                    button-class="1"
                    title="Najnowsze gazetki promocyjne"
                    :leaflets="$leaflets"
                    main-route="main.leaflets"/>
            </x-section>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <div class="hidden mt-5 justify-start xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_right"
                :overrides="['page' => 'main.products.category']"
            />
        </div>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        {{-- Reklama pozioma nad footer --}}
        <div class="hidden 3xs:flex min-h-25 my-5 mx-auto justify-center md:min-h-75 xl:min-h-96">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_footer"
                :overrides="['page' => 'main.products']"
            />
        </div>
        @if($descriptions)
            @if(!empty($descriptions->content))
                <x-description :items="$descriptions"/>
            @endif

            @if(!empty($descriptions->faq))
                <x-faq :items="$descriptions"/>
            @endif
        @endif
    </div>

</x-layout>
