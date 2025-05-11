@php use Illuminate\Support\Facades\Route; @endphp
@props(['slotName', 'overrides' => []])

@php
    $ad = config("admanager.slots.$slotName");
    $baseId = $ad['div_id'] ?? 'ad-' . md5($slotName);
    $divId = $baseId . '-' . substr(md5(uniqid()), 0, 6); // unikalny div-id

    $targeting = array_merge([
        'page' => Route::currentRouteName(),
        'chain' => $retailChain->slug ?? null,
    ], $ad['targeting'] ?? [], $overrides);
@endphp

@if($ad)
    <div {{ $attributes->merge(['id' => $divId, 'class' => 'w-hidden md:flex']) }}></div>

    <script>
        googletag.cmd.push(function () {
            var mapping = googletag.sizeMapping()
            @foreach($ad['mapping'] as $map)
                .addSize([{{ $map['viewport'][0] }}, {{ $map['viewport'][1] }}], {!! json_encode($map['sizes']) !!})
                @endforeach
                .build();

            var slot = googletag.defineSlot('{{ $ad['slot'] }}', [], '{{ $divId }}')
                .defineSizeMapping(mapping)
                .addService(googletag.pubads());

            @foreach($targeting as $key => $value)
            slot.setTargeting('{{ $key }}', '{{ $value }}');
            @endforeach

            googletag.pubads().addEventListener('slotRenderEnded', function(event) {
                if (event.slot.getSlotElementId() === '{{ $divId }}' && event.isEmpty) {
                    const el = document.getElementById('{{ $divId }}');
                    if (el && el.dataset.adsense === '1') {
                        el.innerHTML = `
                            <ins class="adsbygoogle"
                                 style="display:block"
                                 data-ad-client="{{ $ad['adsense_fallback']['client'] }}"
                                 data-ad-slot="{{ $ad['adsense_fallback']['slot'] }}"
                                 data-ad-format="{{ $ad['adsense_fallback']['format'] ?? 'auto' }}"
                                 data-full-width-responsive="true"></ins>
                        `;
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    }
                }
            });

            googletag.enableServices();
            googletag.display('{{ $divId }}');
        });
    </script>

    @if(isset($ad['adsense_fallback']))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $ad['adsense_fallback']['client'] }}" crossorigin="anonymous"></script>
        <script>
            document.getElementById('{{ $divId }}').dataset.adsense = "1";
        </script>
    @endif
@endif
