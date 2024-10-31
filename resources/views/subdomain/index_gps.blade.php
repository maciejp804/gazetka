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
                    <x-select />
                    <x-select />

                </div>
                <div class="w-full">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5">
                        @for($i=1; $i<=12; $i++)
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
                <x-see-more class="pb-2" type="button">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section class="mb-5">
                <x-h2-title class="flex" :see-more-status="false">Sklepy w pobliżu Twojej lokalizacji</x-h2-title>
                <x-shop-list/>
            </x-section>

            <x-section>
                <img src="{{asset('build/assets/map-BPSa5EXS.png')}}">
            </x-section>

            <x-section>
                <x-swiper-vouchers swiper-class="vouchers-swiper-promo" title="Kupony rabatowe sieci Dino" :link="route('main.coupons')"/>
            </x-section>

            <x-section>
                <x-h2-title class="flex">Podobne sieci handlowe</x-h2-title>
                <x-swiper
                    button-class="1"
                    image="http://165.232.144.14/media/online_stores/zabka_Dzn0OKy.png" name="Żabka" offer="10 ofert"/>
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
