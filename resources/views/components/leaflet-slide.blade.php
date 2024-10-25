<div {{$attributes->merge(['class' => 'border border-gray-200 rounded p-2 mb-5'])}}>
    <div class="relative bg-white flex items-center justify-center group">
        <div class="tr-pro-img">
            <a href="{{route('subdomain.leaflet', ['subdomain' => 'dino'])}}">
                <img class="rounded" src="https://hoian.pl/assets/media/promotions/zabka_UjzqnS0.png" alt="pro-img1">
            </a>
        </div>
        <div class="hidden invisible absolute w-full h-full rounded justify-center 2xs:flex group-hover:bg-black group-hover:bg-opacity-50 group-hover:visible duration-300 ease-in">
            <a href="{{route('subdomain.leaflet', ['subdomain' => 'dino'])}}" class="hidden text-white group-hover:flex self-center justify-center font-bold text-xs w-24 h-8 bg-blue-550 rounded duration-300">
                <span class="flex self-center">Zobacz więcej</span>
            </a>
        </div>
    </div>
    <div class="pt-4 text-center hover:bg-white hover:opacity-20">
        <a href="{{route('subdomain.leaflet', ['subdomain' => 'dino'])}}">
            <img class="max-w-16 block m-auto" src="https://hoian.pl/assets/image/store/lidl-69.png" alt="pro-img1">
            <h3 class="text-black text-xs font-bold">27 MAJ - 7 CZE 2024</h3>
            <div class="font-light mb-1 text-xs"><span class="old-price">GAZETKA LIDL</span></div>
        </a>
    </div>
    <div class="flex absolute justify-center w-full left-0 gap-3">
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group shadow-2xl"><x-header.svg svg="facebook"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="instagram"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="pinterest"/></a>
    </div>
</div>
