<x-h2-title class="flex" :see-more-status="false">Sklepy w pobliżu Twojej lokalizacji</x-h2-title>

<div class="flex flex-col w-full text-gray-500 font-normal text-sm">
    @for($i=1; $i<=9; $i++)
        <div class="grid grid-cols-3 px-5 odd:bg-gray-100 even:bg-white py-2 rounded">
            <div class="flex justify-start">
                <span>Biedronka, Poznań, ul. Towarowa</span>
            </div>
            <div class="flex justify-center gap-2">
                <x-header.svg svg="clock" colour="fill-gray-300" />
                <span>06:00-21:00</span>
            </div>
            <div class="flex justify-end gap-2">
                <x-header.svg svg="location" colour="fill-gray-300"/>
                <a href="#" class="underline hover:text-black">Sprawdź na mapie</a>
            </div>
        </div>
    @endfor

</div>
