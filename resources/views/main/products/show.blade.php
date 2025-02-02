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
                    swiper-class="vouchers-swiper-promo"
                    title="Kupony rabatowe"
                    :items="$vouchers"
                    main-route="main.vouchers"/>
            </x-section>

            <x-section>
                <x-h2-title class="flex" main-route="main.products">Podobne produkty w sklepach</x-h2-title>
                <div class="w-full">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-y-4">
                        @foreach($products as $item)
                            <x-product
                                :valid_from="$item['valid_from']"
                                :valid_to="$item['valid_to']"
                                :product_image="$item['product_image']"
                                :product_name="$item['product_name']"
                                :product_slug="$item['product_slug']"
                                :promo_price="$item['promo_price']"
                                :logo_xs="$item['logo_xs']"
                            />
                        @endforeach
                    </div>
                </div>
                <x-see-more class="flex lg:hidden pb-2" type="button">Zobacz więcej</x-see-more>
            </x-section>

            <x-ad-1 class="mb-5"/>


        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
        <x-ad-3-vertical site="justify-start"/>

    </div>

    <div class="flex-col mx-4 xl:m-auto">
        <x-descripton :items="$descriptions"/>
        <x-faq/>
    </div>

</x-layout>
