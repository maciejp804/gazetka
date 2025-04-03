@props(['item', 'blog'])
{{--@dd($item)--}}
<div class="col-span-6 grid grid-cols-6 lg:gap-y-2">
    <a href="{{route('main.blogs.article', ['category' => $item->category->slug, 'article' => $item->slug])}}"
       class="col-span-6 lg:col-span-3">
        <div class="w-full h-80 rounded-t lg:rounded-none lg:rounded-l overflow-hidden">

                <picture>
                    <source srcset="{{ Storage::url($item->image.'.webp') }}" type="image/webp">
                    <source srcset="{{ Storage::url($item->image.'jpg')}}" type="image/jpeg">
                    <img
                        fetchpriority="high"
                        decoding="async"
                        src="{{ Storage::url($item->image.'jpg') }}"
                        alt="{{$item->title}}"
                        class="object-cover h-full w-full">
                </picture>

        </div>
    </a>
    <div class="col-span-6 lg:col-span-3 p-5 flex bg-blue-550 text-white rounded-b lg:rounded-none lg:rounded-r">
        <div class=" flex flex-col justify-between gap-y-2">
            <a href="{{route('main.blogs.category', ['category' => $item->category->slug])}}" class="flex text-sm text-gray-300 hover:text-gray-700">{{$item->category->name}}</a>
            <span class="flex text-xs text-gray-400">{{monthReplace($item->updated_at,'excerpt')}}</span>
            <a class="flex flex-col gap-y-2" href="{{route('main.blogs.article', ['category' => $item->category->slug, 'article' => $item->slug])}}">
                <h3 class="flex">{{$item->title}}</h3>
                <p class="hidden lg:flex lg:flex-col text-sm text-gray-300">{!! $item->excerpt !!}</p>
            </a>
            <x-blog-author :author="$item->user"/>
        </div>
    </div>
</div>
