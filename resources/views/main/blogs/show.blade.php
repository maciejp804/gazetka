<x-layout>
     <x-slot:place>
        {{  $place }}
    </x-slot:place>
    <x-slot:page_title>
        {{  $page_title }}
    </x-slot:page_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>

    <div class="flex flex-col gap-y-4">

        {{-- Reklama pionowa po lewej stronie --}}
{{--        <x-ad-3-vertical site="justify-end"/>--}}
        <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>
        <x-div-1060 class="2lg:flex-row">
            <div class="flex flex-col gap-y-4 w-full 2lg:w-4/5">
                <x-header-blog>{{$blog->title}}</x-header-blog>
                <x-excerpt-blog :excerpt="$blog->excerpt"/>
                <x-section>
                    <x-blog-author  class="mb-3" :author="$blog->user"/>
                    <div class="flex justify-between">
                        <div class="swiper-slide px-2 lg:px-4 py-2 border bg-gray-200 hover:bg-gray-100 rounded !w-auto">
                            <a class="text-xs lg:text-sm"
                               href="{{route('main.blogs.category', ['category' => $blogCategory->slug])}}">
                                {{$blogCategory->name}} ({{$blogCategory->blogs_count}})
                            </a>
                        </div>
                        <div class="flex self-center text-xs">
                            @if($blog->created_at != $blog->updated_at)
                                <span>{{monthReplace($blog->created_at, 'excerpt')}}   | aktualizacja:  {{monthReplace($blog->updated_at, 'excerpt')}} </span>
                            @else
                                <span>utworzony: {{monthReplace($blog->created_at, 'excerpt')}} </span>
                            @endif

                        </div>
                    </div>
                </x-section>
                <x-section>
                    <div class="flex justify-center">
                        <picture>
                            <source srcset="{{ Storage::url($blog->image.'.webp') }}" type="image/webp">
                            <source srcset="{{ Storage::url($blog->image)}}" type="image/jpeg">
                            <img src="{{ Storage::url($blog->image) }}"
                                 alt="Opis obrazu"
                                 loading="lazy"
                                 class="rounded  object-cover">
                        </picture>
                    </div>
                </x-section>
                <x-section>
                    <x-body-blog :body="$blog->body"/>
                </x-section>
            </div>
            <div class="hidden 2lg:flex flex-col w-1/5 gap-y-4">
                <span class="font-semibold text-gray-700 text-sm">Poleceane w kategorii</span>
                @foreach($blogs as $article)
                    <div>
                        <a href="{{route('main.blogs.article',['category' => $article->category->slug, 'article' => $article->slug])}}" class="flex gap-2">
                            <picture class="flex aspect-square w-32 ">
                                <source srcset="{{ Storage::url($article->image.'-100x100.webp') }}" type="image/webp">
                                <source srcset="{{ Storage::url($article->image.'-100x100.jpg')}}" type="image/jpeg">
                                <img src="{{ Storage::url($article->image.'-100x100.jpg') }}"
                                     alt="{{$article->title}}"
                                     loading="lazy"
                                     class="rounded  object-cover">
                            </picture>
                            <div class="flex flex-col">
                                <span class="text-xs">{{$article->title}}</span>
                                <span class="text-1xs">{{$article->updateed_at}}</span>
                            </div>
                        </a>
                    </div>
                @endforeach


            </div>

        </x-div-1060>

        {{-- Reklama pionowa po prawej stronie --}}
{{--        <x-ad-3-vertical site="justify-start"/>--}}

    </div>
</x-layout>

