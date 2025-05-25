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

    <script>
        var ads = @json($ads);  // Przykład przekazania danych PHP do JS
        var inserts = @json($inserts);
    </script>
    <style>
        #preloader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        .swiper-zoom-container {
            align-items: start !important;
        }

    </style>

    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>


    {{-- Reklama pozioma pod header --}}
    <div class="hidden 3xs:flex 3xs:w-full 3xs:min-h-25 2xs:min-h-70 my-5 mx-auto justify-center md:min-h-75">
        <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
{{--         Banner 750×300/auto – header strony--}}
{{--        <x-ad position="homepage_header" />--}}

        <x-admanager
            slot-name="homepage_header"
            :overrides="['page' => 'main.leaflet']"
        />
    </div>
    <div class="flex justify-center mb-2">

        <x-div-1060>
            <x-section class="flex flex-col">
                <x-h1-title :h1Title="$h1_title"/>
                <x-header-index-subdomain
                    :shop="$shop"
                    :excerpt="$excerpt"
                    :ratingCount="$ratingCount"
                    :averageRating="$averageRating"
                    :id="$id"
                    :subdomain="$subdomain"
                    :model="$model"/>
            </x-section>
        </x-div-1060>



    </div>
    <div class="flex mb-5">
        {{-- Reklama pionowa po lewej stronie --}}
        <div class="hidden mt-5 justify-end 1xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_left"
                :overrides="['page' => 'subdomain.leaflet']"
            />
        </div>
        <x-div-1060-leaftet>
            <x-section class="relative">
                <x-skeleton.leaflet-subdomain-skeleton :is-mobile="$isMobile" swiperClass="swiper-container"/>
                <x-leaflet-subdomain
                    swiperClass="swiper-container"
                    :is-mobile="$isMobile"
                    :leaflet="$leaflet"
                    :pages="$pages"
                    :inserts="$inserts"
                    :ads="$ads"
                />
            </x-section>
            <div class="hidden lg:flex lg:justify-center lg:my-5 lg:min-h-75 mx-auto">
                <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                <x-admanager
                    slot-name="subdomain_middle_desktop_3"
                    :overrides="['page' => 'subdomain.index']"
                />
            </div>

            {{-- Reklama pozioma mobile- 2--}}
            <div class="flex justify-center my-5 min-h-70 mx-auto sm:hidden">
                <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-0 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
                <x-admanager
                    slot-name="subdomain_middle_mobile_2"
                    :overrides="['page' => 'subdomain.index']"
                />
            </div>

            @if(!empty($leaflets))
                <x-section class="my-4">
                    <x-h2-title
                        class="flex"
                        main-route="main.leaflets">
                        Inne gazetki danej sieci
                    </x-h2-title>

                    <x-swiper-leaflets-promo
                        swiper-class="leafletSingle"
                        data-container-id="leaflet-swiper"
                        button-class="1"
                        :leaflets="$leaflets"
                        main-route="main.leaflets"/>
                </x-section>
            @endif

            @if($products->isNotEmpty())
            <x-section class="my-4">
                <x-h2-title
                    class="flex"
                    main-route="main.products">
                    Wybrane produkty z tej gazetki
                </x-h2-title>

                <x-product-list
                    :products="$products"
                    :subdomain="$subdomain"/>

                <x-see-more
                    main-route="main.products"
                    class="lg:hidden py-2">
                    Zobacz wszystkie
                </x-see-more>
            </x-section>
            @endif
            <x-section class="my-4">
                <x-h2-title
                    class="flex"
                    main-route="main.leaflets">
                    Podobne gazetki innych sieci
                </x-h2-title>

                <x-swiper-leaflets-promo
                    swiper-class="leafletSingleOther"
                    data-container-id="leaflet-swiper"
                    button-class="1"
                    :leaflets="$similarLeaflets"
                    main-route="main.leaflets"/>
            </x-section>


            <x-section class="bg-gray-200 rounded py-5">
                <x-h2-title class="flex">Najbliższe miasta, w których znajdziesz sklepy Dino</x-h2-title>
                <x-cities-list
                    main-route="subdomain.index_gps"
                    :shop="$shop"
                    :items="$places"/>
                <x-see-more class="lg:hidden pb-2">Zobacz wszystkie</x-see-more>
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

        </x-div-1060-leaftet>

        {{-- Reklama pionowa po prawej stronie --}}
        <div class="hidden mt-5 justify-start 1xl:flex xl:min-w-40 2xl:min-w-75 h-full sticky top-10">
            <div class="relative before:content-['Reklama'] before:absolute before:-top-5 before:left-1/2 before:text-1xs before:uppercase before:tracking-wide before:text-gray-500"></div>
            <x-admanager
                slot-name="homepage_sidebar_right"
                :overrides="['page' => 'subdomain.leaflet']"
            />
        </div>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        @if($descriptions != null)
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
            :overrides="['page' => 'main.index']"
        />
    </div>
    <x-slot:scripts>
        @vite(['resources/js/rating.js', 'resources/js/leaflet-swiper.js'])
    </x-slot:scripts>
</x-layout>
