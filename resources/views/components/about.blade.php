@props(['counter_leaflets', 'counter_shops', 'counter_products'])
<div {{ $attributes->merge(['class' => 'lg:flex justify-between w-full']) }} >
    <div class="flex-col lg:w-1/2 p-4">
        <x-h2-title see-more-status="false" class="flex">O nas</x-h2-title>
        <ul class="text-sm text-gray-700 ">
            <li class="mt-3">
                <h3 class="font-semibold text-base">
                    Gazetkapromocyjna.com.pl to miejsce stworzone z myślą o osobach, które chcą robić zakupy mądrze i oszczędnie.

                </h3>
            </li>
            <li class="mt-3">
                        <span>Zebraliśmy w jednym serwisie aktualne gazetki promocyjne z wielu znanych sieci handlowych –
                            od supermarketów i drogerii, po sklepy budowlane, sportowe i z wyposażeniem domu.
                        </span>
            </li>
            <li class="mt-3">
                        <span>Nie musisz już przeglądać stron każdego sklepu z osobna – u nas znajdziesz wszystko w jednym miejscu.
                            Wybierz interesującą Cię sieć handlową, kategorię produktów lub lokalizację,
                            a natychmiast zobaczysz dostępne gazetki i oferty promocyjne. Dzięki przejrzystej
                            prezentacji i codziennej aktualizacji zawsze masz dostęp do najświeższych promocji.</span>
            </li>

            <li class="mt-3">
                        <span>Serwis pozwala nie tylko przeglądać gazetki, ale również wyszukiwać konkretne produkty
                            na promocji. Planujesz zakupy? Sprawdź, gdzie kupisz taniej i zaplanuj swoją
                            listę już teraz – szybko, wygodnie i bez zbędnych kliknięć.</span>
            </li>

        </ul>
    </div>

    <ul class="flex flex-col text-sm text-gray-700 lg:w-1/2 p-4 justify-between">
        <li class="mt-3 flex justify-between gap-x-4 bg-white rounded-xl p-3">
            <span class="flex text-3xl text-blue-550 font-semibold w-1/5 justify-center self-center">{{$counter_products}}</span>
            <div class="w-4/5">
                <h3 class="font-semibold text-base">Produktów</h3>
                <span>Szukasz konkretnego artykułu w promocji? Wyszukaj go i zobacz, w której gazetce jest najtaniej!.</span>
            </div>
        </li>
        <li class="mt-3 flex justify-between gap-x-4 bg-white rounded-xl p-3">
            <span class="flex text-4xl text-blue-550 font-semibold w-1/5 justify-center self-center">{{$counter_shops}}</span>
            <div class="w-4/5">
                <h3 class="font-semibold text-base">Sieci handlowych</h3>
                <span>Czy wolisz markety, drogerie czy sklepy budowlane? U nas znajdziesz gazetki promocyjne z każdej branży.</span>
            </div>
        </li>
        <li class="mt-3 flex justify-between gap-x-4 bg-white rounded-xl p-3">
            <span class="flex text-4xl text-blue-550 font-semibold w-1/5 justify-center self-center">{{$counter_leaflets}}</span>
            <div class="flex flex-col w-4/5">
                <h3 class="font-semibold text-base">Aktualnych gazetek</h3>
                <span class="self-center">Codziennie aktualizowane oferty – wszystkie zebrane w jednym miejscu, gotowe do przeglądania online.</span>
            </div>
        </li>
    </ul>
</div>

