<x-layout>
     <x-slot:place>
        {{  $place }}
    </x-slot:place>
    <x-slot:meta_title>
        {{  $meta_title }}
    </x-slot:meta_title>
    <x-slot:meta_description>
        {{  $meta_description }}
    </x-slot:meta_description>

    <div class="flex flex-col gap-y-4">
        {{-- Reklama pionowa po lewej stronie --}}
{{--        <x-ad-3-vertical site="justify-end"/>--}}
        <x-breadcrumbs class="mt-3" :breadcrumbs="$breadcrumbs"/>
        <div class="flex flex-col 2lg:flex-row w-full 1xl:w-312 mx-auto ">
            <div class="flex flex-col gap-y-4 w-full 2lg:w-4/5 px-2 xs:px-4">
                <x-header-blog>{{$h1_title}}</x-header-blog>
                <x-excerpt-blog :excerpt="$excerpt"/>
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
            <script type="application/ld+json">
                {!! json_encode([
                    '@context' => 'https://schema.org/',
                    '@type' => 'NewsArticle',
                    'headline' => $h1_title,
                    'image' => [
                        '@type' => 'ImageObject',
                        'url' => Storage::url($blog->image . '.webp'),
                        'height' => $height,
                        'width' => $width,
                    ],
                    'mainEntityOfPage' => [
                        '@type' => 'WebPage',
                        '@id' => route('main.blogs.article', ['category' => $blogCategory->slug, 'article' => $blog->slug]),
                    ],
                    'keywords' => '',
                    'description' => $excerpt,
                    'articleBody' => strip_tags($blog->body),
                    'datePublished' => $blog->created_at->format('c'),
                    'dateModified' => $blog->updated_at->format('c'),
                    'author' => [
                        '@type' => 'Person',
                        'name' => $blog->user->name,
                        'image' => '',
                        'url' => '',
                        'description' => '',
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'GazetkaPromocyjna',
                        'logo' => [
                            '@type' => 'ImageObject',
                            'url' => 'https://hoian.pl/assets/image/Logo.png',
                            'width' => 230,
                            'height' => 131,
                        ],
                    ],
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
            </script>

            <div class="hidden 2lg:flex flex-col w-1/5 gap-y-4">
                <span class="font-semibold text-gray-700 text-base">Poleceane w kategorii</span>
                @foreach($blogs as $article)
                    <div>
                        <a href="{{route('main.blogs.article',['category' => $article->category->slug, 'article' => $article->slug])}}" class="flex gap-2">
                            <picture class="w-2/5 aspect-square overflow-hidden">
                                <source srcset="{{ Storage::url($article->image.'-100x100.webp') }}" type="image/webp">
                                <source srcset="{{ Storage::url($article->image.'-100x100.jpg')}}" type="image/jpeg">
                                <img src="{{ Storage::url($article->image.'-100x100.jpg') }}"
                                     alt="{{$article->title}}"
                                     loading="lazy"
                                     class="rounded w-24 h-24 object-cover">
                            </picture>
                            <div class="flex flex-col w-3/5">
                                <span class="text-sm">{{$article->title}}</span>
                                <span class="text-1xs">{{monthReplace($article->updated_at, 'excerpt')}}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

{{--         Reklama pionowa po prawej stronie--}}
{{--        <x-ad-3-vertical site="justify-start"/>--}}

    </div>
</x-layout>

