@props(['item', 'blog'])
<div class="col-span-6 md:col-span-3 lg:col-span-2 flex flex-col gap-y-2 border rounded border-gray-100">
    <div class="flex">
        <a href="{{route('main.blogs_article', ['category' => $blog->slug, 'article' => $item->slug])}}">
            <img class="rounded-t object-cover" src="{{$item->image}}">
        </a>
    </div>
    <div class=" flex flex-col justify-center gap-y-2 p-2">
        <a href="{{route('main.blogs.category', ['category' => $blog->slug])}}" class="flex text-sm text-gray-500 hover:text-gray-900">{{$blog->name}}</a>
        <a class="flex flex-col gap-y-2" href="#">
            <h3 class="flex text-base">{{$item->title}}</h3>
        </a>
        <x-blog-author size="small" :author="$item->user"/>
        <span class="flex text-xs text-gray-500">{{monthReplace($item->updated_at,'excerpt')}}</span>
    </div>

</div>
