@props(['item', 'product'])
<div class="flex flex-col md:flex-row mt-4 gap-x-3">
    <div class="flex w-full md:w-72 justify-center aspect-square overflow-hidden">
        @if(empty($product->image))
            <picture>
                <source srcset="{{ $product->category->logo ? asset($product->category->logo) : asset('assets/images/categories/default.webp')}}" type="image/avif">
                <source srcset="{{ $product->category->logo ? asset($product->category->logo) : asset('assets/images/categories/default.webp') }}" type="image/webp">
                <img class="flex self-center w-full"
                     src="{{ $product->category->logo ?  asset($product->category->logo) : asset('assets/images/categories/default.webp')}}"
                     width="1920" height="1080"
                     alt="{{$product->name}}">
            </picture>
        @else
            <picture>
                <source srcset="{{ Storage::url($product->image.'.avif') }}" type="image/avif">
                <source srcset="{{ Storage::url($product->image.'.webp') }}" type="image/webp">
                <img class="flex self-center w-full"
                     src="{{ Storage::url($product->image.'.jpg') }}"
                     width="1920" height="1080"
                     alt="{{$product->name}}">
            </picture>
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
