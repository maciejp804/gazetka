@props(['item', 'product'])
<div class="flex flex-col md:flex-row mt-4 gap-x-3">
    <div class="flex w-full md:w-72 justify-center aspect-square">
        @if(empty($product->image))
            <img class="flex self-center" src="{{asset($product->category->logo)}}" alt="{{mb_ucfirst($product->name)}}" />
        @else
            <img class="flex self-center" src="{{asset($product->image)}}" alt="{{mb_ucfirst($product->name)}}" />
        @endif
    </div>
    <div class="flex w-full">
         <span class="text-sm font-normal p-2">
            @if(!empty($item->excerpt))
                 {{$item->excerpt}}
            @endif
         </span>
    </div>
</div>
