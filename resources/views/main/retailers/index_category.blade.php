<x-layout>
     <x-slot:place>
        {{  $place->name }}
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
                    button-class="1"
                    title="Najnowsze gazetki promocyjne"
                    :leaflets="$leaflets"
                    main-route='main.leaflets'/>
            </x-section>




            <x-ad-1 class="my-5"/>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        <x-descripton :items="$descriptions"/>
        <x-faq/>
    </div>

</x-layout>
