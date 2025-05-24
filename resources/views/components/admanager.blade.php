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
        <ins id="{{ $divId }}-adsense" class="adsbygoogle opacity-0" style="display:block"
             data-ad-client="{{ $ad['adsense_fallback']['client'] }}"
             data-ad-slot="{{ $ad['adsense_fallback']['slot'] }}"
             data-ad-format="{{ $ad['adsense_fallback']['format'] ?? 'auto' }}"
             data-full-width-responsive="true"></ins>

        @if (! defined('__ADSENSE_SCRIPT_INCLUDED__'))
            @php(define('__ADSENSE_SCRIPT_INCLUDED__', true))
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $ad['adsense_fallback']['client'] }}" crossorigin="anonymous"></script>
        @endif

        <script>
            function fallbackToGAM(divId) {
                const adsenseIns = document.getElementById(divId + '-adsense');
                if (adsenseIns) adsenseIns.remove();

                const wrapper = document.getElementById(divId);
                if (wrapper) wrapper.innerHTML = '';

                googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    if (!{{ count($mappingFiltered) }}) {
                        console.warn('[AdManager] 🛑 Pominięto slot z pustym mappingFiltered: {{ $slotName }}');
                        return;
                    }

                    const mapping = googletag.sizeMapping()
                    @foreach($mappingFiltered as $map)
                        .addSize([{{ $map['viewport'][0] }}, {{ $map['viewport'][1] }}], {!! json_encode($map['sizes']) !!})
                        @endforeach
                        .build();

                    const slot = googletag.defineSlot('{{ $ad['slot'] }}', [], divId)
                        .defineSizeMapping(mapping)
                        .addService(googletag.pubads());

                    @foreach($targeting as $key => $value)
                    slot.setTargeting('{{ $key }}', '{{ $value }}');
                    @endforeach

                    googletag.enableServices();
                    googletag.display(divId);

                    @if($refreshInterval)
                    const refreshMs = {{ $refreshInterval * 1000 }};
                    const el = document.getElementById(divId);
                    if (el) {
                        let hasRefreshed = false;
                        const observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting && !hasRefreshed) {
                                    hasRefreshed = true;
                                    setInterval(() => {
                                        googletag.pubads().refresh([slot]);
                                    }, refreshMs);
                                }
                            });
                        }, { threshold: 0.5 });
                        observer.observe(el);
                    }
                    @endif
                });
            }

            function tryLoadAdsense() {
                const ins = document.getElementById('{{ $divId }}-adsense');
                if (!ins) return fallbackToGAM('{{ $divId }}');

                const mapping = @json($mappingFiltered);
                const vw = window.innerWidth;
                let matchedSize = null;

                for (let i = 0; i < mapping.length; i++) {
                    if (vw >= mapping[i].viewport[0]) {
                        matchedSize = mapping[i].sizes[0];
                        break;
                    }
                }

                if (!matchedSize || matchedSize[0] === 0 || matchedSize[1] === 0) {
                    const div = document.getElementById('{{ $divId }}');
                    if (div) div.style.display = 'none';
                    return;
                }

                ins.style.width = matchedSize[0] + 'px';
                ins.style.height = matchedSize[1] + 'px';

                let hasLoaded = false;

                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting || hasLoaded) return;
                        hasLoaded = true;
                        obs.unobserve(ins);

                        let fallbackTimer = setTimeout(() => fallbackToGAM('{{ $divId }}'), 1200);

                        try {
                            const result = (adsbygoogle = window.adsbygoogle || []).push({});
                            ins.classList.remove('opacity-0');

                            if (result && typeof result.then === 'function') {
                                result.catch(() => {
                                    clearTimeout(fallbackTimer);
                                    fallbackToGAM('{{ $divId }}');
                                });
                            }
                        } catch (e) {
                            clearTimeout(fallbackTimer);
                            fallbackToGAM('{{ $divId }}');
                        }
                    });
                }, { threshold: 0.5 });

                observer.observe(ins);
            }

            document.addEventListener('DOMContentLoaded', tryLoadAdsense);
        </script>

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
