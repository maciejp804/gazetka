<x-layout>
     <x-slot:place>
        {{  $place }}
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
                <div class="filter-box flex flex-col gap-4 mb-4 h-full lg:flex-row lg:h-12">
                    <x-select-drpodown-url :items="$voucher_categories" type="vouchers"/>
                    <x-select id="type-select" :items="$tags" placeholder="Typ Kuponu"/>
                    <x-select id="time-select" :items="$voucher_sort" placeholder="Sortuj..."/>
                    <x-search placeholder="Wpisz nazwę sieci... " :border="true"
                              input-id="search-input-vouchers"
                              result-id="results-box-vouchers"
                              data-search-type="vouchers"
                              data-container-id="vouchers-container"

                    >
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <x-section-filtr-results :ads-status="true" data-container-id="vouchers-container" :items="$vouchers" type="vouchers"/>
                <x-see-more class="pb-2" type="button">Zobacz więcej</x-see-more>
            </x-section>

            <x-section class="bg-gray-200 rounded py-4">
                <x-h2-title main-route="main.retailers" class="flex">Popularne sklepy</x-h2-title>
                <x-cities-list
                    :items="$shops"
                    main-route="subdomain.index"
                    :city="false"/>
                <x-see-more main-route="main.retailers" class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
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
