<x-layout>
    <x-slot:slug>
        {{  $slug }}
    </x-slot:slug>

    <x-slot:h1Title>
        {!! $h1Title !!}
    </x-slot:h1Title>

    <x-h1-title :h1Title="$h1Title"/>
    <x-breadcrumbs>Dino</x-breadcrumbs>
    <x-ad-1/>
    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <div class="w-full 1xl:w-265 mx-auto">

            <x-section>
                <x-header-shop-subdomain/>
            </x-section>


            <x-section>
                <x-h2-title class="flex" :see-more-status="false">Aktualne gazetki i katalogi Dino</x-h2-title>
                <div class="flex flex-col gap-4 mb-4 h-full lg:flex-row lg:h-12">
                    <x-select />
                    <x-select />

                </div>
                <div class="w-full">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5">
{{--                    <div class="flex flex-wrap gap-3">--}}
                        @for($i=1; $i<=12; $i++)
                            <div class="w-36 2xs:w-40 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-52 xl:w-56 1xl:w-48">
                                <x-leaflet class="relative"/>
                            </div>
                            @switch($i)
                                @case(5)
                                    <x-ad-1 class="hidden lg:grid lg:col-span-5"/>
                                    @break

                                @case(3)
                                    <x-ad-1 class="hidden sm:grid sm:col-span-3 lg:hidden"/>
                                    @break
                                @case(2)
                                @case(6)
                                @case(12)
                                    <x-ad-1 class="col-span-2 sm:hidden"/>
                                    @break
                            @endswitch
                        @endfor
                    </div>
                </div>
                <x-see-more class="pb-2" type="button">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-h2-title class="flex">Kupony rabatowe sklepu Dino</x-h2-title>
                <x-swiper-vouchers swiper-class="vouchers-swiper-promo"/>

            </x-section>

            <x-section>
                <x-h2-title class="flex" :see-more-status="false">Sklepy Dino w pobliżu Twojej lokalizacji</x-h2-title>
                <x-shop-list/>
            </x-section>



            <x-ad-1/>

        </div>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">




    </div>

</x-layout>
