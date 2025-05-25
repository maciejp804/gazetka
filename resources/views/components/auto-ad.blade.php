@props([
    'client' => 'ca-pub-0504184268109752', // ← podmień na swój realny AdSense client ID
])

@if(app()->environment('production'))
    {{-- Ładowanie Auto Ads tylko na produkcji --}}
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $client }}"
            crossorigin="anonymous"></script>

{{--    <script>--}}
{{--        (adsbygoogle = window.adsbygoogle || []).push({--}}
{{--            google_ad_client: "{{ $client }}",--}}
{{--            enable_page_level_ads: true--}}
{{--        });--}}
{{--    </script>--}}
@endif

