@props(['item', 'blog'])
<div class="col-span-6 grid grid-cols-6 lg:gap-y-2">
    <div class="col-span-6 lg:col-span-3 flex rounded-t lg:rounded-l">
        <a href="{{route('main.blogs_article', ['category' => $blog->slug, 'article' => $item->slug])}}">
            <img src="{{$item->image}}" class="rounded-t lg:rounded-none lg:rounded-l object-cover">
        </a>
    </div>
    <div class="col-span-6 lg:col-span-3 p-5 flex bg-blue-550 text-white rounded-b lg:rounded-none lg:rounded-r">
        <div class=" flex flex-col justify-center gap-y-2">
            <a href="{{route('main.blogs.category', ['category' => $blog->slug])}}" class="flex text-sm text-gray-300 hover:text-gray-700">{{$blog->name}}</a>
            <span class="flex text-xs text-gray-400">{{monthReplace($item->updated_at,'excerpt')}}</span>
            <a class="flex flex-col gap-y-2" href="{{route('main.blogs_article', ['category' => $blog->slug, 'article' => $item->slug])}}">
                <h3 class="flex">{{$item->title}}</h3>
                <p class="hidden lg:flex text-sm text-gray-300">{{$item->excerpt}}</p>
            </a>
            <x-blog-author :author="$item->user"/>
        </div>
    </div>
</div>
