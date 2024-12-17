@props(['bg' => 'bg-white', 'items'])

@foreach($items as $item)
    @php
        $classes = 'flex flex-col w-full gap-2';
        $classes .= $loop->odd ? ' md:flex-row' : ' md:flex-row-reverse';
    @endphp

        <div {{$attributes->merge(['class' => $classes])}}>
        <div class="flex w-full md:w-5/12">
            <img src="{{$item['img']}}" class="object-cover rounded" alt="picture">
        </div>
        <div class="flex rounded md:w-7/12 p-4 2lg:px-14 md:py-4 {{$bg}}">
            <div class=" xl:flex xl:flex-col xl:h-full xl:justify-center w-full relative">
                <div class="relative mb-4">
                    <span class="absolute top-0 left-0 z-20 font-semibold text-blue-550">0{{$loop->iteration}}</span>
                    <span class="absolute top-0 left-0 text-extreme text-gray-300 font-bold">0{{$loop->iteration}}</span>
                </div>

                <x-descripton-h2>{!! $item['h2Title'] !!}</x-descripton-h2>
                <x-descripton-h3>{!! $item['h3Title'] !!}</x-descripton-h3>
                @foreach($item['p'] as  $p)
                    <x-descripton-p>{!! $p !!}</x-descripton-p>
                @endforeach

            </div>
        </div>
    </div>
@endforeach
