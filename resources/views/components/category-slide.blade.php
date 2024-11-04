@props([ 'image', 'name', 'offer', 'uri' => '#'])
<div class="swiper-slide group">
    <div class="flex flex-col gap-y-2 text-center aspect-square justify-center w-full rounded-full border border-gray-200  ">
        <div class="aspect-square rounded-full flex justify-center group-hover:bg-blue-550 group-hover:bg-opacity-50">
            <a class="self-center w-full" href="{{$uri}}">
                <img class="w-3/4 rounded-full m-auto" src="{{ $image }}" alt="pro-img1">
            </a>
        </div>
    </div>
    <div class="text-center">
        <h3 class="text-gray-800 text-xs">
            <a href="{{$uri}}" class="font-semibold group-hover:font-bold">{{ $name }}</a>
        </h3>
        <div class="text-gray-500 group-hover:font-semibold text-xs"><span class="old-price">{{ $offer }}</span></div>
    </div>
</div>
