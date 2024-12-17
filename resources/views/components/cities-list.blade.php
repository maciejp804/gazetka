@props(['city' => true, 'href' => '#', 'mainRoute' => 'main.index'])
<div class="w-full px-4 ">
    <div class="w-full">
        <ul class="columns-2 text-sm md:columns-3 lg:columns-4">
            @if($city)
                <li class="py-2 text-gray-800"><a href="{{$href}}">Białystok</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Bielsko-Biała</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Bydgoszcz</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Bytom</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Chorzów</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Częstochowa</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Dąbrowa Górnicza</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Elbląg</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Gdańsk</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Poznań</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Warszawa</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Czechowice-Dziedzice</a></li>
            @else
                <li class="py-2 text-gray-800"><a href="http://lidl.gazetkapromocyjna.local">Lidl</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Biedronka</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Netto</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Aldi</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Dino</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Kaufland</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Carrefour</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Auchan</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Stokrotka</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Castorama</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Leroy Merlin</a></li>
                <li class="text-gray-800 py-2"><a href="{{$href}}">Obi</a></li>
            @endif

        </ul>
    </div>
</div>
<x-see-more class="lg:hidden" :main-route="$mainRoute">Zobacz wszystkie</x-see-more>


