@php

$week = [
    ['day' => "Poniedziałek", 'open' => "06:00", 'close' => "21:00"],
    ['day' => "Wtorek", 'open' => "06:00", 'close' => "21:00"],
    ['day' => "Środa", 'open' => "06:00", 'close' => "21:00"],
    ['day' => "Czwartek", 'open' => "06:00", 'close' => "21:00"],
    ['day' => "Piątek", 'open' => "06:00", 'close' => "21:00"],
    ['day' => "Sobota", 'open' => "07:00", 'close' => "20:00"],
    ['day' => "Niedziela", 'open' => "08:00", 'close' => "18:00"],
]

@endphp
<div class="flex flex-col w-full text-gray-500 font-normal text-sm">
    <span class="font-semibold text-sm px-5 py-2">Godziny otwarcia</span>
    @foreach($week as $day)
        <div class="flex justify-between px-5 odd:bg-gray-100 even:bg-white py-2">
            <div class="flex justify-start">
                <span>{{$day['day']}}</span>
            </div>
            <div class="flex justify-center gap-2">
                <x-header.svg svg="clock" colour="gray-300" />
                <span>{{$day['open']}}-{{$day['close']}}</span>
            </div>
        </div>

    @endforeach

</div>
