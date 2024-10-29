<x-layout>
    <x-slot:slug>
        {{  $slug }}
    </x-slot:slug>

    <x-slot:h1Title>
        {!! $h1Title !!}
    </x-slot:h1Title>
    <script>
        var ads = @json($ads);  // Przykład przekazania danych PHP do JS
        var inserts = @json($inserts);
    </script>
    <style>
        #preloader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        .swiper-zoom-container {
            align-items: start !important;
        }

    </style>
    <x-h1-title :h1Title="$h1Title"/>
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>
    <x-ad-1/>
    <div class="flex mb-2">

        <x-div-1060>
            <x-section class="flex flex-col">
                <x-header-index-subdomain/>
            </x-section>
        </x-div-1060>



    </div>
    <div class="flex mb-5">
        <x-ad-2 justify="justify-end mt-10"/>
        <x-div-1060-leaftet>
            <x-section>
                <x-leaflet-subdomain swiperClass="swiper-container" :is-mobile="$isMobile" :pages="$pages" :inserts="$inserts" :ads="$ads" :insert-data="$insertData"/>
            </x-section>

            <x-section class="my-4">
                <x-h2-title class="flex">Wybrane produkty z tej gazetki</x-h2-title>
                <x-product-list/>
                    <x-see-more class="lg:hidden py-2" href="#">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-section class="my-4">
                <x-h2-title class="flex">Inne gazetki danej sieci</x-h2-title>
                <x-swiper-leaflets-promo title="Inne gazetki danej sieci"/>
            </x-section>

            <x-section>
                <x-h2-title class="flex">Zobacz inne aktualne gazetki</x-h2-title>
                <x-swiper-leaflets-promo title="Zobacz inne aktualne gazetki"/>
            </x-section>

            <x-section class="bg-gray-200 rounded">
                <x-h2-title see-more-status="fault" class="flex">Najbliższe miasta, w których znajdziesz sklepy Dino</x-h2-title>
                <x-cities-list />
                <x-see-more class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
            </x-section>

            <x-ad-1/>

        </x-div-1060-leaftet>

        <x-ad-2 justify="justify-star mt-10"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">

        <x-shop-descripton image="/build/assets/cheery-little-girl-sitting-shopping-cart 1-HAk2Ec6j.png"/>

        <section class="flex flex-col w-full 2lg:w-265 m-auto">
            <x-swiper-blog title="Ostatnie wpisy blogowe"/>
        </section>

        <x-faq/>


    </div>

</x-layout>
