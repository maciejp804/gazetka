<x-layout>
    <x-slot:place>
        {{ $place->name }}
    </x-slot:place>
    <x-slot:meta_title>
        {{  $meta_title }}
    </x-slot:meta_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>
    @push('preload')
        @foreach($leaflets_promo->take(5) as $leaflet)
            <link rel="preload" as="image" href="{{ Storage::url($leaflet->cover->webp_path.'.webp') }}" type="image/webp">
        @endforeach
    @endpush

    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>


    {{-- Reklama pozioma pod header --}}
    <div class="hidden 3xs:flex 3xs:w-full 3xs:min-h-25 2xs:min-h-70 my-5 mx-auto justify-center md:min-h-75">
        <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
        <x-admanager
            slot-name="homepage_header"
            :overrides="['page' => 'main.index_gps']"
        />
    </div>

    <div class="flex justify-center">

        {{-- Reklama pionowa po lewej stronie --}}
        <div class="hidden mt-5 justify-end xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_left"
                :overrides="['page' => 'main.index_gps']"
            />
        </div>

        <x-div-1060>
            <x-section>
                <x-h1-title :h1Title="$h1_title"/>

                <x-swiper-leaflets-promo
                    data-container-id="leaflet-swiper"
                    button-class="1"
                    :leaflets="$leaflets_promo"
                    main-route="main.leaflets"/>
            </x-section>

            <x-section>
                <x-swiper-info
                    data-container-id="info-swiper"
                    swiper-class="swiper-info"
                    :items="$info_description"/>
            </x-section>

            <x-section>
                <x-swiper
                    :items="$shops"
                    data-container-id="shop-swiper"
                    swiper-class="swiper-shops"
                    type="retailers"
                    title="Sieci handlowe"
                    main-route="main.retailers"
                />
            </x-section>

            {{-- Reklama pozioma - 1--}}

            <div class="hidden 3xs:flex min-h-150 my-5 mx-auto justify-center md:min-h-25 3xl:hidden">
                <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                <x-admanager
                    slot-name="homepage_middle_1"
                    :overrides="['page' => 'main.index_gps']"
                />
            </div>

            <x-section>
                <x-swiper-products
                    data-container-id="product-swiper"
                    :items="$products"
                    type="products"
                    swiper-class="swiper-product"
                    title="Najlepsze promocje"
                    main-route="main.products"/>
            </x-section>

           @if($markers->isNotEmpty())
                <x-section>
                    <x-h2-title
                        class="flex"
                        :see-more-status="false"
                        main-route="main.index">
                        Sklepy w pobliżu Twojej lokalizacji
                    </x-h2-title>
                    <x-shop-list
                        :markers="$markers"
                        :place="$place"
                    />
                </x-section>
           @endif


            <x-section>
                <x-map
                    :map-id="'mapid'"
                    :latitude="$place->lat"
                    :longitude="$place->lng"
                    :zoom="13"
                    :markers="$markers"
                    :place="$place"
                />

            </x-section>

            <x-section>
                <x-swiper-category
                    button-class="1"
                    title="Kategorie sieci handlowych"
                    :items="$shop_categories"
                    data-container-id="swiper-category"
                    swiper-class="category-swiper"
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
                    main-route="main.index.gps"
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


            <x-section>
                <x-h2-title class="flex " main-route="main.leaflets">Przeglądaj gazetki i katalogi</x-h2-title>
                <div class="filter-box">
                    <div class="flex flex-col gap-4 mb-4 lg:flex-row">
                        <x-select id="category-select" :items="$leaflets_category" placeholder="Kategoria" type="leaflets"/>
                        <x-select id="time-select" :items="$leaflets_time" placeholder="Sortuj..."/>
                        <x-search placeholder="Wpisz nazwę sieci... " :border="true"
                                  input-id="search-input-leaflet"
                                  result-id="results-box-leaflet"
                                  data-search-type="leaflets"
                                  data-container-id="leaflet-swiper-search"
                        >
                            <x-loupe-button href="#"/>
                        </x-search>
                    </div>
                    <x-swiper-leaflets-search
                        swiper-class="leaflet"
                        data-container-id="leaflet-swiper-search"
                        :leaflets="$leaflets"
                        type="leaflet"/>
                </div>

                <x-see-more class="lg:hidden pb-2" main-route="main.leaflets">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-swiper-blog
                    button-class="1"
                    swiper-class="swiper-blog"
                    title="Ostatnie wpisy blogowe"
                    main-route="main.blogs"
                    :blogs="$blogs"
                />
            </x-section>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <div class="hidden mt-5 justify-start xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_right"
                :overrides="['page' => 'main.index_gps']"
            />
        </div>

    </div>

    <x-section class="flex-col px-4 xl:m-auto w-full">

        {{-- Reklama pozioma nad footer --}}
        <div class="hidden 3xs:flex 3xs:w-full min-h-25 my-5 mx-auto justify-center md:min-h-75 xl:min-h-96">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_footer"
                :overrides="['page' => 'main.index_gps']"
            />
        </div>

        <div class="bg-gray-200 rounded py-4 mb-5 sm:py-20 ">
            <x-about class="1xl:w-265 lg:m-auto" :counter_leaflets="$counter_leaflets" :counter_shops="$counter_shops" :counter_products="$counter_products"/>
        </div>

        @if($descriptions != null)
            @if($descriptions->content != null)
                <x-description :items="$descriptions"/>
            @endif

            @if($descriptions->faq != null)
                <x-faq :items="$descriptions"/>
            @endif
        @endif




    </x-section>

</x-layout>
