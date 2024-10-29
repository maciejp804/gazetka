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

                <x-section-filtr-results :ads-status="false">
                    <x-leaflet-slide class="relative"/>
                </x-section-filtr-results>
            </x-section>

            <x-section class="my-4">
                <x-h2-title class="flex" :link="route('main.leaflets')" :see-more-status="false">Nie znalazłeś czego szukasz? Sprawdź inne gazetki!</x-h2-title>
                <x-swiper-leaflets-promo/>
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
