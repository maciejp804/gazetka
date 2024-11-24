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
                <div class="flex flex-col gap-4 mb-4 h-full lg:flex-row lg:h-12">
                    <x-select id="category-select" :items="$retailers_category"/>
                    <x-select id="time-select" :items="$retailers_time"/>
                    <x-search placeholder="Wpisz nazwę produktu... " :border="true"
                              input-id="search-input-vouchers"
                              result-id="results-box-vouchers"
                              data-search-type="vouchers"
                              data-container-id="vouchers-container"

                    >
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <x-section-filtr-results :ads-status="true" data-container-id="vouchers-container" :items="$vouchers" type="voucher"/>
                <x-see-more class="pb-2" type="button">Zobacz więcej</x-see-more>
            </x-section>

            <x-section class="bg-gray-200 rounded">
                <x-h2-title see-more-status="fault" class="flex">Popularne sklepy</x-h2-title>
                <x-cities-list :city="false"/>
                <x-see-more class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
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
