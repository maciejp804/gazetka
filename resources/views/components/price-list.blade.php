@php

$list = [
    ['retailer' => "Carrefour", 'price' => "6.29", 'logo' => 'http://165.232.144.14/static/assets/image/pro/b1.png'],
    ['retailer' => "Biedronka", 'price' => "6.99", 'logo' => 'http://165.232.144.14/static/assets/image/pro/b2.png'],
    ['retailer' => "Lidl", 'price' => "6.99", 'logo' => 'http://165.232.144.14/static/assets/image/pro/b3.png'],
    ['retailer' => "Netto", 'price' => "6.99", 'logo' => 'http://165.232.144.14/static/assets/image/pro/b4.png'],
    ['retailer' => "Biedronka", 'price' => "7.99", 'logo' => 'http://165.232.144.14/static/assets/image/pro/b2.png'],
    ['retailer' => "Auchan", 'price' => "10.99",'logo' => 'http://165.232.144.14/static/assets/image/pro/b5.png'],
    ['retailer' => "Kaufland", 'price' => "12.49",'logo' => 'http://165.232.144.14/static/assets/image/pro/b6.png']
]

@endphp
<div class="flex flex-col w-full text-gray-500 font-normal text-sm">
    <div class="grid grid-cols-6 px-2">
        <span class="font-semibold text-xs py-2 col-span-3">Gazetki z produktem</span>
        <span class="font-semibold text-xs py-2 col-span-3">Cena</span>
    </div>

    @foreach($list as $offer)
        <div class="grid grid-cols-6 px-2 odd:bg-gray-100 even:bg-white py-2">
            <div class="col-span-3">
                <img class="self-center flex h-6" src="{{ url($offer['logo']) }}" alt="logo"/>
            </div>
            <div class="col-span-2">
                <span>{{$offer['price']}} zł</span>
            </div>
            <div class="col-span-1">
                <x-see-more class="pb-2" link="{{route('subdomain.leaflet',['subdomain'=> 'dino', 'id' => 1])}}">Zobacz</x-see-more>
            </div>
        </div>

    @endforeach

</div>
