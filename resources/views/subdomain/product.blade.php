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

        <x-div-1060>


            <x-section>
                <x-header-product-subdomain/>
            </x-section>


            <x-section>
                <x-h2-title class="flex" :see-more-status="false">Aktualne gazetki z tym produktem w Dino</x-h2-title>

                <div class="w-full">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5">
                        @for($i=1; $i<=4; $i++)
                            <div class="w-36 2xs:w-40 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-52 xl:w-56 1xl:w-48">
                                <x-leaflet-slide class="relative"/>
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
            </x-section>

            <x-section class="my-4">
                <x-swiper-leaflets-promo title="Nie znalazłeś czego szukasz? Sprawdź inne gazetki!" :link="route('main.leaflets')"/>
            </x-section>


            <x-ad-1/>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">

        <x-faq/>

    </div>

</x-layout>
