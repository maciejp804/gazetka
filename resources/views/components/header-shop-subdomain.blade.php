@props(['rateableId', 'averageRating', 'ratingCount', 'city' => '', 'subdomain' => '','model', 'id' => ''])

<x-rating-form :rateableId="$rateableId"
               :averageRating="$averageRating"
               :city="$city"
               :subdomain="$subdomain"
               :id="$id"
               :model="$model"/>

<div class="flex flex-col w-full lg:flex-row gap-x-2">
<div class="flex flex-col w-full lg:w-4/6">
    <div class="flex flex-col gap-x-2 sm:flex-row">
        <div class="flex w-full mb-5 sm:w-1/4 sm:mb-0">
            <div class="w-full rounded lg:aspect-square ">
                <div class="flex justify-center w-full h-full">
                    <img class="flex self-center w-3/5" src="https://i.iplsc.com/00080QLHB6X63YKY-C112.png" alt="logo">
                </div>
            </div>
        </div>
        <div class="flex flex-col w-full gap-x-2 1xs:flex-row sm:3/4">
            <div class="flex flex-col text-sm text-gray-700 w-full 1xs:w-4/6">
                <p class="font-semibold mb-2">Integer condimentum sem turpis, volutpat mattis nisl porttitor in. </p>
                <span>
                            Sed vulputate at mi a viverra. Praesent elementum dui in lectus sodales lobortis.
                            Cras sed felis vitae ligula accumsan vestibulum quis aliquet magna.
                            Praesent sit amet nisi vulputate, sollicitudin arcu a, varius justo.
                        </span>
            </div>
            <div class="flex w-full 1xs:w-2/6">
                <div class="1xs:aspect-square w-full rounded p-2 border bg-gray-100">
                    <div class="flex flex-col justify-center w-full h-full">
                        <x-header.svg svg="location"/>
                        <span class="text-center text-xs">Dino Wieleń</span>
                        <span class="text-center text-xs">os. Przytorze 36</span>
                        <x-rating-stars
                            class="flex-col justify-center"
                            :model="$model"
                            :average-rating="$averageRating"
                            :rating-count="$ratingCount"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col sm:flex-row my-5 gap-x-3">
        <div class="flex justify-between w-full mb-2">
            <x-week-list/>
        </div>
        <div class="flex w-full lg:hidden">
            <img class="object-cover rounded" src="{{asset('build/assets/shop-map-BX1_uGKc.png')}}" alt="image"/>
        </div>
    </div>
</div>

    <div class="hidden lg:flex lg:w-1/3">
        <img class="object-cover rounded" src="{{asset('build/assets/shop-map-BX1_uGKc.png')}}" alt="image">
    </div>


</div>
