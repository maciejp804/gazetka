<x-layout>
    <x-slot:place>
        {{ $place->name }}
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

            <x-section class="flex flex-col">
                <x-h1-title :h1Title="$h1_title"/>
                <x-header-index-subdomain
                    :shop="$shop"
                    :ratingCount="$ratingCount"
                    :averageRating="$averageRating"
                    :model="$model"/>
            </x-section>


            <x-section>
                <x-h2-title class="flex" :see-more-status="false">Aktualne gazetki i katalogi</x-h2-title>
                <div class="filter-box flex flex-col gap-4 mb-4 lg:flex-row lg:h-12">
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

            @if($products->isNotEmpty())
                <x-section>
                    <x-swiper
                        :items="$products"
                        type="products"
                        button-class="1"
                        swiper-class="swiper-product"
                        title="Promocje w {{$shop->name_locative}}"
                        main-route="main.products"
                    />
                </x-section>
            @endif


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
                    :items="$shops"
                    button-class="1"
                    swiper-class="swiper-shops"
                    type="retailers"
                    title="Podobne sieci handlowe"
                    main-route="main.retailers"
                />
            </x-section>

            <x-section class="bg-gray-200 rounded py-4">
                <x-h2-title see-more-status="fault" class="flex">Największe miasta, w których znajdziesz sklepy {{$shop->name}}</x-h2-title>
                <x-cities-list
                    main-route="subdomain.index_gps"
                    :shop="$shop"
                    :items="$places"/>
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

            <x-ad-1 class="my-5"/>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">

        <x-description :items="$descriptions"/>
        @if($descriptions->faq)
            <x-faq :items="$descriptions"/>
        @endif
    </div>
    <x-slot:scripts>
        @vite(['resources/js/rating.js'])
    </x-slot:scripts>
</x-layout>
