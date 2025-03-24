@props(['latitude', 'longitude', 'zoom', 'marker', 'place'])
<!-- resources/views/components/map.blade.php -->
<div id="{{ $mapId }}" style="width: 100%; height: 400px;"></div>

<script>

     document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('{{ $mapId }}').setView([{{ $latitude }}, {{ $longitude }}], {{ $zoom }});
        map.scrollWheelZoom.disable(); // Wyłączenie zoomowania za pomocą kółka myszki

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 20,
        }).addTo(map);

        // Stworzenie grupy dla markerów
        const markerCluster = L.markerClusterGroup();

        {{--const customCenterIcon = L.divIcon({--}}
        {{--    className: 'center-marker', // Ustawienie klasy CSS dla markerów--}}
        {{--    html: '<i class="fa-solid fa-person-walking flex justify-center self-center text-base text-white"></i>',--}}
        {{--    iconSize: [25, 25], // Rozmiar markera--}}
        {{--    iconAnchor: [20, 0] // Punkt zakotwiczenia markera--}}
        {{--});--}}

        {{--const centerMarker = L.marker([{{ $latitude }}, {{ $longitude }}], {icon: customCenterIcon}).addTo(map);--}}

        @if(isset($marker))

        var customIcon = L.divIcon({
            className: "custom-after-border", // Ustawienie klasy CSS dla markerów
            html: '<img class="w-10 h-10 rounded-full border-2 border-blue-550" src="' +
                '@if(!empty($marker))' +
                'https://hoian.pl/assets/image/store/{{$marker->shop->slug}}-marker.png' +
                '@endif" />', // Definicja HTML dla markera
            iconSize: [40, 40], // Rozmiar markera
            iconAnchor: [20, 40] // Punkt zakotwiczenia markera
        });

        var marker = L.marker([{{$marker->lat}}, {{$marker->lng}}], {icon: customIcon});

        {{--var contentString = '<div id="infobox">' +--}}
        {{--    '@if(isset($marker->shop->image) && !empty($marker->shop->image))' +--}}
        {{--    '<div class="infobox-image"><a href="{{route('subdomain.index_gps',['subdomain' => $marker->shop->slug, 'community' => $marker->place->slug])}}">' +--}}
        {{--    '<img src="{{$marker->shop->image}}"/></a></div>' +--}}
        {{--    '<a href="{{route('subdomain.shop_address', ['subdomain' => $marker->shop->slug,'community' => $marker->place->slug ,'address' => $marker->slug])}}">{{$marker->address}}, {{$place->name}}<br/></a>' +--}}
        {{--    '@endif' +--}}
        {{--    '<div class="open-houers"><span>Godziny otwarcia:</span><br/>' +--}}
        {{--    '@if(isset($marker->hours) && !empty($marker->hours))' +--}}
        {{--    '@foreach($marker->hours as $hour)' +--}}
        {{--        '<span class="' +--}}
        {{--        '@if(date("l") == mb_ucfirst($hour->day_of_work) && date("l") !== 'Sunday')' +--}}
        {{--            'font-semibold text-green-800' +--}}
        {{--        '@elseif(str_contains($hour->day_of_work, 'sunday') && date("l") == 'Sunday')' +--}}
        {{--            'font-semibold text-green-800' +--}}
        {{--        '@endif' +--}}
        {{--    '">{{__('days.'.$hour->day_of_work)}}: <span>' +--}}
        {{--        '@if(str_contains($hour->day_of_work, 'non') && $hour->opening_time == '00:00:00')' +--}}
        {{--            'zamkniete' +--}}
        {{--        '@else' +--}}
        {{--            '{{date("G:i",strtotime($hour->opening_time))}}-{{date("G:i",strtotime($hour->closing_time))}}' +--}}
        {{--        '@endif' +--}}
        {{--    '</span></span><br/>' +--}}
        {{--    '@endforeach' +--}}
        {{--    '@endif' +--}}
        {{--    '</div>';--}}


        {{--// Stworzenie popupu dla markera--}}
        {{--marker.bindPopup(contentString);--}}

        // Dodanie markera do grupy
        markerCluster.addLayer(marker);


        // Dodanie grupy markerów do mapy
        map.addLayer(markerCluster);


        @endif
    });
</script>
