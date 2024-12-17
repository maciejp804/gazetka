@props(['leaflet', 'ok' => false])

<div {{$attributes->merge(['class' => 'w-full border border-gray-200 rounded p-2 mb-5'])}}>
    <div class="relative bg-white flex items-center justify-center group">
        <div class="w-full">
            <a href="{{route('subdomain.leaflet', ['subdomain' => 'dino'])}}">
                <img class="rounded object-cover object-top w-full h-40 2xs:h-52 1xs:h-40 xs:h-44 sm:h-60 md:h-56 2lg:h-60 " src="{{$leaflet['logo']}}" alt="pro-img1">
            </a>
        </div>
        <a href="{{route('subdomain.leaflet', ['subdomain' => 'dino'])}}" class="hidden invisible absolute w-full h-full rounded justify-center 2xs:flex group-hover:bg-black group-hover:bg-opacity-50 group-hover:visible duration-300 ease-in">
            <div  class="hidden text-white group-hover:flex self-center justify-center font-bold text-xs w-24 h-8 bg-blue-550 rounded duration-300">
                <span class="flex self-center">Zobacz więcej</span>
            </div>
        </a>
    </div>
    <div class="py-2 text-center hover:bg-white hover:opacity-20">
        <a href="{{route('subdomain.leaflet', ['subdomain' => 'dino'])}}">
            <img class="max-w-16 block m-auto" src="https://hoian.pl/assets/image/store/lidl-69.png" alt="pro-img1">
            <h3 class="text-black text-xs font-bold">{{monthReplace($leaflet['start'],'d-m')}} - {{monthReplace($leaflet['end'])}}</h3>
            <div class="font-light mb-1 text-xs">
                <span class="overflow-hidden overflow-ellipsis whitespace-nowrap">GAZETKA {{strtoupper($leaflet['name'])}}</span>
            </div>
        </a>
    </div>
    <div class="flex absolute justify-center w-full left-0 gap-3">
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group shadow-2xl"><x-header.svg svg="facebook"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="instagram"/></a>
        <a href="#" class="border rounded-full w-7 h-7 bg-white flex justify-center -mt-1 group"><x-header.svg svg="pinterest"/></a>
    </div>
</div>
