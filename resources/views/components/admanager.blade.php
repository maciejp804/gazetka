@props([
    'slotName',
    'overrides' => [],
    'refreshInterval' => config("admanager.slots.$slotName.refresh_interval"),
])

@php
    $ad = config("admanager.slots.$slotName");
    $enabled = $ad['enabled'];
    $divId = $ad['div_id'] ?? 'div-' . md5($slotName);
    $priority = $ad['priority'] ?? 'gam';
    $defaultSize = $ad['default_size'] ?? [300, 250];
    $isDebug = config('admanager.debug');
    $targeting = array_merge($ad['targeting'] ?? [], $overrides);
@endphp

@if($ad && $enabled)

    <div {{ $attributes->merge(['id' => $divId]) }}></div>

    @if($isDebug)
        <script>
            console.info('[AdManager] Slot: {{ $slotName }} (divId: {{ $divId }})');
            console.info('[AdManager] Priority: {{ $priority }}');
        </script>
    @endif

    @if($priority === 'adsense' && isset($ad['adsense_fallback']))
        <ins id="{{ $divId }}-adsense" class="adsbygoogle"
             style="display:block"
             data-ad-client="{{ $ad['adsense_fallback']['client'] }}"
             data-ad-slot="{{ $ad['adsense_fallback']['slot'] }}"
             data-ad-format="{{ $ad['adsense_fallback']['format'] ?? 'auto' }}"
             data-full-width-responsive="true"></ins>

        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $ad['adsense_fallback']['client'] }}" crossorigin="anonymous"></script>

        <script>
            function fallbackToGAM(divId) {
                @if($isDebug)
                console.warn('[AdManager] AdSense failed. Falling back to GAM for:', divId);
                @endif

                const el = document.getElementById(divId);
                if (el) {
                    el.innerHTML = '';
                    const placeholder = document.createElement('div');
                    placeholder.id = divId;
                    el.appendChild(placeholder);
                }

                googletag = window.googletag || {cmd: []};
                googletag.cmd.push(function () {
                    const slot = googletag.defineSlot('{{ $ad['slot'] }}', {{ json_encode($defaultSize) }}, divId)
                        .addService(googletag.pubads());

                    @foreach($targeting as $key => $value)
                    slot.setTargeting('{{ $key }}', '{{ $value }}');
                    @endforeach

                    googletag.pubads().addEventListener('slotRenderEnded', function(event) {
                        console.info('[AdManager] Fallback GAM slotRenderEnded:', event.slot.getSlotElementId(), 'isEmpty:', event.isEmpty);
                    });

                    googletag.enableServices();
                    googletag.display(divId);
                });
            }

            function attemptAdSensePush(ins, fallbackFn) {
                try {
                    (adsbygoogle = window.adsbygoogle || []).push({});
                } catch (e) {
                    fallbackFn();
                }
            }

            function tryLoadAdsense() {
                const ins = document.getElementById('{{ $divId }}-adsense');
                if (!ins) return fallbackToGAM('{{ $divId }}');

                const mapping = @json($ad['mapping'] ?? []);
                const viewportWidth = window.innerWidth;
                let matchedSize = null;

                for (let i = 0; i < mapping.length; i++) {
                    const vp = mapping[i].viewport;
                    if (viewportWidth >= vp[0]) {
                        matchedSize = mapping[i].sizes[0];
                        break;
                    }
                }

                if (!matchedSize || (Array.isArray(matchedSize) && (matchedSize[0] === 0 || matchedSize[1] === 0))) {
                    @if($isDebug)
                    console.warn('[AdManager] Skipping AdSense load for {{ $divId }} — mapping returned [0,0] or no match.');
                    @endif
                        return;
                }

                if (typeof matchedSize === 'string' && matchedSize === 'fluid') {
                    ins.classList.add('min-h-[250px]');
                }

                if (Array.isArray(matchedSize)) {
                    ins.style.width = matchedSize[0] + 'px';
                    ins.style.height = matchedSize[1] + 'px';
                }

                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            attemptAdSensePush(ins, () => fallbackToGAM('{{ $divId }}'));
                            observer.unobserve(ins);
                        }
                    });
                }, {
                    threshold: 0.5
                });

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

                let slot = null;

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

                slot = googletag.defineSlot('{{ $ad['slot'] }}', {{ json_encode($defaultSize) }}, '{{ $divId }}')
                    .defineSizeMapping(mapping)
                    .addService(googletag.pubads());

                @foreach($targeting as $key => $value)
                slot.setTargeting('{{ $key }}', '{{ $value }}');
                @endforeach

                googletag.enableServices();

                const el = document.getElementById('{{ $divId }}');

                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            googletag.display('{{ $divId }}');
                            observer.unobserve(el);
                        }
                    });
                }, {
                    threshold: 0.5
                });

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
