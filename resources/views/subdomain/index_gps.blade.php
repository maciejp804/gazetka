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
            :overrides="['page' => 'subdomain.index.gps']"
        />
    </div>

    <div class="flex justify-center">

        {{-- Reklama pionowa po lewej stronie --}}
        <div class="hidden mt-5 justify-end xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_left"
                :overrides="['page' => 'subdomain.index.gps']"
            />
        </div>

        <x-div-1060>

            <x-section class="flex flex-col">
                <x-h1-title :h1Title="$h1_title"/>
                <x-header-index-subdomain
                :shop="$shop"
                :excerpt="$excerpt"
                :ratingCount="$ratingCount"
                :averageRating="$averageRating"
                :city="$place->slug"
                :subdomain="$subdomain"
                :model="$model"/>
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
                <x-shop-list
                    :markers="$markers"
                    :place="$place"
                />
            </x-section>

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
                <x-swiper-vouchers
                    button-class="1"
                    swiper-class="vouchers-swiper-promo"
                    title="Kupony rabatowe"
                    :items="$vouchers"
                    main-route="main.vouchers"/>
            </x-section>

            <x-section>
                <x-swiper
                    :items="$shopsOther"
                    button-class="1"
                    data-container-id="shop-swiper"
                    swiper-class="swiper-shops"
                    type="retailers"
                    title="Podobne sieci handlowe"
                    main-route="main.retailers"
                />
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
                :overrides="['page' => 'subdomain.index']"
            />
        </div>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        {{-- Reklama pozioma nad footer --}}
        <div class="hidden 3xs:flex min-h-25 my-5 mx-auto justify-center md:min-h-75 xl:min-h-96">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_footer"
                :overrides="['page' => 'main.index']"
            />
        </div>
        @if($descriptions->faq)
            <x-faq :items="$descriptions"/>
        @endif
    </div>
    <x-slot:scripts>
        @vite(['resources/js/rating.js'])
    </x-slot:scripts>

</x-layout>
