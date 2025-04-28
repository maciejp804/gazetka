<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <title>@if($meta_title) {{ $meta_title }} @else Brak tytułu @endif </title>
    <meta name="Description" content="@if($meta_description) {{ $meta_description }} @else Brak tytułu @endif ">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#1967d2">

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-547N48N6');</script>
    <!-- End Google Tag Manager -->

    @stack('head')

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
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-547N48N6"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
