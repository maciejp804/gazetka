<x-layout>
    <x-slot:slug>
        {{$slug}}
    </x-slot:slug>

    <x-slot:h1Title>
        {!! $h1Title !!}
    </x-slot:h1Title>
    <x-h1-title :h1Title="$h1Title"/>
    <x-breadcrumbs>Gazetki promocyjne</x-breadcrumbs>
    <x-ad-1/>
    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <div class="flex flex-col w-full 1xl:w-265 m-auto">
            <x-section>
                <x-h2-title class="flex" :see-more-status="false">Aktualne gazetki i katalogi</x-h2-title>
                <div class="flex flex-col gap-4 mb-4 h-full lg:flex-row lg:h-12">
                    <x-select />
                    <x-select />
                    <x-search placeholder="Wpisz nazwę sieci... " :border="true">
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <div class="w-full">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5">
                        @for($i=1; $i<=12; $i++)
                            <div class="w-34 2xs:w-40 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-52 xl:w-56 1xl:w-48">
                                <x-leaflet-slide class="relative"/>
                            </div>
                        @endfor
                    </div>
                </div>
                <x-see-more class="pb-2" type="button">Zobacz więcej</x-see-more>
            </x-section>

            <x-section>
                <x-shop-list/>
            </x-section>

            <x-section>
                <img src="{{asset('build/assets/map-BPSa5EXS.png')}}">
            </x-section>

            <x-section>
                <x-swiper-category title="Kategorie produktów" image="{{asset('build/assets/nabial-B3NPvtdH.png')}}"
                                  name="Nabiał" offer="10 produktów" :link="route('main.products')"
                />
            </x-section>

            <x-section>
                <x-swiper image="https://hoian.pl/assets/media/products/1_dxXyvcN.png" name="pomidory"
                          offer="od 11.59 zł" title="Najczęściej szukane produkty" :link="route('main.products')"
                          :uri="route('main.product',['name' => 'pomidory', 'id' => 1])"
                />
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
