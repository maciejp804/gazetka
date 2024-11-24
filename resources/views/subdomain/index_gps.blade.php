<x-layout>
    <x-slot:slug>
        {{  $slug }}
    </x-slot:slug>

    <x-slot:h1Title>
        {!! $h1Title !!}
    </x-slot:h1Title>
    <x-h1-title :h1Title="$h1Title"/>
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>
    <x-ad-1/>
    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <div class="w-full 1xl:w-265 m-auto">

            <x-section class="flex flex-col">
                <x-header-index-subdomain/>
            </x-section>


            <x-section>
                <x-h2-title class="flex" :see-more-status="false">Aktualne gazetki i katalogi</x-h2-title>
                <div class="flex flex-col gap-4 mb-4 h-full lg:flex-row lg:h-12">
                    <x-select id="category-select" :items="$leaflets_category"/>
                    <x-select id="time-select" :items="$leaflets_time"/>
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
                <x-section-filtr-results :ads-status="true" data-container-id="leaflet-container" :items="$leaflets" type="leaflet"/>
                <x-see-more class="pb-2" type="button">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section class="mb-5">
                <x-h2-title class="flex" :see-more-status="false">Sklepy w pobliżu Twojej lokalizacji</x-h2-title>
                <x-shop-list/>
            </x-section>

            <x-section>
                <x-map :map-id="'mapid'" :latitude="52.4057121" :longitude="16.9313448" :zoom="13" :markers="[
                    ['lat' => 52.4057121, 'lng' => 16.9313448, 'name' => 'biedronka'],
                    ['lat' => 52.4157121, 'lng' => 16.9213448, 'name' => 'lidl'],
                    ['lat' => 52.4257121, 'lng' => 16.9413448, 'name' => 'tchibo'],
                    ['lat' => 52.4257121, 'lng' => 16.9113448, 'name' => 'biedronka'],
                    ['lat' => 52.4057121, 'lng' => 16.9213448, 'name' => 'lidl'],
                ]" />

            </x-section>

            <x-section>
                <x-swiper-vouchers
                    swiper-class="vouchers-swiper-promo"
                    title="Kupony rabatowe"
                    :items="$vouchers"
                    :link="route('main.coupons')"/>
            </x-section>

            <x-section>
                <x-swiper
                    button-class="1"
                    image="http://165.232.144.14/media/online_stores/zabka_Dzn0OKy.png" name="Żabka" offer="10 ofert"
                    title="Podobne sieci handlowe"/>
                <x-see-more class="lg:hidden" href="#">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-ad-1/>

        </div>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">

        <x-shop-descripton image="/build/assets/cheery-little-girl-sitting-shopping-cart 1-HAk2Ec6j.png"/>

        <section class="flex flex-col w-full 2lg:w-265 m-auto">
            <x-swiper-blog title="Ostatnie wpisy blogowe"/>
        </section>

        <x-faq/>


    </div>

</x-layout>
