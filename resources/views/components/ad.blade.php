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
            'mobile'  => ['slot' => '2004052081', 'w' => 300, 'h' => 250],
        ],
        'gam_desktop' => [
            'slot'  => '/7894359647/gp_homepage_top_gam',
            'sizes' => [[750,300], [750,250]],
        ],
        'gam_mobile' => [
            'slot'  => '/7894359647/gp_homepage_top_gam_mobile',
            'sizes' => [[300,250], [320,100]],
        ],
    ],
];


    if (! isset($config[$position])) {
        echo "<!-- ⚠️ Brak konfiguracji slotu {$position} -->";
        return;
    }

    $slotConf   = $config[$position];
    $desktop    = $slotConf['adsense']['desktop'] ?? null;
    $mobile     = $slotConf['adsense']['mobile']  ?? null;


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
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
@endif

{{-- =====================  MOBILE (widoczny tylko < md)  ================= --}}
@if($mobile)
    <div id="{{ $mobId }}-wrap" class="flex md:hidden justify-center w-full">
        <ins id="{{ $mobId }}" class="adsbygoogle"
             style="display:block;@if(isset($mobile['w']))width:{{ $mobile['w'] }}px;height:{{ $mobile['h'] }}px @endif"
             data-ad-client="{{ $client }}"
             data-ad-slot="{{ $mobile['slot'] }}"
             @if(isset($mobile['format']))  data-ad-format="{{ $mobile['format'] }}"  @endif
        ></ins>
    </div>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
@endif

{{-- =====================  Wywołanie AdSense dla obu <ins>  ============== --}}
{{--<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>--}}



{{-- =====================  Fallback do GAM (jedno wspólne JS) ============ --}}
<script>
    (function(){
        const deskId = '{{ $deskId }}';
        const mobId  = '{{ $mobId }}';

        const gamDesktop = {
            id: '{{ $deskId }}-gam',
            slot: @json($slotConf['gam_desktop']['slot']),
            sizes: @json($slotConf['gam_desktop']['sizes']),
            parentId: '{{ $deskId }}-wrap',
        };

        const gamMobile = {
            id: '{{ $mobId }}-gam',
            slot: @json($slotConf['gam_mobile']['slot']),
            sizes: @json($slotConf['gam_mobile']['sizes']),
            parentId: '{{ $mobId }}-wrap',
        };

        function isUnfilled(adId) {
            const el = document.getElementById(adId);
            return !el || el.offsetHeight < 50;
        }

        function loadGAM({id, slot, sizes, parentId}) {
            const container = document.getElementById(parentId);
            if (!container) return;

            const fallback = document.createElement('div');
            fallback.id = id;
            fallback.style.width = '100%';
            container.appendChild(fallback);

            googletag.cmd.push(function () {
                googletag.defineSlot(slot, sizes, id).addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.enableServices();
                googletag.display(id);
                console.log('[AD] GAM fallback → ' + slot);
            });
        }

        window.addEventListener('load', function () {
            setTimeout(function () {
                if (isUnfilled(deskId)) {
                    console.log('AdSense desktop unfilled');
                    const el = document.getElementById(deskId);
                    if (el) el.style.display = 'none';
                    loadGAM(gamDesktop);
                }

                if (isUnfilled(mobId)) {
                    console.log('AdSense mobile unfilled');
                    const el = document.getElementById(mobId);
                    if (el) el.style.display = 'none';
                    loadGAM(gamMobile);
                }
            }, 2500);
        });
    })();
</script>
