<div class="mx-auto max-w-7xl px-4 mb-2">
    <div class="flex gap-2 px-4">
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
