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
    <x-slot:meta_robots>
        {{  $meta_robots }}
    </x-slot:meta_robots>

    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>

    {{-- Reklama pozioma pod header --}}
    <div class="hidden 3xs:flex 3xs:w-full 3xs:min-h-25 2xs:min-h-70 my-5 mx-auto justify-center md:min-h-75">
        <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
        <x-admanager
            slot-name="homepage_header"
            :overrides="['page' => 'main.leaflets.category']"
        />
    </div>

    <div class="flex justify-center">

        {{-- Reklama pionowa po lewej stronie --}}
        <div class="hidden mt-5 justify-end xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_left"
                :overrides="['page' => 'main.leaflets.category']"
            />
        </div>

        <x-div-1060>
            <x-section>
                <x-h1-title :h1Title="$h1_title"/>
                <div class="filter-box flex flex-col gap-4 mb-4 lg:flex-row">
                    <x-select-drpodown-url :items="$product_categories" :category="$category" type="leaflets"/>
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
                <x-swiper-category
                    button-class="1"
                    data-container-id="swiper-category"
                    swiper-class="category-swiper"
                    title="Kategorie produktów"
                    :items="$product_categories"
                    category-route="main.products.category"
                    main-route="main.products"
                />
            </x-section>

            <x-section>
                <x-swiper-products
                    :items="$products"
                    type="products"
                    button-class="1"
                    swiper-class="swiper-product"
                    data-container-id="product-swiper"
                    title="Najczęściej szukane produkty"
                    main-route="main.products"
                />
            </x-section>



        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <div class="hidden mt-5 justify-start xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_right"
                :overrides="['page' => 'main.leaflets.category']"
            />
        </div>

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

    {{-- Reklama pozioma nad footer --}}
    <div class="hidden 3xs:flex min-h-25 my-5 mx-auto justify-center md:min-h-75 xl:min-h-96">
        <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
        <x-admanager
            slot-name="homepage_footer"
            :overrides="['page' => 'main.leaflets.category']"
        />
    </div>

</x-layout>
