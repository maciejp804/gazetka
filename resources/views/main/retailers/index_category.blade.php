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
            :overrides="['page' => 'main.shops.category']"
        />
    </div>

    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <div class="hidden mt-5 justify-end xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_left"
                :overrides="['page' => 'main.shops.category']"
            />
        </div>

        <x-div-1060>
            <x-section>
                <x-h1-title :h1Title="$h1_title"/>
                <div class="filter-box flex flex-col gap-4 mb-4 lg:flex-row">
                    <x-select-drpodown-url :items="$retailers_category" :category="$category" type="retailers"/>
                    <x-select id="time-select" :items="$retailers_time" placeholder="Sortuj..."/>
                    <x-search placeholder="Wpisz nazwę sieci... " :border="true"
                              input-id="search-input-retailers"
                              result-id="results-box-retailers"
                              data-search-type="retailers"
                              data-container-id="retailers-container"

                    >
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <x-section-filtr-results :ads-status="true" data-container-id="retailers-container" :items="$retailers" type="retailers"/>

                {{ $retailers->links('custom-paginator') }}
            </x-section>

            <x-section>
                <x-h2-title class="flex"  :link="route('main.leaflets')">Najnowsze gazetki promocyjne</x-h2-title>
                <x-swiper-leaflets-promo
                    data-container-id="leaflet-swiper"
                    button-class="1"
                    title="Najnowsze gazetki promocyjne"
                    :leaflets="$leaflets"
                    main-route='main.leaflets'/>
            </x-section>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <div class="hidden mt-5 justify-start xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_right"
                :overrides="['page' => 'main.shops.category']"
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
            :overrides="['page' => 'main.shops.category']"
        />
    </div>

</x-layout>
