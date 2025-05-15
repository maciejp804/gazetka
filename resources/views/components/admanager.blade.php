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
    $defaultSize = $ad['default_size'] ?? [300, 250];
    $isDebug = config('admanager.debug');
    $targeting = array_merge($ad['targeting'] ?? [], $overrides);
@endphp

@if($ad && $enabled)
    <div {{ $attributes->merge(['id' => $divId]) }} style="min-height: {{ $defaultSize[1] ?? 250 }}px;"></div>

    @if($isDebug)
        <script>
            console.info('[AdManager] Slot: {{ $slotName }} (divId: {{ $divId }})');
            console.info('[AdManager] Priority: {{ $priority }}');
        </script>
    @endif

    @if($priority === 'adsense' && isset($ad['adsense_fallback']))
        <ins id="{{ $divId }}-adsense" class="adsbygoogle invisible opacity-0"
             style="display:block"
             data-ad-client="{{ $ad['adsense_fallback']['client'] }}"
             data-ad-slot="{{ $ad['adsense_fallback']['slot'] }}"
             data-ad-format="{{ $ad['adsense_fallback']['format'] ?? 'auto' }}"
             data-full-width-responsive="true"></ins>

        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $ad['adsense_fallback']['client'] }}" crossorigin="anonymous"></script>

        <script>
                function fallbackToGAM(divId) {
                console.warn('[AdManager] ➡️ Fallback do GAM dla:', divId);

                // Ukryj lub usuń <ins> AdSense
                const adsenseIns = document.getElementById(divId + '-adsense');
                if (adsenseIns) {
                adsenseIns.remove();
            }

                // Wyczyszczenie kontenera
                let wrapper = document.getElementById(divId);
                if (!wrapper) {
                wrapper = document.createElement('div');
                wrapper.id = divId;
                wrapper.style.minHeight = '{{ $defaultSize[1] ?? 250 }}px';
                document.body.appendChild(wrapper);
            } else {
                wrapper.innerHTML = '';
            }

                googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {

                // Buduj sizeMapping z configu
                const mapping = googletag.sizeMapping()
                @foreach($ad['mapping'] as $map)
                .addSize([{{ $map['viewport'][0] }}, {{ $map['viewport'][1] }}], {!! json_encode($map['sizes']) !!})
                @endforeach
                .build();

                // Tworzymy slot dynamiczny, ale z mappingiem
                const slot = googletag.defineSlot('{{ $ad['slot'] }}', [], divId)
                .defineSizeMapping(mapping)
                .addService(googletag.pubads());

                // Dodaj targeting z configu i override
                @foreach($targeting as $key => $value)
                slot.setTargeting('{{ $key }}', '{{ $value }}');
                @endforeach

                googletag.pubads().addEventListener('slotRenderEnded', function (event) {
                if (event.slot.getSlotElementId() === divId) {
                console.info('[AdManager] GAM slotRenderEnded →', event.slot.getSlotElementId(), '| isEmpty:', event.isEmpty);
            }
            });

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
                                    console.info('[AdManager] 🔄 Refreshed fallback GAM slot:', divId);
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
                if (!ins) {
                    console.warn('[AdManager] ⚠️ Nie znaleziono ins elementu → fallback do GAM');
                    return fallbackToGAM('{{ $divId }}');
                }

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
                    console.warn('[AdManager] ❌ Size mapping zwrócił [0,0] lub brak dopasowania → fallback do GAM');
                    return fallbackToGAM('{{ $divId }}');
                }

                ins.style.width = matchedSize[0] + 'px';
                ins.style.height = matchedSize[1] + 'px';
                console.info('[AdManager] ✅ Size mapping:', matchedSize);

                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) return;
                        obs.unobserve(ins);

                        console.info('[AdManager] 👁️ Element widoczny → próbuję AdSense');

                        let fallbackTimer = setTimeout(() => {
                            const iframe = ins.querySelector('iframe');
                            const iframeBlank =
                                !iframe ||
                                iframe.offsetHeight === 0 ||
                                iframe.srcdoc === "" ||
                                (iframe.src && iframe.src.includes('about:blank')) ||
                                ins.getAttribute('data-ad-status') === 'unfilled';

                            if (iframeBlank) {
                                console.warn('[AdManager] ⏱️ Timeout: iframe pusty, niewidoczny lub unfilled → fallback');
                                fallbackToGAM('{{ $divId }}');
                            } else {
                                console.info('[AdManager] 🎯 AdSense iframe znaleziony i aktywny');
                            }
                        }, 1200);

                        try {
                            const result = (adsbygoogle = window.adsbygoogle || []).push({});
                            console.info('[AdManager] 📤 push() do adsbygoogle wykonany');

                            if (result && typeof result.then === 'function') {
                                result.catch(() => {
                                    clearTimeout(fallbackTimer);
                                    console.warn('[AdManager] ❌ push() zwrócił błąd → fallback');
                                    fallbackToGAM('{{ $divId }}');
                                });
                            }
                        } catch (e) {
                            clearTimeout(fallbackTimer);
                            console.error('[AdManager] ❗️ push() rzucił wyjątek:', e);
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
                    @if($isDebug)
                    console.warn('[AdManager] Slot "{{ $divId }}" not defined — mapping returned [0,0]');
                    @endif
                        return;
                }

                const mapping = googletag.sizeMapping()
                @foreach($ad['mapping'] as $map)
                    .addSize([{{ $map['viewport'][0] }}, {{ $map['viewport'][1] }}], {!! json_encode($map['sizes']) !!})
                    @endforeach
                    .build();

                const slot = googletag.defineSlot('{{ $ad['slot'] }}', {{ json_encode($defaultSize) }}, '{{ $divId }}')
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

        @if(isset($ad['adsense_fallback']))
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $ad['adsense_fallback']['client'] }}" crossorigin="anonymous"></script>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const el = document.getElementById('{{ $divId }}');
                    if (el) el.dataset.adsense = "1";
                });
            </script>
        @endif
    @endif
@endif
