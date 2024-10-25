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
                <x-header-product-domain />
            </x-section>

            <x-section>
                <x-swiper-vouchers swiper-class="vouchers-swiper-promo" title="Kupony rabatowe" :link="route('main.coupons')"/>
            </x-section>

            <x-section>
                <x-h2-title class="flex" :link="route('main.products')">Ten produkt znajdziesz w sklepach</x-h2-title>
                <div class="w-full">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-y-4">
                        @for($i=1; $i<=12; $i++)
                            <div class="w-34 2xs:w-40 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-50 xl:w-48">
                                <x-product class="relative"
                                           image="https://hoian.pl/assets/image/store/biedronka.png"
                                           name="Biedronka"
                                           offer="5 ofert"
                                           hoverDesc="Biedronka"
                                           :id=1

                                />
                            </div>
                        @endfor
                    </div>
                </div>
                <x-see-more class="flex lg:hidden pb-2" type="button">Zobacz więcej</x-see-more>
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
