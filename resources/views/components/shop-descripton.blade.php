@props(['image', 'bg' => 'bg-gray-200'])
<div class="flex flex-col w-full md:flex-row gap-2">
    <div class="flex w-full md:w-5/12">
        <img src="{{asset($image)}}" class="object-cover rounded">
    </div>
    <div class="flex rounded md:w-7/12 p-4 2lg:px-14 md:py-4 {{$bg}}">
        <div class=" xl:flex xl:flex-col xl:h-full xl:justify-center 2lg:w-3/5">
            <x-description-h2>
                Dino - gazetka promocyjna, aktualna oferta - co w niej znajdziesz?
            </x-description-h2>
            <x-description-h3>
                Gazetki promocyjne wydają wszystkie sieci handlowe. Znajdziesz je bezpośrednio
                        w sklepie, ale także w wygodniejszej formie w internecie.
            </x-description-h3>
            <x-description-p>
                Dzięki najnowszym ulotkom możesz w łatwy sposób dowiedzieć się o
                        aktualnych ofertach ulubionych miejsc. Warto zaglądać do gazetek promocyjnych w formacie pdf, bo to
                        właśnie w nich sieci handlowe informują o nowych produktach, które pojawią się w najbliższych
                        tygodniach. Są to zawsze rzeczy do znalezienia na półkach niezależnie od dnia, jak i wyjątkowe
                        produkty pojawiające się wyłącznie sezonowo.
            </x-description-p>
        </div>
    </div>
</div>
