<x-layout>
    <x-slot:slug>
        {{$slug  }}
    </x-slot:slug>

    <x-slot:h1Title>
        {!! $h1Title !!}
    </x-slot:h1Title>
    <x-h1-title :h1Title="$h1Title"/>
    <x-breadcrumbs>Sieci handlowe</x-breadcrumbs>
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
        <div class="w-full xl:w-265 m-auto">
            <x-section>
                <div class="flex flex-col gap-4 mb-4 h-full lg:flex-row">
                    <x-select />
                    <x-select />
                    <x-search class="h-12" placeholder="Wpisz nazwę sieci... " :border="true">
                        <x-loupe-button href="#"/>
                    </x-search>
                </div>
                <div class="w-full">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5">
                        @for($i=1; $i<=12; $i++)
                            <div class="w-34 2xs:w-40 1xs:w-48 xs:w-52 sm:w-48 md:w-60 lg:w-44 2lg:w-50 xl:w-48">
                                <x-retailer class="relative" image="https://hoian.pl/assets/image/store/biedronka.png" name="Biedronka" offer="5 ofert"/>
                            </div>
                        @endfor
                    </div>
                </div>
                <x-see-more class="pb-2" type="button">Zobacz więcej</x-see-more>
            </x-section>

            <x-section>
                <x-h2-title class="hidden lg:flex" >Najnowsze gazetki promocyjne</x-h2-title>
                <x-swiper-leaflets-promo />
                <x-see-more class="lg:hidden pb-2" href="#">Zobacz wszystkie</x-see-more>
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
