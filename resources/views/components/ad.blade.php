@props([
    'position',                    // np. 'homepage_header' albo 'sidebar_left'
    'client'   => 'ca-pub-0504184268109752',
])

@php
    use Illuminate\Support\Str;

    /* ----------------------------------------------------------
     | 1. Konfiguracja wszystkich miejsc w jednym miejscu
     | ----------------------------------------------------------*/
    $config = [
        'homepage_header' => [
            'adsense' => [
                'desktop' => ['slot' => '9092204614', 'w' => 750, 'h' => 300],
                'mobile'  => ['slot' => '2004052081', 'w' => 300, 'h' => 250],     // auto = pełna responsywność
            ],
            'gam' => [
                'slot'  => '/7894359647/gp_homepage_top_gam',
                'sizes' => [[750,300],[750,250],[750,200]],
            ],
        ],

        'sidebar_left' => [
            'adsense' => [
                'desktop' => ['slot' => '1234567890', 'w' => 300, 'h' => 600],
                'mobile'  => ['slot' => '1234567891', 'w' => 300, 'h' => 250],
            ],
            'gam' => [
                'slot'  => '/7894359647/gp_sidebar_left',
                'sizes' => [[300,600],[300,250]],
            ],
        ],

        // …dodaj kolejne pozycje
    ];

    if (! isset($config[$position])) {
        echo "<!-- ⚠️ Brak konfiguracji slotu {$position} -->";
        return;
    }

    $slotConf   = $config[$position];
    $desktop    = $slotConf['adsense']['desktop'] ?? null;
    $mobile     = $slotConf['adsense']['mobile']  ?? null;
    $gamConf    = $slotConf['gam'];

    /* ----------------------------------------------------------
     | 2. Generujemy unikalną bazę ID, żeby nigdy nie dublować
     | ----------------------------------------------------------*/
    $baseId     = $position . '-' . Str::random(6);
    $deskId     = $baseId . '-desk';
    $mobId      = $baseId . '-mob';
    $gamId      = $baseId . '-gam';
@endphp


{{-- =====================  DESKTOP (ukryty w < md)  ===================== --}}
@if($desktop)
    <div id="{{ $deskId }}-wrap" class="hidden md:flex justify-center">
        <ins id="{{ $deskId }}" class="adsbygoogle"
             style="display:inline-block;width:{{ $desktop['w'] ?? 'auto' }}px;height:{{ $desktop['h'] ?? 'auto' }}px"
             data-ad-client="{{ $client }}"
             data-ad-slot="{{ $desktop['slot'] }}"></ins>
    </div>
@endif

{{-- =====================  MOBILE (widoczny tylko < md)  ================= --}}
@if($mobile)
    <div id="{{ $mobId }}-wrap" class="flex md:hidden justify-center w-full">
        <ins id="{{ $mobId }}" class="adsbygoogle"
             style="display:block"
             data-ad-client="{{ $client }}"
             data-ad-slot="{{ $mobile['slot'] }}"
             @if(isset($mobile['format']))  data-ad-format="{{ $mobile['format'] }}"  @endif
             @if(isset($mobile['w']))       style="width:{{ $mobile['w'] }}px;height:{{ $mobile['h'] }}px" @endif
             data-full-width-responsive="true"></ins>
    </div>
@endif

{{-- =====================  Wywołanie AdSense dla obu <ins>  ============== --}}
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>



{{-- =====================  Fallback do GAM (jedno wspólne JS) ============ --}}
<script>
    /* global googletag */
    (function(){
        const adIds   = ['{{ $deskId }}', '{{ $mobId }}'];   // sprawdzamy oba
        const gamSlot = @json($gamConf['slot']);
        const gamSizes= @json($gamConf['sizes']);
        const gamId   = '{{ $gamId }}';

        function tryFallback() {
            const filled = adIds.some(id => {
                const el = document.getElementById(id);
                return el && el.getAttribute('data-ad-status') !== 'unfilled';
            });
            if (filled) return;   // któryś wariant ma reklamę – kończymy

            // 1. Ukryj oba warianty AdSense
            adIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });

            // 2. Wstaw kontener GAM
            const parent = document.getElementById('{{ $deskId }}-wrap') || document.getElementById('{{ $mobId }}-wrap');
            if (!parent) return;

            const fallback = document.createElement('div');
            fallback.id    = gamId;
            parent.appendChild(fallback);

            // 3. Załaduj slot GAM
            googletag.cmd.push(function () {
                googletag.defineSlot(gamSlot, gamSizes, gamId).addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.enableServices();
                googletag.display(gamId);
                console.log('[AD] AdSense unfilled → GAM fallback (' + gamSlot + ')');
            });
        }

        /* Czekamy na załadowanie strony + krótki timeout, bo data-ad-status
           pojawia się chwilę po załadowaniu skryptu AdSense. */
        window.addEventListener('load', () => setTimeout(tryFallback, 2500));
    })();
</script>
