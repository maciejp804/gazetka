<x-layout>
    <x-slot:slug>
        {{$slug  }}
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
                <div class="filter-box flex flex-col gap-4 mb-4 h-full lg:flex-row">
                    <x-select id="category-select" :items="$retailers_category"/>
                    <x-select id="time-select" :items="$retailers_time"/>
                    <x-search placeholder="Wpisz nazwę produktu... " :border="true"
                              input-id="search-input-products"
                              result-id="results-box-products"
                              data-search-type="products"
                              data-container-id="products-container"

                    >
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <x-section-filtr-results :ads-status="true" data-container-id="products-container" :items="$products" type="product"/>
                <x-see-more class="pb-2" type="button">Zobacz więcej</x-see-more>
            </x-section>

            <x-section>
                <x-swiper-category title="Kategorie produktów"
                                   :items="$product_categories"
                                   :link="route('main.products')"
                />
            </x-section>


            <x-section>
                <x-h2-title class="flex"  :link="route('main.leaflets')">Najnowsze gazetki promocyjne</x-h2-title>
                <x-swiper-leaflets-promo
                    button-class="1"
                    title="Najnowsze gazetki promocyjne"
                    :leaflets="$leaflets"
                    :link="route('main.leaflets')"/>
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
