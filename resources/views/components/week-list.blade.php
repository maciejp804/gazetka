@props(['placeAddress'])

@if($placeAddress->hours->isNotEmpty())
    <div class="flex flex-col w-full text-gray-500 font-normal text-sm">
        <span class="font-semibold text-sm px-5 py-2">Godziny otwarcia</span>
        @foreach($placeAddress->hours as $day)
            <div class="flex justify-between px-5 odd:bg-gray-100 even:bg-white py-2">
                <div class="flex justify-start">
                    <span>{{__('days.'.$day->day_of_work)}}</span>
                </div>
                <div class="flex justify-center gap-2">
                    <x-header.svg svg="clock" colour="fill-gray-300" />
                    @if(str_contains($day->day_of_work, 'non') && $day->opening_time == '00:00:00')
                        <span>zamknięte</span>
                    @else
                        <span>
                             @if(date("G:i",strtotime($day->opening_time))== '00:00')
                                 brak danych
                            @else
                                {{date("G:i",strtotime($day->opening_time))}}-{{date("G:i",strtotime($day->closing_time))}}
                            @endif
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="flex flex-col w-full text-gray-500 font-normal text-sm">
        <span class="font-semibold text-sm px-5 py-2">Godziny otwarcia</span>
        @foreach($placeAddress->default_opening_hours as $name=>$day)
            @if($name == 'monday')
                <div class="flex justify-between px-5 odd:bg-gray-100 even:bg-white py-2">
                    <div class="flex justify-start">
                        <span>Poniedziałek</span>
                    </div>
                    <div class="flex justify-center gap-2">
                        <x-header.svg svg="clock" colour="fill-gray-300" />
                        @if($day == '00:00-00:00')
                            <span>brak danych</span>
                        @else
                            <span>{{$day}}</span>
                        @endif
                    </div>
                </div>
                <div class="flex justify-between px-5 odd:bg-gray-100 even:bg-white py-2">
                    <div class="flex justify-start">
                        <span>Wtorek</span>
                    </div>
                    <div class="flex justify-center gap-2">
                        <x-header.svg svg="clock" colour="fill-gray-300" />
                        @if($day == '00:00-00:00')
                            <span>brak danych</span>
                        @else
                            <span>{{$day}}</span>
                        @endif
                    </div>
                </div>
                <div class="flex justify-between px-5 odd:bg-gray-100 even:bg-white py-2">
                    <div class="flex justify-start">
                        <span>Środa</span>
                    </div>
                    <div class="flex justify-center gap-2">
                        <x-header.svg svg="clock" colour="fill-gray-300" />
                        @if($day == '00:00-00:00')
                            <span>brak danych</span>
                        @else
                            <span>{{$day}}</span>
                        @endif
                    </div>
                </div>
                <div class="flex justify-between px-5 odd:bg-gray-100 even:bg-white py-2">
                    <div class="flex justify-start">
                        <span>Czwartek</span>
                    </div>
                    <div class="flex justify-center gap-2">
                        <x-header.svg svg="clock" colour="fill-gray-300" />
                        @if($day == '00:00-00:00')
                            <span>brak danych</span>
                        @else
                            <span>{{$day}}</span>
                        @endif
                    </div>
                </div>
                <div class="flex justify-between px-5 odd:bg-gray-100 even:bg-white py-2">
                    <div class="flex justify-start">
                        <span>Piątek</span>
                    </div>
                    <div class="flex justify-center gap-2">
                        <x-header.svg svg="clock" colour="fill-gray-300" />
                        @if($day == '00:00-00:00')
                            <span>brak danych</span>
                        @else
                            <span>{{$day}}</span>
                        @endif
                    </div>
                </div>
            @elseif($name == 'saturday')
                <div class="flex justify-between px-5 odd:bg-gray-100 even:bg-white py-2">
                    <div class="flex justify-start">
                        <span>Sobota</span>
                    </div>
                    <div class="flex justify-center gap-2">
                        <x-header.svg svg="clock" colour="fill-gray-300" />
                        @if($day == '00:00-00:00')
                            <span>brak danych</span>
                        @else
                            <span>{{$day}}</span>
                        @endif
                    </div>
                </div>
            @elseif($name == 'trading_sunday')
                <div class="flex justify-between px-5 odd:bg-gray-100 even:bg-white py-2">
                    <div class="flex justify-start">
                        <span>Niedziela handlowa</span>
                    </div>
                    <div class="flex justify-center gap-2">
                        <x-header.svg svg="clock" colour="fill-gray-300" />
                        @if($day == '00:00-00:00')
                            <span>brak danych</span>
                        @else
                            <span>{{$day}}</span>
                        @endif
                    </div>
                </div>
            @else
                <div class="flex justify-between px-5 odd:bg-gray-100 even:bg-white py-2">
                    <div class="flex justify-start">
                        <span>Niedziela niehandlowa</span>
                    </div>
                    <div class="flex justify-center gap-2">
                        <x-header.svg svg="clock" colour="fill-gray-300" />
                        @if($day == 'zamkniu0119te')
                            <span>zamknięte</span>
                        @else
                            <span>{{$day}}</span>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif

