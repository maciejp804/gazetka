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

        <x-div-1060>
            <x-section>
                <x-swiper-leaflets-promo
                    button-class="1"
                    title="Najnowsze gazetki promocyjne"
                    :link="route('main.leaflets')"/>
            </x-section>

            <x-section>
                <x-swiper-info/>
            </x-section>

            <x-section>
                <x-swiper
                    button-class="1"
                    image="https://hoian.pl/assets/image/store/biedronka.png" name="Biedronka" offer="5 ofert" title="Sieci handlowe" :link="route('main.retailers')"/>
            </x-section>

            <x-section>
                <x-city-descripton image="/build/assets/poznan-D9MWgM2z.png" bg="bg-white"/>
            </x-section>

            <x-section>
                <x-swiper
                    button-class="2"
                    image="https://hoian.pl/assets/media/products/1_dxXyvcN.png" name="pomidory"
                          offer="od 11.59 zł" title="Najczęściej szukane produkty" :link="route('main.products')"
                          :uri="route('main.product',['name' => 'pomidory', 'id' => 1])"
                />
            </x-section>

            <x-section>
                <x-shop-list/>
            </x-section>

            <x-section>
                <x-map :map-id="'mapid'" :latitude="52.4057121" :longitude="16.9313448" :zoom="13" :markers="[
                    ['lat' => 52.4057121, 'lng' => 16.9313448, 'name' => 'biedronka'],
                    ['lat' => 52.4157121, 'lng' => 16.9213448, 'name' => 'lidl'],
                    ['lat' => 52.4257121, 'lng' => 16.9413448, 'name' => 'tchibo'],
                    ['lat' => 52.4257121, 'lng' => 16.9113448, 'name' => 'biedronka'],
                    ['lat' => 52.4057121, 'lng' => 16.9213448, 'name' => 'lidl'],
                ]" />

            </x-section>

            <x-section>
                <x-swiper
                    button-class="3"
                    image="http://165.232.144.14/media/online_stores/zabka_Dzn0OKy.png" name="Żabka" offer="10 ofert" title="Sieci handlowe online" :link="route('main.retailers')"/>
            </x-section>

            <x-section>
                <x-swiper-category title="Kategorie sieci handlowych" image="https://hoian.pl/assets/image/category/default.png" name="Ogród" offer="10 ofert"/>
            </x-section>

            <x-section class="bg-gray-200 rounded">
                <x-h2-title see-more-status="fault" class="flex">Gazetki promocyjne w największych polskich miastach</x-h2-title>
                <x-cities-list />
                <x-see-more class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-swiper-vouchers swiper-class="vouchers-swiper-promo" title="Kupony rabatowe" :link="route('main.coupons')"/>
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
                <x-swiper-leaflets swiper-class="leaflet"/>
                <x-see-more class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section>
                <x-swiper-blog title="Ostatnie wpisy blogowe"/>
            </x-section>

            <x-ad-1/>
        </x-div-1060>

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
