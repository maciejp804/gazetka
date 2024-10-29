@props(['breadcrumbs' =>[]])

<nav aria-label="breadcrumb" {{$attributes->merge(['class' => 'flex flex-col w-full 1xl:w-265 m-auto'])}}>
    <div class="max-w-5xl ms-2 xs:mx-4 text-xs sm:text-base">
        <div class="flex gap-2 justify-start">
            @foreach ($breadcrumbs as $index => $breadcrumb)
                @if ($loop->last)
                    <span class="text-sm text-gray-400 font-medium">{{$breadcrumb['label']}}</span>
                @else
                    <a href="{{$breadcrumb['url']}}" class="text-sm text-gray-400 hover:text-blue-550">{{$breadcrumb['label']}}</a>
                    <div class="bg-blue-550 flex h-1 rounded-full self-center w-1"></div>
                @endif
            @endforeach
        </div>
    </div>
</nav>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
    @foreach ($breadcrumbs as $index => $breadcrumb)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
                "name": "{{ $breadcrumb['label'] }}",
                "item": "{{ $breadcrumb['url'] }}"
            } @if (!$loop->last), @endif
    @endforeach
    ]
}
</script>
