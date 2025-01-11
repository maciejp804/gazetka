<div class="flex flex-col w-full text-gray-500 font-normal text-xs md:text-sm">
    @for($i=1; $i<=9; $i++)
        <div class="grid grid-cols-5 gap-2 p-2 odd:bg-gray-100 even:bg-white rounded">
            <div class="col-span-3 flex items-center justify-start">
                <a href="http://dino.gazetkapromocyjna.local/wielen/os-przytorze-36" class="flex overflow-hidden">
                    <span class="truncate">Dino, Wieleń, os. Przytorze 36</span>
                </a>
            </div>
            <div class="flex items-center justify-center gap-2">
                <div class="hidden sm:flex">
                    <x-header.svg svg="clock" colour="fill-gray-300"/>
                </div>
                <span>06:00-21:00</span>
            </div>
            <div class="flex items-center justify-end gap-2">
                <div class="hidden sm:flex">
                    <x-header.svg svg="location" colour="fill-gray-300"/>
                </div>
                <a href="#" class="underline hover:text-black">Sprawdź</a>
            </div>
        </div>
    @endfor
</div>
