@php

$products = [
    'mleko', 'router przenośny 5G', 'gra na konsolę', 'wiadro', 'chleb pszenny', 'tabletki do zmywarki', 'smartfon',
    'lody', 'naleśniki z serem', 'powidła śliwkowe', 'piwo Tatra', 'pościel', 'szlifierka katowa akumulatorowa', 'mięso mielone wieprzowe',
    'akcesoria Halloween', 'młotowiertarka z udarem', 'kawa mielona', 'piżama damska', 'body niemowlęce', 'masło', 'ciasto instant', 'budyń'
]

@endphp

<div class="w-full">
    <div class="row product-box">
        <div>
            <div class="flex flex-wrap gap-2">
                @foreach($products as $product)
                    <a href="#" class="p-2 bg-gray-100 border border-gray-200 rounded hover:text-blue-550 ">
                        <span class="font-semibold">{{$product}}</span>
                    </a>
                @endforeach

            </div>

        </div>
    </div>
</div>
