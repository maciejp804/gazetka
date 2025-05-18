@props([
    'slotName',
    'overrides' => [],
    'refreshInterval' => config("admanager.slots.$slotName.refresh_interval"),
])

@php
    $ad = config("admanager.slots.$slotName");
    $enabled = $ad['enabled'] ?? false;
    $divId = $ad['div_id'] ?? 'div-' . md5($slotName);
    $priority = $ad['priority'] ?? 'gam';
    $isDebug = config('admanager.debug');
    $targeting = array_merge($ad['targeting'] ?? [], $overrides);
@endphp

@if($ad && $enabled)
    <div {{ $attributes->merge(['id' => $divId]) }}></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mapping = @json($ad['mapping'] ?? []);
            const div = document.getElementById('{{ $divId }}');
            const vw = window.innerWidth;

            let matchedHeight = 0;

            for (let i = 0; i < mapping.length; i++) {
                const vp = mapping[i].viewport;
                if (vw >= vp[0]) {
                    const size = mapping[i].sizes[0];
                    if (Array.isArray(size)) {
                        matchedHeight = size[1];
                    }
                    break;
                }
            }

            if (div && matchedHeight > 0) {
                div.style.minHeight = matchedHeight + 'px';
            }
        });
    </script>

    @if($isDebug)
        <script>
            console.info('[AdManager] Slot: {{ $slotName }} (divId: {{ $divId }})');
            console.info('[AdManager] Priority: {{ $priority }}');
        </script>
    @endif

    @if($priority === 'adsense' && isset($ad['adsense_fallback']))
        <ins id="{{ $divId }}-adsense" class="adsbygoogle opacity-0"
             style="display:block"
             data-ad-client="{{ $ad['adsense_fallback']['client'] }}"
             data-ad-slot="{{ $ad['adsense_fallback']['slot'] }}"
             data-ad-format="{{ $ad['adsense_fallback']['format'] ?? 'auto' }}"
             data-full-width-responsive="true"></ins>

        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $ad['adsense_fallback']['client'] }}" crossorigin="anonymous"></script>

        <script>
            function fallbackToGAM(divId) {
                console.warn('[AdManager] ➞ Fallback do GAM dla:', divId);

                const adsenseIns = document.getElementById(divId + '-adsense');
                if (adsenseIns) adsenseIns.remove();

                const wrapper = document.getElementById(divId);
                if (wrapper) wrapper.innerHTML = '';

                googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    const mapping = googletag.sizeMapping()
                    @foreach($ad['mapping'] as $map)
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
                    const refreshEl = document.getElementById(divId);
                    if (refreshEl) {
                        let hasRefreshed = false;
                        const startRefreshing = () => {
                            if (!hasRefreshed) {
                                hasRefreshed = true;
                                setInterval(() => {
                                    googletag.pubads().refresh([slot]);
                                }, refreshMs);
                            }
                        };
                        const observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    startRefreshing();
                                    observer.unobserve(refreshEl);
                                }
                            });
                        }, { threshold: 0.5 });
                        observer.observe(refreshEl);
                    }
                    @endif
                });
            }

            function tryLoadAdsense() {
                const ins = document.getElementById('{{ $divId }}-adsense');
                if (!ins) return fallbackToGAM('{{ $divId }}');

                const mapping = @json($ad['mapping'] ?? []);
                const vw = window.innerWidth;
                let matchedSize = null;

                for (let i = 0; i < mapping.length; i++) {
                    const vp = mapping[i].viewport;
                    if (vw >= vp[0]) {
                        matchedSize = mapping[i].sizes[0];
                        break;
                    }
                }

                if (!matchedSize || matchedSize[0] === 0 || matchedSize[1] === 0) {
                    return fallbackToGAM('{{ $divId }}');
                }

                ins.style.width = matchedSize[0] + 'px';
                ins.style.height = matchedSize[1] + 'px';

                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) return;
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
        <script>
            googletag = window.googletag || {cmd: []};
            googletag.cmd.push(function () {
                const mappingData = @json($ad['mapping'] ?? []);
                const viewportWidth = window.innerWidth;
                let matchedSize = null;

                for (let i = 0; i < mappingData.length; i++) {
                    const vp = mappingData[i].viewport;
                    if (viewportWidth >= vp[0]) {
                        matchedSize = mappingData[i].sizes[0];
                        break;
                    }
                }

                if (Array.isArray(matchedSize) && (matchedSize[0] === 0 || matchedSize[1] === 0)) {
                    return;
                }

                const mapping = googletag.sizeMapping()
                @foreach($ad['mapping'] as $map)
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
                    const startRefreshing = () => {
                        if (!hasRefreshed) {
                            hasRefreshed = true;
                            setInterval(() => {
                                googletag.pubads().refresh([slot]);
                            }, refreshMs);
                        }
                    };
                    const observerRefresh = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                startRefreshing();
                                observerRefresh.unobserve(el);
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

