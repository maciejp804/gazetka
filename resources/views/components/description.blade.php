@props(['bg' => 'bg-white', 'items', 'product'])

@foreach($items->content as $item)
    @php
        $classes = 'flex flex-col w-full gap-2';
        $classes .= $loop->odd ? ' md:flex-row' : ' md:flex-row-reverse';
    @endphp

        <div {{$attributes->merge(['class' => $classes])}}>
        <div class="flex w-full md:w-5/12">
            <img
                src="{{asset($item['image'])}}"
                class="object-cover rounded"
                loading="lazy"
                alt="picture">
        </div>
        <div class="flex rounded md:w-7/12 p-4 2lg:px-14 md:py-4 {{$bg}}">
            <div class=" xl:flex xl:flex-col xl:h-full xl:justify-center w-full relative">
                <div class="relative mb-4">
                    <span class="absolute top-0 left-0 z-20 font-semibold text-blue-550">0{{$loop->iteration}}</span>
                    <span class="absolute top-0 left-0 text-extreme text-gray-300 font-bold">0{{$loop->iteration}}</span>
                </div>
                @if(isset($item['h2_title']))
                <x-description-h2>{!! $item['h2_title'] !!}</x-description-h2>
                @endif
                @if(isset($item['h3_title']))
                    <x-description-h3>{!! $item['h3_title'] !!}</x-description-h3>
                @endif


                        <x-description-p>
                            @if (!empty($item['body']))
                                {!! $item['body'] !!}
                            @endif
                        </x-description-p>



            </div>
        </div>
    </div>
@endforeach
