@props(['item', 'blog'])

<div class="col-span-6 md:col-span-3 lg:col-span-2 flex flex-col gap-y-2 border rounded border-gray-100">
    <div class="w-full">
        <a href="{{route('main.blogs.article', ['category' => $item->category->slug, 'article' => $item->slug])}}">
            <picture>
                <source srcset="{{ Storage::url($item->image.'.webp') }}" type="image/webp">
                <source srcset="{{ Storage::url($item->image.'jpg')}}" type="image/jpeg">
                <img
                    decoding="async"
                    src="{{ Storage::url($item->image.'jpg') }}"
                    alt="{{$item->title}}"
                    loading="lazy"
                    class="rounded-t object-cover object-top w-full max-h-48">
            </picture>
        </a>
    </div>
    <div class=" flex flex-col justify-center gap-y-2 p-2">
        <a href="{{route('main.blogs.category', ['category' => $item->category->slug])}}" class="flex text-sm text-gray-500 hover:text-gray-900">{{$item->category->name}}</a>
        <a class="flex flex-col gap-y-2" href="{{route('main.blogs.article', ['category' => $item->category->slug, 'article' => $item->slug])}}">
            <h3 class="flex text-base">{{$item->title}}</h3>
        </a>
        <x-blog-author size="small" :author="$item->user"/>
        <span class="flex text-xs text-gray-500">{{monthReplace($item->updated_at,'excerpt')}}</span>
    </div>

</div>
