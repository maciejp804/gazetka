@props(['item', 'product'])
<div class="flex flex-col md:flex-row mt-4 gap-x-3">
    <div class="flex w-full md:w-72 justify-center aspect-square">
        @if(empty($product->image))
            <img class="flex self-center" src="{{$product->category->logo ? asset($product->category->logo) : asset('assets/images/categories/default.webp')}}" alt="{{mb_ucfirst($product->name)}}" />
        @else
            <img class="flex self-center" src="{{$product->image ? asset($product->image) : asset('assets/images/categories/default.webp')}}" alt="{{mb_ucfirst($product->name)}}" />
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
