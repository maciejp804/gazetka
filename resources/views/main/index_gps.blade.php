<x-layout>
    <x-slot:slug>
        {{  $slug }}
    </x-slot:slug>

    <x-slot:h1Title>
        {!! $h1Title !!}
    </x-slot:h1Title>
    <x-h1-title :h1Title="$h1Title"/>
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
        <div class="w-full 1xl:w-265 m-auto">
            <x-section>
                <x-h2-title class="hidden lg:flex" >Najnowsze gazetki promocyjne</x-h2-title>
                <x-swiper-leaflets-promo />
                <x-see-more class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-carousel-info/>
            </x-section>

            <x-section>
                <x-h2-title class="flex">Sieci handlowe</x-h2-title>
                <x-swiper image="https://hoian.pl/assets/image/store/biedronka.png" name="Biedronka" offer="5 ofert"/>
                <x-see-more class="lg:hidden" href="#">Zobacz wszystkie</x-see-more>
            </x-section>
            <x-section>
                <x-city-descripton image="/build/assets/poznan-D9MWgM2z.png" bg="bg-white"/>
            </x-section>

            <x-section>
                <x-h2-title class="flex">Najczęściej szukane produkty</x-h2-title>
                <x-swiper image="https://hoian.pl/assets/media/products/1_dxXyvcN.png" name="pomidory" offer="od 11.59 zł"/>
                <x-see-more class="lg:hidden" href="#">Zobacz wszystkie</x-see-more>
            </x-section>
            <x-section>
                <x-shop-list/>
            </x-section>

            <x-section>
                <img src="{{asset('build/assets/map-BPSa5EXS.png')}}">
            </x-section>

            <x-section>
                <x-h2-title class="flex">Sieci handlowe online</x-h2-title>
                <x-swiper image="http://165.232.144.14/media/online_stores/zabka_Dzn0OKy.png" name="Żabka" offer="10 ofert"/>
                <x-see-more class="lg:hidden" href="#">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-swiper-network title="Kategorie sieci handlowych" image="https://hoian.pl/assets/image/category/default.png" name="Ogród" offer="10 ofert"/>
            </x-section>

            <x-section class="bg-gray-200 rounded">
                <x-h2-title see-more-status="fault" class="flex">Gazetki promocyjne w największych polskich miastach</x-h2-title>
                <x-cities-list />
                <x-see-more class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-h2-title class="flex">Kupony rabatowe</x-h2-title>
                <x-swiper-vouchers swiper-class="vouchers-swiper-promo"/>

            </x-section>

            <x-ad-1/>

            <x-section>
                <x-h2-title class="flex">Przeglądaj gazetki i katalogi</x-h2-title>
                <div class="flex flex-col gap-4 mb-4 lg:flex-row">
                    <x-select />
                    <x-select />
                    <x-search placeholder="Wpisz nazwę sieci... " :border="true">
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <x-swiper-leaflets-promo swiper-class="leaflet"/>
                <x-see-more class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-blog title="Ostatnie wpisy blogowe"/>
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
        <div class="bg-gray-200 rounded my-4 ">
            <x-about class="1xl:w-265 lg:m-auto"/>
        </div>
        <x-descripton/>
        <x-faq/>
    </div>

</x-layout>
