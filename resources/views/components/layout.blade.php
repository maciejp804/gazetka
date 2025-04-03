<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <title>@if($page_title) {{ $page_title }} @else Brak tytułu @endif </title>
    <meta name="Description" content="@if($meta_description) {{ $meta_description }} @else Brak tytułu @endif ">

    <script>
        const mainDomain = " {{ config('app.main_domain') }}";
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- GPT loader -->
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
        window.googletag = window.googletag || {cmd: []};
    </script>



</head>
<body class="font-ubuntu" id="app">
<x-flash-massage/>
<x-header :place="$place"/>
<x-section class="filter-box lg:hidden">
    <x-search :border="true" class="flex h-12" input-id="search-input-products-mobile"
              result-id="results-box-products-mobile"
              data-search-type="products-retailers">
        <x-loupe-button href="#"/>
    </x-search>
</x-section>
    <main class="flex flex-col lg:mx-5">
        {{ $slot }}
    </main>
<x-footer/>
@isset($scripts)
    {{ $scripts }}
@endisset
</body>
</html>
