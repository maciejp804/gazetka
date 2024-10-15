@props(['image', 'name', 'offer', 'hoverDesc'=> 'Gazetka promocyjna <strong>Biedronka</strong>'])

<div {{ $attributes }}>
    <div class="flex flex-col gap-y-2 text-center aspect-square justify-center w-full rounded border border-gray-200 ">
        <div class="aspect-square rounded flex justify-center">
            <a class="self-center w-full" href="http://dino.gazetkapromocyjna.local">
                <img class="w-1/2 m-auto" src="{{ $image }}" alt="pro-img1">
            </a>
            <x-heart-button class="border" iClass="text-gray-300 self-center hover:text-blue-550 transition duration-300 ease-in"/>
        </div>
        <div class="opacity-0 absolute w-full flex bg-blue-550 aspect-square rounded border border-blue-550 transition duration-500 hover:opacity-100">
            <div class="flex flex-col justify-center gap-y-6 aspect-square">
                <a href="http://dino.gazetkapromocyjna.local" class="flex justify-center aspect-square self-center w-10 h-10 bg-blue-400 rounded-full text-white hover:text-blue-550 transition duration-500 ease-in">
                    <i class="fa fa-solid fa-search self-center"></i>
                </a>
                <a href="http://dino.gazetkapromocyjna.local" class="text-white text-sm">
                    <span>{!! $hoverDesc !!}</span>
                </a>
            </div>

            <!--{% check_like item request as liked %}-->
            <x-heart-button class="border" iClass="text-blue-550 self-center hover:text-orange-500 transition duration-300 ease-in"/>

        </div>
    </div>
    <div class="text-center">
        <h3 class="text-gray-800 text-xs">
            <a href="http://dino.gazetkapromocyjna.local" class="font-semibold group-hover:font-bold">{{ $name }}</a>
        </h3>
        <div class="text-gray-500 group-hover:font-semibold text-xs"><span class="old-price">{{ $offer }}</span></div>
    </div>
</div>
