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
                <div class="flex flex-col gap-4 mb-4 h-full lg:flex-row">
                    <x-select />
                    <x-select />
                    <x-search class="h-12" placeholder="Wpisz nazwę sieci... " :border="true">
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>

                <div class="w-full">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-y-4">
                        @for($i=1; $i<=12; $i++)
                            <div class="w-34 2xs:w-40 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-50 xl:w-48">
                                <x-retailer-slide class="relative" image="https://hoian.pl/assets/image/store/biedronka.png" name="Biedronka" offer="5 ofert"/>
                            </div>
                        @endfor
                    </div>
                </div>
                <x-see-more class="pb-2" type="button">Zobacz więcej</x-see-more>
            </x-section>

            <x-section>
                <x-shop-list/>
            </x-section>

            <x-section class="mt-5">
                <img src="{{asset('build/assets/map-BPSa5EXS.png')}}">
            </x-section>

            <x-section>
                <x-swiper-leaflets-promo title="Najnowsze gazetki promocyjne" :link="route('main.leaflets')"/>
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
