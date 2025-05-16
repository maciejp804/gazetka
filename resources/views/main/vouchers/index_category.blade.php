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
            :overrides="['page' => 'main.vouchers.category']"
        />
    </div>

    <div class="flex justify-center">

        {{-- Reklama pionowa po lewej stronie --}}
        <div class="hidden mt-5 justify-end xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_left"
                :overrides="['page' => 'main.vouchers']"
            />
        </div>

        <x-div-1060>

            <x-section>
                <x-h1-title :h1Title="$h1_title"/>
                <div class="filter-box flex flex-col gap-4 mb-4 lg:flex-row">
                    <x-select-drpodown-url :items="$voucher_categories" :category="$category" type="vouchers"/>
                    <x-select id="type-select" :items="$tags" placeholder="Typ Kuponu"/>
                    <x-select id="time-select" :items="$voucher_sort" placeholder="Sortuj..."/>
                    <x-search placeholder="Wpisz nazwę produktu... " :border="true"
                              input-id="search-input-vouchers"
                              result-id="results-box-vouchers"
                              data-search-type="vouchers"
                              data-container-id="vouchers-container"
                    >
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <x-section-filtr-results :ads-status="true" data-container-id="vouchers-container" :items="$vouchers" type="vouchers"/>
                {{ $vouchers->links('custom-paginator') }}
            </x-section>

            <x-section>
                <x-h2-title class="flex"
                            :link="route('main.leaflets')">
                    Najnowsze gazetki promocyjne
                </x-h2-title>

                <x-swiper-leaflets-promo
                    data-container-id="leaflet-swiper"
                    button-class="1"
                    :leaflets="$leaflets"
                    main-route="main.leaflets"/>
            </x-section>

            <x-section class="bg-gray-200 rounded py-4">
                <x-h2-title main-route="main.retailers" class="flex">Popularne sklepy</x-h2-title>
                <x-cities-list
                    :items="$shops"
                    main-route="subdomain.index"
                    :city="false"/>
                <x-see-more main-route="main.retailers" class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
            </x-section>


        </x-div-1060>
        {{-- Reklama pionowa po prawej stronie --}}
        <div class="hidden mt-5 justify-start xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_right"
                :overrides="['page' => 'main.vouchers']"
            />
        </div>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        {{-- Reklama pozioma nad footer --}}
        <div class="hidden 3xs:flex min-h-25 my-5 mx-auto justify-center md:min-h-75 xl:min-h-96">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_footer"
                :overrides="['page' => 'main.vouchers']"
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
