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
        <div class="w-full my-5">
            <div class="hidden 2xl:flex justify-end">
                <img src="https://placehold.co/300x600?text=Ads+300+x+600" alt="ad">
            </div>
            <div class="hidden 1xl:flex 2xl:hidden justify-end">
                <img src="https://placehold.co/160x600?text=Ads+160+x+600" alt="ad">
            </div>
        </div>
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
                                <x-leaflet class="relative"/>
                            </div>
                        @endfor
                    </div>
                </div>
                <x-see-more class="pb-2" type="button">Zobacz więcej</x-see-more>
            </x-section>

            <x-section>
                <x-swiper-network title="Kategorie produktów" image="{{asset('build/assets/nabial-B3NPvtdH.png')}}" name="Nabiał" offer="10 produktów"/>
            </x-section>

            <x-section>
                <x-h2-title class="flex" >Najczęściej szukane produkty</x-h2-title>
                <x-swiper image="https://hoian.pl/assets/media/products/1_dxXyvcN.png" name="pomidory" offer="od 11.59 zł"/>
            </x-section>



            <x-ad-1/>

        </div>
        <div class="w-full my-5">
            <div class="hidden 2xl:flex justify-start">
                <img src="https://placehold.co/300x600?text=Ads+300+x+600" alt="ad">
            </div>
            <div class="hidden 1xl:flex 2xl:hidden justify-start">
                <img src="https://placehold.co/160x600?text=Ads+160+x+600" alt="ad">
            </div>
        </div>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        <x-descripton/>
        <x-faq/>
    </div>

</x-layout>
