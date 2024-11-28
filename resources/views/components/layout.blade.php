<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <title>Gazetka Promocyjna</title>

    @vite([
            'resources/css/app.css',

          ])
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
        window.googletag = window.googletag || {cmd: []};
        googletag.cmd.push(function() {
            googletag.defineSlot('/7894359647/Mobile_300x600_1', [300, 600], 'div-gpt-ad-1728582925576-0').addService(googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.enableServices();
        });
    </script>


</head>
<body class="font-ubuntu" id="app">

<x-header :slug="$slug"/>
<x-section class="lg:hidden">
    <x-search :border="true" class="flex h-12" input-id="search-input-products-mobile"
              result-id="results-box-products-mobile"
              data-search-type="products-retailers">
        <x-loupe-button href="#"/>
    </x-search>
</x-section>
    <main class="flex flex-col lg:mx-5 mt-8">
        {{ $slot }}
    </main>
<x-footer/>
@vite([
    'resources/js/app.js',
    'resources/js/custom-swiper.js',
    'resources/js/leaflet-swiper.js',
    'resources/js/filter.js',
    'resources/js/rating.js'

])
@stack('scripts')
</body>
</html>
