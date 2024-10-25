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

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <div class="w-full 1xl:min-w-265 1xl:w-265 m-auto flex flex-col">
            <x-section>
                <x-swiper-leaflets-promo title="Najnowsze gazetki promocyjne" :link="route('main.leaflets')"/>
            </x-section>

            <x-section>
                <x-carousel-info/>
            </x-section>

            <x-section>
                <x-swiper image="https://hoian.pl/assets/image/store/biedronka.png" name="Biedronka"
                          offer="5 ofert" title="Sieci handlowe" :link="route('main.retailers')"/>
            </x-section>

            <x-section>
                <x-swiper image="https://hoian.pl/assets/media/products/1_dxXyvcN.png" name="pomidory"
                          offer="od 11.59 zł" title="Najczęściej szukane produkty" :link="route('main.products')"
                          :uri="route('main.product',['name' => 'pomidory', 'id' => 1])"
                />
            </x-section>

            <x-section>
                <x-swiper image="http://165.232.144.14/media/online_stores/zabka_Dzn0OKy.png"
                          name="Żabka" offer="10 ofert" title="Sieci handlowe online" :link="route('main.retailers')"/>
            </x-section>

            <x-section>
                <x-swiper-category title="Kategorie sieci handlowych" image="https://hoian.pl/assets/image/category/default.png" name="Ogród" offer="10 ofert"/>
            </x-section>

            <x-section class="bg-gray-200 rounded">
                <x-h2-title see-more-status="fault" class="flex">Gazetki promocyjne w największych polskich miastach</x-h2-title>
                <x-cities-list href="/poznan"/>
            </x-section>

            <x-section>
                <x-swiper-vouchers swiper-class="vouchers-swiper-promo" title="Kupony rabatowe" :link="route('main.coupons')"/>
            </x-section>

            <x-ad-1/>

            <x-section>
                <x-h2-title class="flex " :link="route('main.leaflets')">Przeglądaj gazetki i katalogi</x-h2-title>
                <div class="flex flex-col gap-4 mb-4 lg:flex-row">
                    <x-select />
                    <x-select />
                    <x-search placeholder="Wpisz nazwę sieci... " :border="true">
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <x-swiper-leaflets swiper-class="leaflet"/>
                <x-see-more class="lg:hidden pb-2" :link="route('main.leaflets')">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-blog title="Ostatnie wpisy blogowe" :link="route('main.blogs')"/>
            </x-section>

            <x-ad-1/>
        </div>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        <div class="bg-gray-200 rounded my-4 ">
            <x-about class="1xl:w-265 lg:m-auto"/>
        </div>
        <x-descripton :items="$descriptions"/>
        <x-faq/>
    </div>

</x-layout>
