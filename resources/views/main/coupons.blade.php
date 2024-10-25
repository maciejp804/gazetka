<x-layout>
    <x-slot:slug>
        {{$slug}}
    </x-slot:slug>

    <x-slot:h1Title>
        {!! $h1Title !!}
    </x-slot:h1Title>
    <x-h1-title :h1Title="$h1Title"/>
    <x-breadcrumbs>Kupony rabatowe</x-breadcrumbs>
    <x-ad-1/>
    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <div class="w-full m-auto">
            <x-section class="flex flex-col 1xl:w-265">

                <div class="flex flex-col gap-4 mb-4 h-full lg:flex-row lg:h-12">
                    <x-select />
                    <x-select />
                    <x-select />
                    <x-search placeholder="Wpisz nazwę sieci... " :border="true">
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <div class="w-full mb-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
{{--                    <div class="flex flex-wrap gap-y-10 justify-between  h-full mb-16">--}}
                        @for($i=1; $i<=12; $i++)
                            <div class="w-full sm:w-72 md:w-80 lg:w-75 2lg:w-80 m-auto">
                                <x-voucher-slide class="mb-10"/>
                            </div>
                        @endfor
                    </div>
                </div>
                <x-see-more class="pb-2" type="button">Zobacz więcej</x-see-more>
            </x-section>

            <x-section class="bg-gray-200 rounded">
                <x-h2-title see-more-status="fault" class="flex">Popularne sklepy</x-h2-title>
                <x-cities-list :city="false"/>
                <x-see-more class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
            </x-section>



            <x-ad-1/>

        </div>
        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">

        <x-descripton :items="$descriptions"/>
        <x-faq/>
    </div>

</x-layout>
