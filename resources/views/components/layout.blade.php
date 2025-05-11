<!doctype html>
<html lang="pl">
<head>
    <x-tag-manager-head/>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <meta name="google-site-verification" content="FQIP9C2zoaXYvzpKGwbWQOmnpEX7UDEyNRL7FGTh4KQ" />
    <title>@if($meta_title) {{ $meta_title }} @else Brak tytułu @endif </title>
    <meta name="Description" content="@if($meta_description) {{ $meta_description }} @else Brak tytułu @endif ">

    {{-- Preconnect --}}
    <link rel="preconnect" href="https://securepubads.g.doubleclick.net">
    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('icons/android-chrome-512x512.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('icons/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('icons/site.webmanifest') }}">
    <meta name="theme-color" content="#1967d2">

    @stack('preload')

    <script>
        const mainDomain = "{{ config('app.main_domain') }}";
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- GPT loader -->
{{--    <x-gpt-loader/>--}}


    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
        window.googletag = window.googletag || { cmd: [] };
    </script>



</head>
<body class="font-ubuntu" id="app">
<x-tag-manager-body/>
<x-flash-massage/>
<x-header :place="$place"/>
<x-section class="filter-box lg:hidden">
    <x-search :border="true" class="flex h-12" input-id="search-input-products-mobile"
              result-id="results-box-products-mobile"
              data-search-type="products-retailers">
        <x-loupe-button href="#"/>
    </x-search>
</x-section>
    <main class="flex flex-col lg:mx-2">
        {{ $slot }}
    </main>
<x-footer/>
@isset($scripts)
    {{ $scripts }}
@endisset
</body>
</html>
