@props(['image', 'bg' => 'bg-gray-200'])
<div class="flex flex-col w-full md:flex-row gap-2">
    <div class="flex w-full md:w-5/12">
        <img src="{{asset($image)}}" class="object-cover rounded">
    </div>
    <div class="flex rounded md:w-7/12 p-4 2lg:px-4 md:py-4 {{$bg}}">
        <div class="xl:flex xl:flex-col xl:h-full xl:justify-center">
            <x-description-h2>
                Integer condimentum sem turpis, volutpat mattis nisl porttitor in. Sed vulputate at mi a viverra. Praesent elementum dui in lectus sodales lobortis.
            </x-descripton-h2>
            <x-description-h3>
                Cras sed felis vitae ligula accumsan vestibulum quis aliquet magna. Praesent sit amet nisi vulputate, sollicitudin arcu a, varius justo. Integer condimentum sem turpis, volutpat mattis nisl porttitor in. Sed vulputate at mi a viverra. Praesent elementum dui in lectus sodales lobortis.
            </x-descripton-h3>
            <x-description-p>
                <div class="flex py-1">
                    <span class="font-semibold w-1/4">Powierzchnia:</span>
                    <span class="font-normal text-gray-400">261,8 km²</span>
                </div>
                <div class="flex py-1">
                    <span class="font-semibold w-1/4">Data założenia:</span>
                    <span class="font-normal text-gray-400">1253</span>
                </div>
                <div class="flex py-1">
                    <span class="font-semibold w-1/4">Liczba ludności:</span>
                    <span class="font-normal text-gray-400">540 365 (2016)</span>
                </div>
                <div class="flex py-1">
                    <span class="font-semibold w-1/4">Województwo:</span>
                    <span class="font-normal text-gray-400">wielkopolskie</span>
                </div>

            </x-descripton-p>
        </div>
    </div>
</div>
