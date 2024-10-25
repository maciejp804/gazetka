@php

$list = [
    ['name' => "Wartość energetyczna", 'value' => "1360 kJ"],
    ['name' => "Wartość energetyczna", 'value' => "323 kcal"],
    ['name' => "Tłuszcz", 'value' => "2,5 g"],
    ['name' => "– w tym kwasy tłuszczowe nasycone", 'value' => "0,5 g"],
    ['name' => "Węglowodany", 'value' => "54 g"],
    ['name' => "– w tym cukry", 'value' => "0,6 g"],
    ['name' => "Błonnik", 'value' => "18 g"],
    ['name' => "Białko", 'value' => "12 g"],
    ['name' => "Sól", 'value' => "< 0,01 g"]
]

@endphp
<div class="flex flex-col w-full text-gray-500 font-normal text-sm">
    <div class="grid grid-cols-6 px-2">
        <span class="font-bold text-xs py-2 col-span-5">Wartości odżywcze (%)</span>
        <span class="font-bold text-xs py-2 col-span-1">100g</span>
    </div>

    @foreach($list as $offer)
        <div class="grid grid-cols-6 px-2 odd:bg-gray-100 even:bg-white py-2 text-xs">
            <div class="col-span-5">
                <span>{{$offer['name']}}</span>
            </div>
            <div class="col-span-1">
                <span>{{$offer['value']}}</span>
            </div>
        </div>
    @endforeach

</div>
