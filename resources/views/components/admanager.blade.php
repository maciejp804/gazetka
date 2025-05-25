@props([
    'slotName',
    'overrides' => [],
    'refreshInterval' => config("admanager.slots.$slotName.refresh_interval"),
    'abTestGroup' => null, // 'a' or 'b'
])

@php
    $ad = config("admanager.slots.$slotName");
    $enabled = $ad['enabled'] ?? false;
    $divId = $ad['div_id'] ?? 'div-' . md5($slotName);
    $basePriority = $ad['priority'] ?? 'gam';
    $priority = $abTestGroup === 'b' ? 'adsense' : $basePriority;
    $isDebug = config('admanager.debug');
    $targeting = array_merge($ad['targeting'] ?? [], $overrides);

    $mappingFiltered = collect($ad['mapping'] ?? [])->filter(function ($m) {
        $s = $m['sizes'][0] ?? [0, 0];
        return $s[0] > 0 && $s[1] > 0;
    })->values()->all();
@endphp


@if($ad && $enabled && count($mappingFiltered) > 0)
    @if($isDebug)
        <script>
            console.info('[AdManager] Slot: {{ $slotName }} (divId: {{ $divId }})');
            console.info('[AdManager] Priority: {{ $priority }}');
        </script>
    @endif

    @if($priority === 'adsense' && isset($ad['adsense_fallback']))
        @switch($slotName)
            @case('homepage_middle_1')
                <div id="ads-1-container-2">
                    <ins id="adsense-ad-2" class="adsbygoogle"
                         style="display:inline-block;width:750px;height:200px"
                         data-ad-client="ca-pub-0504184268109752"
                         data-ad-slot="8461649229"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                <script>
                    googletag.cmd.push(function () {
                        googletag.pubads().enableSingleRequest();
                        googletag.enableServices();
                    });

                    window.addEventListener('load', function () {
                        setTimeout(function () {
                            const ad = document.getElementById('adsense-ad-2');
                            if (ad && ad.getAttribute('data-ad-status') === 'unfilled') {
                                console.log('AdSense-2 unfilled – fallback to GAM');

                                ad.style.display = 'none';

                                const fallback = document.createElement('div');
                                fallback.id = 'gam-fallback-2';
                                fallback.style.width = '750px';
                                fallback.style.height = '300px';
                                document.querySelector('#ads-1-container-2').appendChild(fallback);

                                googletag.cmd.push(function () {
                                    googletag.defineSlot('/7894359647/baner_750x250', [[750, 300], [750, 250], [750, 200]], 'gam-fallback-2')
                                        .addService(googletag.pubads());
                                    googletag.display('gam-fallback-2');
                                    console.log('Ad loaded');
                                });
                            }
                        }, 1500);
                    });
                </script>

            @break
            @case('homepage_header')
                <div id="ads-1-container-1">
                <ins id="adsense-ad-1" class="adsbygoogle"
                     style="display:inline-block;width:750px;height:300px"
                     data-ad-client="ca-pub-0504184268109752"
                     data-ad-slot="9092204614"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                </div>

                <script>
                    googletag.cmd.push(function () {
                        googletag.pubads().enableSingleRequest();
                        googletag.enableServices();
                    });

                    window.addEventListener('load', function () {
                        setTimeout(function () {
                            const ad = document.getElementById('adsense-ad-1');
                            if (ad && ad.getAttribute('data-ad-status') === 'unfilled') {
                                console.log('AdSense-2 unfilled – fallback to GAM');

                                ad.style.display = 'none';

                                const fallback = document.createElement('div');
                                fallback.id = 'gam-fallback-2';
                                fallback.style.width = '750px';
                                fallback.style.height = '300px';
                                document.querySelector('#ads-1-container-1').appendChild(fallback);

                                googletag.cmd.push(function () {
                                    googletag.defineSlot('/7894359647/baner_750x250', [[750, 300], [750, 250], [750, 200]], 'gam-fallback-2')
                                        .addService(googletag.pubads());
                                    googletag.display('gam-fallback-2');
                                    console.log('Ad loaded');
                                });
                            }
                        }, 1500);
                    });
                </script>


                @break
        @endswitch

{{--        @if($slotName != 'homepage_middle_1')--}}
{{--            <ins id="{{ $divId }}" class="adsbygoogle z-0"--}}
{{--                 style="{{ $ad['adsense_fallback']['style'] }}"--}}
{{--                 data-ad-client="{{ $ad['adsense_fallback']['client'] }}"--}}
{{--                 data-ad-slot="{{ $ad['adsense_fallback']['slot'] }}"--}}
{{--                 @if($ad['adsense_fallback']['format'] != null)--}}
{{--                     data-ad-format="{{ $ad['adsense_fallback']['format'] ?? 'auto' }}"--}}
{{--                 @endif--}}
{{--                 @if(!$ad['adsense_fallback']['responsive'])--}}
{{--                     data-full-width-responsive="true"--}}
{{--                @endif--}}
{{--            ></ins>--}}
{{--            <script>--}}
{{--                (adsbygoogle = window.adsbygoogle || []).push({});--}}
{{--            </script>--}}
{{--        @else--}}
{{--                <ins class="adsbygoogle"--}}
{{--                     style="display:inline-block;width:750px;height:200px"--}}
{{--                     data-ad-client="ca-pub-0504184268109752"--}}
{{--                     data-ad-slot="8461649229"></ins>--}}
{{--                <script>--}}
{{--                    (adsbygoogle = window.adsbygoogle || []).push({});--}}
{{--                </script>--}}
{{--            @endif--}}

        {{--@if($enabled)--}}
{{--    <ins id="{{ $divId }}" class="adsbygoogle"--}}
{{--         style="{{ $ad['adsense_fallback']['style'] }}"--}}
{{--         data-ad-client="{{ $ad['adsense_fallback']['client'] }}"--}}
{{--         data-ad-slot="{{ $ad['adsense_fallback']['slot'] }}"--}}
{{--         @if($ad['adsense_fallback']['format'] != null)--}}
{{--             data-ad-format="{{ $ad['adsense_fallback']['format'] ?? 'auto' }}"--}}
{{--         @endif--}}
{{--         @if(!$ad['adsense_fallback']['responsive'])--}}
{{--             data-full-width-responsive="true"--}}
{{--        @endif--}}
{{--    ></ins>--}}

{{--    @if (! defined('__ADSENSE_SCRIPT_INCLUDED__'))--}}
{{--        @php(define('__ADSENSE_SCRIPT_INCLUDED__', true))--}}
{{--        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $client }}" crossorigin="anonymous"></script>--}}
{{--    @endif--}}

{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const el = document.getElementById("{{ $divId }}");--}}
{{--            if (!el) return;--}}

{{--            let hasLoaded = false;--}}

{{--            const observer = new IntersectionObserver((entries, obs) => {--}}
{{--                entries.forEach(entry => {--}}
{{--                    if (!entry.isIntersecting || hasLoaded) return;--}}
{{--                    hasLoaded = true;--}}
{{--                    obs.unobserve(el);--}}

{{--                    try {--}}
{{--                        if (!window.__adsenseManualInit) {--}}
{{--                            window.__adsenseManualInit = true;--}}
{{--                            (adsbygoogle = window.adsbygoogle || []).push({});--}}
{{--                        }--}}
{{--                    } catch (e) {--}}
{{--                        console.warn('AdSense error:', e);--}}
{{--                    }--}}
{{--                });--}}
{{--            }, { threshold: 0.5 });--}}

{{--            observer.observe(el);--}}
{{--        });--}}
{{--    </script>--}}
{{--@endif--}}



{{--@if($ad && $enabled && count($mappingFiltered) > 0)--}}
{{--    @if($isDebug)--}}
{{--        <script>--}}
{{--            console.info('[AdManager] Slot: {{ $slotName }} (divId: {{ $divId }})');--}}
{{--            console.info('[AdManager] Priority: {{ $priority }}');--}}
{{--        </script>--}}
{{--    @endif--}}

{{--    @if($priority === 'adsense' && isset($ad['adsense_fallback']))--}}
{{--        @if($divId == 'div-gpt-ad-1747054874411-0')--}}
{{--            <ins class="adsbygoogle"--}}
{{--                 style="display:inline-block;width:750px;height:300px"--}}
{{--                 data-ad-client="ca-pub-0504184268109752"--}}
{{--                 data-ad-slot="9092204614"></ins>--}}
{{--            <script>--}}
{{--                (adsbygoogle = window.adsbygoogle || []).push({});--}}
{{--            </script>--}}

{{--        @endif--}}

{{--        <ins id="{{ $divId }}-adsense" class="adsbygoogle opacity-0"--}}
{{--             style="{{ $ad['adsense_fallback']['style'] }}"--}}
{{--             data-ad-client="{{ $ad['adsense_fallback']['client'] }}"--}}
{{--             data-ad-slot="{{ $ad['adsense_fallback']['slot'] }}"--}}
{{--             @if($ad['adsense_fallback']['format'] != null)--}}
{{--                 data-ad-format="{{ $ad['adsense_fallback']['format'] ?? 'auto' }}"--}}
{{--             @endif--}}
{{--             @if(!$ad['adsense_fallback']['responsive'])--}}
{{--                 data-full-width-responsive="true"--}}
{{--             @endif--}}
{{--        ></ins>--}}

{{--        @if (! defined('__ADSENSE_SCRIPT_INCLUDED__'))--}}
{{--            @php(define('__ADSENSE_SCRIPT_INCLUDED__', true))--}}
{{--            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $ad['adsense_fallback']['client'] }}" crossorigin="anonymous"></script>--}}
{{--        @endif--}}

{{--        <script>--}}
{{--            function fallbackToGAM(divId) {--}}
{{--                const adsenseIns = document.getElementById(divId + '-adsense');--}}
{{--                if (adsenseIns) adsenseIns.remove();--}}

{{--                const wrapper = document.getElementById(divId);--}}
{{--                if (wrapper) wrapper.innerHTML = '';--}}

{{--                googletag = window.googletag || {cmd: []};--}}
{{--                googletag.cmd.push(function () {--}}
{{--                    if (!{{ count($mappingFiltered) }}) {--}}
{{--                        console.warn('[AdManager] 🛑 Pominięto slot z pustym mappingFiltered: {{ $slotName }}');--}}
{{--                        return;--}}
{{--                    }--}}

{{--                    const mapping = googletag.sizeMapping()--}}
{{--                    @foreach($mappingFiltered as $map)--}}
{{--                        .addSize([{{ $map['viewport'][0] }}, {{ $map['viewport'][1] }}], {!! json_encode($map['sizes']) !!})--}}
{{--                        @endforeach--}}
{{--                        .build();--}}

{{--                    const slot = googletag.defineSlot('{{ $ad['slot'] }}', [], divId)--}}
{{--                        .defineSizeMapping(mapping)--}}
{{--                        .addService(googletag.pubads());--}}

{{--                    @foreach($targeting as $key => $value)--}}
{{--                    slot.setTargeting('{{ $key }}', '{{ $value }}');--}}
{{--                    @endforeach--}}

{{--                    googletag.enableServices();--}}
{{--                    googletag.display(divId);--}}

{{--                    @if($refreshInterval)--}}
{{--                    const refreshMs = {{ $refreshInterval * 1000 }};--}}
{{--                    const el = document.getElementById(divId);--}}
{{--                    if (el) {--}}
{{--                        let hasRefreshed = false;--}}
{{--                        const observer = new IntersectionObserver((entries) => {--}}
{{--                            entries.forEach(entry => {--}}
{{--                                if (entry.isIntersecting && !hasRefreshed) {--}}
{{--                                    hasRefreshed = true;--}}
{{--                                    setInterval(() => {--}}
{{--                                        googletag.pubads().refresh([slot]);--}}
{{--                                    }, refreshMs);--}}
{{--                                }--}}
{{--                            });--}}
{{--                        }, { threshold: 0.5 });--}}
{{--                        observer.observe(el);--}}
{{--                    }--}}
{{--                    @endif--}}
{{--                });--}}
{{--            }--}}

{{--            function tryLoadAdsense() {--}}
{{--                const ins = document.getElementById('{{ $divId }}-adsense');--}}
{{--                if (!ins) return fallbackToGAM('{{ $divId }}');--}}

{{--                const mapping = @json($mappingFiltered);--}}
{{--                const vw = window.innerWidth;--}}
{{--                let matchedSize = null;--}}

{{--                for (let i = 0; i < mapping.length; i++) {--}}
{{--                    if (vw >= mapping[i].viewport[0]) {--}}
{{--                        matchedSize = mapping[i].sizes[0];--}}
{{--                        break;--}}
{{--                    }--}}
{{--                }--}}

{{--                if (!matchedSize || matchedSize[0] === 0 || matchedSize[1] === 0) {--}}
{{--                    const div = document.getElementById('{{ $divId }}');--}}
{{--                    if (div) div.style.display = 'none';--}}
{{--                    return;--}}
{{--                }--}}

{{--                ins.style.width = matchedSize[0] + 'px';--}}
{{--                ins.style.height = matchedSize[1] + 'px';--}}

{{--                let hasLoaded = false;--}}

{{--                const observer = new IntersectionObserver((entries, obs) => {--}}
{{--                    entries.forEach(entry => {--}}
{{--                        if (!entry.isIntersecting || hasLoaded) return;--}}
{{--                        hasLoaded = true;--}}
{{--                        obs.unobserve(ins);--}}

{{--                        let fallbackTimer = setTimeout(() => fallbackToGAM('{{ $divId }}'), 1200);--}}

{{--                        try {--}}
{{--                            if (!window.__adsenseManualInit) {--}}
{{--                                window.__adsenseManualInit = true;--}}
{{--                                const result = (adsbygoogle = window.adsbygoogle || []).push({});--}}
{{--                            }--}}

{{--                            ins.classList.remove('opacity-0');--}}

{{--                            if (result && typeof result.then === 'function') {--}}
{{--                                result.catch(() => {--}}
{{--                                    clearTimeout(fallbackTimer);--}}
{{--                                    fallbackToGAM('{{ $divId }}');--}}
{{--                                });--}}
{{--                            }--}}
{{--                        } catch (e) {--}}
{{--                            clearTimeout(fallbackTimer);--}}
{{--                            fallbackToGAM('{{ $divId }}');--}}
{{--                        }--}}
{{--                    });--}}
{{--                }, { threshold: 0.5 });--}}

{{--                observer.observe(ins);--}}
{{--            }--}}

{{--            document.addEventListener('DOMContentLoaded', tryLoadAdsense);--}}
{{--        </script>--}}

    @elseif($priority === 'gam')
        <div {{ $attributes->merge(['id' => $divId]) }}></div>

        <script>
            googletag = window.googletag || {cmd: []};
            googletag.cmd.push(function () {
                const vw = window.innerWidth;
                const raw = @json($mappingFiltered);

                let matchedSize = null;
                for (let i = 0; i < raw.length; i++) {
                    if (vw >= raw[i].viewport[0]) {
                        matchedSize = raw[i].sizes[0];
                        break;
                    }
                }

                if (!matchedSize || matchedSize[0] === 0 || matchedSize[1] === 0) {
                    const el = document.getElementById('{{ $divId }}');
                    if (el) el.style.display = 'none';
                    return;
                }

                const mapping = googletag.sizeMapping()
                @foreach($mappingFiltered as $map)
                    .addSize([{{ $map['viewport'][0] }}, {{ $map['viewport'][1] }}], {!! json_encode($map['sizes']) !!})
                    @endforeach
                    .build();

                const slot = googletag.defineSlot('{{ $ad['slot'] }}', [], '{{ $divId }}')
                    .defineSizeMapping(mapping)
                    .addService(googletag.pubads());

                @foreach($targeting as $key => $value)
                slot.setTargeting('{{ $key }}', '{{ $value }}');
                @endforeach

                googletag.enableServices();

                const el = document.getElementById('{{ $divId }}');
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            googletag.display('{{ $divId }}');
                            obs.unobserve(el);
                        }
                    });
                }, { threshold: 0.5 });

                if (el) observer.observe(el);

                @if($refreshInterval)
                const refreshMs = {{ $refreshInterval * 1000 }};
                if (el) {
                    let hasRefreshed = false;
                    const observerRefresh = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting && !hasRefreshed) {
                                hasRefreshed = true;
                                setInterval(() => {
                                    googletag.pubads().refresh([slot]);
                                }, refreshMs);
                            }
                        });
                    }, { threshold: 0.5 });
                    observerRefresh.observe(el);
                }
                @endif
            });
        </script>
    @endif
@endif
