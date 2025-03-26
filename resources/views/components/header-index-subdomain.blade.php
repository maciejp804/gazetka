@props(['shop', 'averageRating', 'ratingCount', 'city' => '', 'subdomain' => '','model', 'id' => ''])



<x-rating-form :rateableId="$shop->id"
               :averageRating="$averageRating"
               :city="$city"
               :subdomain="$shop->slug"
               :id="$id"
               :model="$model"/>


<div class="flex w-full justify-between bg-gray-200 p-4 rounded">
    <div class="flex flex-col gap-y-2 w-1/2">
        <span class="text-left font-medium text-gray-700">Oceń nas</span>
        <x-rating-stars class="flex-col lg:flex-row lg:items-center justify-start"
                        :average-rating="$averageRating"
                        :rating-count="$ratingCount"/>
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
            <img class="flex self-center" src="{{$shop->image}}" alt="logo" />
        </a>
    </div>
    <div class="flex w-full">
         <span class="text-sm font-normal p-2">

         </span>
    </div>
</div>
