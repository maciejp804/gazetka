@props(['product', 'productsInLeaflets','averageRating', 'ratingCount', 'model', 'city' => '', 'subdomain' => '', 'id' => '', 'descriptions'])

<x-rating-form :rateableId="$product->id"
               :averageRating="$averageRating"
               :city="$city"
               :subdomain="$subdomain"
               :id="$id"
               :model="$model"/>

<div class="flex flex-col w-full lg:flex-row gap-x-2">
    <div class="flex flex-col w-full lg:w-1/6">
        <div class="flex w-full mb-5">
            <div class="w-full rounded lg:aspect-square ">
                <div class="flex justify-center w-full h-full">
                    <img class="flex self-center w-4/5"
                         @if(!empty($product->image))
                            src="{{$product->image}}"
                         @else
                            src="{{asset($product->category->logo)}}"
                         @endif
                         alt="logo">
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col w-full lg:w-1/2">
        <div class="flex flex-col gap-x-2 sm:flex-row">
            <div class="flex flex-col w-full gap-x-2 1xs:flex-row sm:2/3">
                <div class="flex flex-col text-sm text-gray-700 w-full">
                    <span>{{$product->description}}</span>
                </div>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row my-5 gap-x-3">
            <div class="flex justify-between w-full mb-2">
                @if(isset($descriptions->content[0]['parameter']))
                    <x-values-list :descriptions="$descriptions"/>
                @endif
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:w-2/6">
        <div class="flex w-full">
            <div class=" w-full rounded p-4 border bg-gray-100 ">
                <div class="flex flex-col justify-center w-full h-full gap-4">

                    <x-rating-stars class="flex-col justify-center"
                        :average-rating="$averageRating"
                        :rating-count="$ratingCount"
                        :model="$model"/>

                    @if($productsInLeaflets->isNotEmpty())
                        <span class="text-center font-bold text-1xl">od {{$productsInLeaflets[0]['promo_price']}}zł</span>
                        <a href="{{route('subdomain.leaflet',['subdomain'=> $productsInLeaflets[0]['shop_slug'], 'id' => $productsInLeaflets[0]['leaflet_id']])}}#{{$productsInLeaflets[0]['page_number']}}" class="flex self-center bg-orange-500 rounded-3xl px-4 py-2 text-white font-semibold text-sm">Przejdź do gazetki</a>
                    @else
                        <span class="text-center font-bold text-1xl">Brak ofert</span>
                    @endif

                </div>
            </div>
        </div>
        @if($productsInLeaflets->isNotEmpty())
            <div class="flex flex-col sm:flex-row my-5 gap-x-3">
                <div class="flex justify-between w-full mb-2">
                    <x-price-list :items="$productsInLeaflets"/>
                </div>
            </div>
        @endif

    </div>
</div>
