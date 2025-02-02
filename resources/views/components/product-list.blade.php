@props(['products', 'subdomain'])
<div class="w-full">
    <div class="row product-box">
        <div>
            <div class="flex flex-wrap  gap-2">
                @foreach($products as $product)
                    <a href="{{route('subdomain.products.show',['subdomain' => $subdomain, 'slug' => $product->slug])}}" class="p-2 bg-gray-100 border border-gray-200 rounded hover:text-blue-550 ">
                        <span class="font-semibold text-sm">{{$product->name}}</span>
                    </a>
                @endforeach

            </div>

        </div>
    </div>
</div>
