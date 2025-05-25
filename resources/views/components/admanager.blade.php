@props([
    'slotName',
    'overrides' => [],
    'refreshInterval' => config("admanager.slots.$slotName.refresh_interval"),
])

@php
    $ad = config("admanager.slots.$slotName");
    $enabled = $ad['enabled'] ?? false;
    $divId = $ad['div_id'] ?? 'div-' . md5($slotName);
    $priority = $ad['priority'] ?? 'adsense';
    $isDebug = config('admanager.debug');
    $targeting = array_merge($ad['targeting'] ?? [], $overrides);
    $mappingFiltered = collect($ad['mapping'] ?? [])->filter(fn($m) => ($m['sizes'][0][0] ?? 0) > 0 && ($m['sizes'][0][1] ?? 0) > 0)->values()->all();
    $adsense = $ad['adsense_fallback'] ?? null;
@endphp

@if($ad && $enabled && $adsense && count($mappingFiltered) > 0)
    @if($isDebug)
        <script>
            console.info('[AdManager] Slot: {{ $slotName }} (divId: {{ $divId }})');
            console.info('[AdManager] Priority: {{ $priority }}');
        </script>
    @endif

    <div id="adsense-container-{{ $divId }}">
        <ins id="{{ $divId }}-adsense"
             class="adsbygoogle block"
             style="{{ $adsense['style'] ?? 'display:block;width:300px;height:250px' }}"
             data-ad-client="{{ $adsense['client'] }}"
             data-ad-slot="{{ $adsense['slot'] }}"
             data-ad-format="{{ $adsense['format'] ?? 'auto' }}"
             data-full-width-responsive="{{ $adsense['responsive'] ?? 'true' }}"></ins>

        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>

    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const ad = document.getElementById('{{ $divId }}-adsense');
                if (ad?.getAttribute('data-ad-status') === 'unfilled') {
                    console.warn('AdSense unfilled – fallback to GAM');

                    ad.style.display = 'none';

                    const fallback = document.createElement('div');
                    fallback.id = '{{ $divId }}-fallback';
                    fallback.style.width = '{{ Str::between($adsense['style'], 'width:', 'px') }}px';
                    fallback.style.height = '{{ Str::between($adsense['style'], 'height:', 'px') }}px';
                    document.querySelector('#adsense-container-{{ $divId }}').appendChild(fallback);

                    googletag = window.googletag || {cmd: []};
                    googletag.cmd.push(() => {
                        const mapping = googletag.sizeMapping()
                        @foreach($mappingFiltered as $map)
                            .addSize([{{ $map['viewport'][0] }}, {{ $map['viewport'][1] }}], {!! json_encode($map['sizes']) !!})
                            @endforeach
                            .build();

                        const slot = googletag.defineSlot('{{ $ad['slot'] }}', [], '{{ $divId }}-fallback')
                            .defineSizeMapping(mapping)
                            .addService(googletag.pubads());

                        @foreach($targeting as $key => $value)
                        slot.setTargeting('{{ $key }}', '{{ $value }}');
                        @endforeach

                        googletag.enableServices();
                        googletag.display('{{ $divId }}-fallback');
                    });
                }
            }, 1500);
        });
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


