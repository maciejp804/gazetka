<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
<script>
    window.googletag = window.googletag || { cmd: [] };
    googletag.cmd.push(function () {
        window.gptSlots = {};

        // Lista slotów z konfiguracji
        @foreach(config('admanager.slots') as $slotName => $slot)
            window.gptSlots['{{ $slotName }}'] = googletag.defineSlot('{{ $slot['slot'] }}', [], '{{ $slot['div_id'] }}')
            .defineSizeMapping(
                googletag.sizeMapping()
                @foreach($slot['mapping'] as $map)
                    .addSize([{{ $map['viewport'][0] }}, {{ $map['viewport'][1] }}], {!! json_encode($map['sizes']) !!})
                    @endforeach
                    .build()
            )
            .addService(googletag.pubads());

        @if(isset($slot['targeting']))
            @foreach($slot['targeting'] as $key => $value)
            window.gptSlots['{{ $slotName }}'].setTargeting('{{ $key }}', '{{ $value }}');
        @endforeach
        @endif
        @endforeach

        googletag.enableServices();
    });
</script>

