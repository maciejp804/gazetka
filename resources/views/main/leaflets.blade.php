<x-layout>
    <x-slot:slug>
        {{$slug}}
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

        <x-div-1060>
            <x-section>
                <x-h2-title class="flex" :see-more-status="false">Aktualne gazetki i katalogi</x-h2-title>
                <div class="flex flex-col gap-4 mb-4 h-full lg:flex-row lg:h-12">
                    <x-select id="category-select" :items="$leaflets_category"/>
                    <x-select id="time-select" :items="$leaflets_time"/>
                    <x-search placeholder="Wpisz nazwę sieci... " :border="true"
                              input-id="search-input-leaflet"
                              result-id="results-box-leaflet"
                              data-search-type="leaflets"
                              data-container-id="leaflet-container"

                    >
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>

                <x-section-filtr-results :ads-status="true" data-container-id="leaflet-container" :items="$leaflets" type="leaflet"/>

                <x-see-more class="pb-2" type="button">Zobacz więcej</x-see-more>
            </x-section>

            <x-section>
                <x-swiper-category title="Kategorie produktów" image="{{asset('build/assets/nabial-B3NPvtdH.png')}}"
                                  name="Nabiał" offer="10 produktów" :link="route('main.products')"
                />
            </x-section>

            <x-section>
                <x-swiper
                    :items="$products"
                    type="products"
                    button-class="1"
                    title="Najczęściej szukane produkty"
                    :link="route('main.products')"
                    :uri="route('main.product',['name' => 'pomidory', 'id' => 1])"
                />
            </x-section>



            <x-ad-1/>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        <x-descripton :items="$descriptions"/>
        <x-faq/>
    </div>

</x-layout>
