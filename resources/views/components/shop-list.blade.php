@props(['markers', 'place'])
@if(isset($markers) && !empty($markers))
    <div class="flex flex-col w-full text-gray-500 font-normal text-xs md:text-sm">
        @foreach($markers->take(9) as $marker)
            <div class="grid grid-cols-5 gap-2 p-2 odd:bg-gray-100 even:bg-white rounded">
                <div class="col-span-3 flex items-center justify-start">
                    <a
                        href="{{route('subdomain.shop_address', ['subdomain' => $marker->shop->slug, 'community' => $marker->place->slug, 'address' => $marker->slug])}}"
                        class="flex overflow-hidden">
                        <span class="truncate">{{$marker->shop->name}}, {{$marker->place->name}}, {{$marker->address}}</span>
                    </a>
                </div>
                <div class="flex items-center justify-center gap-2">
                    @foreach($marker->hours as $hour)
                        @if(date("l") == mb_ucfirst($hour->day_of_work) && date("l") !== 'Sunday')
                            <div class="hidden sm:flex">
                                <x-header.svg
                                    svg="clock"
                                    colour="fill-gray-300"/>
                            </div>
                            @if($hour->opening_time == '00:00:00' || $hour->closing_time == '00:00:00')
{{--                                @dd($marker->default_opening_hours)--}}
{{--                                @php--}}
{{--                                    $default_time = json_decode($marker->default_opening_hours, true);--}}
{{--                                @endphp--}}
                                <span>
                                @if(date("l") == 'Sunday')
                                        {{$marker->default_opening_hours['non_trading_sunday']}}
                                    @elseif(date("l") == 'Saturday')
                                        {{$marker->default_opening_hours['saturday']}}
                                    @else
                                        {{$marker->default_opening_hours['monday']}}
                                    @endif
                            </span>
                            @else
                                <span>{{date("G:i",strtotime($hour->opening_time))}}-{{date("G:i",strtotime($hour->closing_time))}}</span>
                            @endif

                        @endif
                    @endforeach
                </div>
                <div class="flex items-center justify-end gap-2">
                    <div class="hidden sm:flex">
                        <x-header.svg svg="location" colour="fill-gray-300"/>
                    </div>
                    <a href="{{route('subdomain.shop_address', ['subdomain' => $marker->shop->slug, 'community' => $marker->place->slug, 'address' => $marker->slug])}}"
                       class="underline hover:text-black">Sprawdź</a>
                </div>
            </div>
        @endforeach
    </div>
@endif


