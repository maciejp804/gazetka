@props(['item'])
<div {{ $attributes->merge(['class' => 'border border-dashed border-gray-200 rounded p-2 relative mb-3 sm:mb-0']) }}>
    <div class="flex h-36">
        <a href="{{$item->offer_url}}" class="flex" rel="nofollow">
        <div class="flex h-36 justify-center w-1/2">
            <div class="flex w-full h-max-30">
                <img class="object-cover rounded" src="{{$item->offer_image}}" alt="pro-img1">
            </div>
        </div>
        <div class="flex flex-col w-1/2 px-2 gap-y-2">
            <div class="w-36 lg:w-30 flex self-center">
                <img src="{{$item->voucherStore->logo_url}}" alt="pro-img2">
            </div>

            <h3 class="font-semibold text-xs">
                {{$item->title}}
            </h3>
            <span class="text-xs text-gray-400">{{monthReplace($item->start_date,'d-m')}} - {{monthReplace($item->end_date)}}</span>
        </div>
        </a>
    </div>
    <div class="text-xs text-gray-600 my-2">
        <a rel="nofollow" href="{{$item->offer_image}}">
            <span>{{$item->body}}</span>
        </a>
    </div>
    <div class="flex justify-center text-white rounded-full bg-blue-550 m-5 p-2">
        <a rel="nofollow" href="{{$item->offer_url}}">
            <span class="text-sm">
                @if($item->code)
                    Kod: {{$item->code}}
                @else
                    Nie potrzebujesz kodu
                @endif

            </span>
        </a>
    </div>
    <div class="flex absolute justify-center w-full left-0 gap-3">
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group shadow-2xl"><x-header.svg svg="facebook"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="instagram"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="pinterest"/></a>
    </div>
</div>
