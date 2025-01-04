@props(['shop'])
<div class="flex w-full justify-between bg-gray-200 p-4 rounded">
    <div class="flex flex-col gap-y-2 w-1/2">
        <span class="text-left font-medium text-gray-700">Oceń nas</span>
        <div class="flex flex-col md:flex-row gap-x-3 md:items-center">
            <span class="2xs:whitespace-nowrap text-gray-600">2.5 / 10529 (głosów)</span>
            <div class="flex flex-row w-full justify-start stars" id="star-rating">
                <span data-rating="1" class="text-2xl hover:before:absolute hover:before:text-2xl hover:before:content-['\2605'] hover:before:text-amber-600 cursor-pointer">☆</span>
                <span data-rating="2" class="text-2xl hover:before:absolute hover:before:text-2xl hover:before:content-['\2605'] hover:before:text-amber-600 cursor-pointer">☆</span>
                <span data-rating="3" class="text-2xl hover:before:absolute hover:before:text-2xl hover:before:content-['\2605'] hover:before:text-amber-600 cursor-pointer">☆</span>
                <span data-rating="4" class="text-2xl hover:before:absolute hover:before:text-2xl hover:before:content-['\2605'] hover:before:text-amber-600 cursor-pointer">☆</span>
                <span data-rating="5" class="text-2xl hover:before:absolute hover:before:text-2xl hover:before:content-['\2605'] hover:before:text-amber-600 cursor-pointer">☆</span>

            </div>
            <p id="rating-value">Ocena: 0</p>
        </div>
    </div>
    <div class="flex flex-col gap-y-2 w-1/2 justify-between">
        <span class="text-right font-medium text-gray-700">Polub nas</span>
        <ul class="flex justify-end gap-x-2 border-b">
            <x-header.link href="#" svg='facebook' sizeSvg="h-5 w-5" sizeLi="h-8 w-8" class="group"/>
            <x-header.link href="#" svg='instagram' sizeSvg="h-5 w-5" sizeLi="h-8 w-8" class="group"/>
            <x-header.link href="#" svg='pinterest' sizeSvg="h-5 w-5" sizeLi="h-8 w-8" class="group"/>
        </ul>
    </div>
</div>
<div class="flex flex-col md:flex-row mt-4 gap-x-3">
    <div class="flex w-full md:w-50 justify-center">
        <a href="{{route('subdomain.index', ['subdomain' => $shop->slug])}}">
            <img class="flex self-center" src="{{$shop->logo}}" alt="logo" />
        </a>
    </div>
    <div class="flex w-full">
         <span class="text-sm font-normal p-2">
             Integer condimentum sem turpis, volutpat mattis nisl porttitor in. Sed vulputate at mi a viverra.
             Praesent elementum dui in lectus sodales lobortis. Cras sed felis vitae ligula accumsan vestibulum
             quis aliquet magna. Praesent sit amet nisi vulputate, sollicitudin arcu a, varius justo.
             Nunc venenatis vestibulum varius. Nullam pellentesque, enim eget finibus dignissim,
             lorem tellus ultricies ante, sed dignissim metus risus nec massa.
         </span>
    </div>
</div>
