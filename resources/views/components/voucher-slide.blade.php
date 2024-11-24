@props(['item'])
<div {{ $attributes->merge(['class' => 'border-1 border-dashed border-gray-200 rounded p-2 relative mb-3 sm:mb-0']) }}>
    <div class="flex">
        <div class="flex self-center w-1/3">
            <div>
                <a href="{{$item['uri']}}" rel="nofollow">
                    <img src="{{$item['image']}}" alt="pro-img1">
                </a>
            </div>
        </div>
        <div class="flex flex-col w-2/3 px-2 gap-y-2">
            <div class="w-11 flex">
                <img src="{{$item['logo']}}" alt="pro-img1">
            </div>

            <h3 class="font-semibold text-sm">
                <a href="{{$item['uri']}}" rel="nofollow">
                    {{$item['description']}}
                </a>
            </h3>
            <span class="text-xs text-gray-400">29 WRZ - 9 PAŹ 2917 </span>
        </div>
    </div>
    <div class="text-xs text-gray-400 my-2">
        <span>Pobierz kod adidas i umieść go w koszyku zamówienia. Z kodem otrzymasz 30% rabatu na produkty nieprzecenione. </span>
    </div>
    <div class="flex justify-center text-white rounded-full bg-blue-550 m-5 p-2">
        <a rel="nofollow" href="{{$item['uri']}}" class="btn-kuponi" id="voucherLink">
            <span class="text-sm">
                Nie potrzebujesz kodu
            </span>
        </a>
    </div>
    <div class="flex absolute justify-center w-full left-0 gap-3">
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group shadow-2xl"><x-header.svg svg="facebook"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="instagram"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="pinterest"/></a>
    </div>
</div>
