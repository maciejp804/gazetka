<x-layout>
     <x-slot:place>
        {{  $place }}
    </x-slot:place>
    <x-slot:page_title>
        {{  $page_title }}
    </x-slot:page_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>


    <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>
    <x-ad-1 class="my-5"/>
    <div class="flex">

        {{-- Reklama pionowa po lewej stronie --}}
        <x-ad-3-vertical site="justify-end"/>

        <x-div-1060>

            <x-section>
                <x-h1-title :h1Title="$h1_title"/>
                <x-header-product-domain :product="$product" :ratingCount="$ratingCount" :averageRating="$averageRating" :model="$model"/>
            </x-section>

            <x-section>
                <x-swiper-vouchers
                    button-class="1"
                    swiper-class="vouchers-swiper-promo"
                    title="Kupony rabatowe"
                    :items="$vouchers"
                    main-route="main.vouchers"/>
            </x-section>


                <x-section>
                    <x-swiper
                        :items="$products"
                        type="products"
                        button-class="1"
                        swiper-class="swiper-product"
                        title="Produkty z tej samej kategorii"
                        main-route="main.products"/>
                </x-section>


            <x-ad-1 class="mb-5"/>


        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        <x-faq/>
    </div>
    <x-slot:scripts>
        @vite(['resources/js/rating.js'])
    </x-slot:scripts>

</x-layout>
