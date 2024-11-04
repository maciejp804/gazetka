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

        const customCenterIcon = L.divIcon({
            className: 'center-marker', // Ustawienie klasy CSS dla markerów
            html: '<i class="fa-solid fa-person-walking flex justify-center self-center text-base text-white"></i>',
            iconSize: [25, 25], // Rozmiar markera
            iconAnchor: [20, 0] // Punkt zakotwiczenia markera
        });

        const centerMarker = L.marker([{{ $latitude }}, {{ $longitude }}], {icon: customCenterIcon}).addTo(map);

        @if(isset($markers))
        @foreach ($markers as $marker)

        var customIcon = L.divIcon({
            className: "custom-after-border", // Ustawienie klasy CSS dla markerów
            html: '<img class="w-10 h-10 rounded-full border-2 border-blue-550" src="' +
                '@if(!empty($marker))' +
                'https://hoian.pl/assets/image/store/{{$marker['name']}}-marker.png' +
                '@endif" />', // Definicja HTML dla markera
            iconSize: [40, 40], // Rozmiar markera
            iconAnchor: [20, 40] // Punkt zakotwiczenia markera
        });

        var marker = L.marker([{{$marker['lat']}}, {{$marker['lng']}}], {icon: customIcon});

        var contentString = '<div id="infobox">' +
            '@if(isset($marker->stores->name) && !empty($marker->stores->name))' +
            '<div class="infobox-image"><a href="https://{{$marker->stores->subdomain}}.gazetkapromocyjna.com.pl/{{$place->slug}}/">' +
            '<img src="{{asset('assets/image/store/'.$marker->stores->subdomain)}}-69.png"/></a></div>' +
            '<a href="https://{{$marker->stores->subdomain}}.' +
            'gazetkapromocyjna.com.pl/godziny-otwarcia/{{$place->slug}}-{{$marker->slug}},{{$marker->id}}/">{{$marker->address}} <br/><br/>{{$place->name}}<br/></a>' +
            '@endif' +
            '<div class="open-houers"><span>Godziny otwarcia:</span><br/>' +
            '<span class="' +
            '@if(date("D") == "Mon")' +
            'active-day' +
            '@endif'
            + '">poniedziałek: <span class="open-houers-days">9:00-21:00</span></span><br/>' +
            '<span class="' +
            '@if(date("D") == "Tue")' +
            'active-day' +
            '@endif'
            + '">wtorek: <span class="open-houers-days">9:00-21:00</span></span><br/>' +
            '<span class="' +
            '@if(date("D") == "Wed")' +
            'active-day' +
            '@endif'
            + '">środa: <span class="open-houers-days">9:00-21:00</span></span><br/>' +
            '<span class="' +
            '@if(date("D") == "Thu")' +
            'active-day' +
            '@endif'
            + '">czwartek: <span class="open-houers-days">9:00-21:00</span></span><br/>' +
            '<span class="' +
            '@if(date("D") == "Fri")' +
            'active-day' +
            '@endif'
            + '">piątek: <span class="open-houers-days">9:00-21:00</span></span><br/>' +
            '<span class="' +
            '@if(date("D") == "Sat")' +
            'active-day' +
            '@endif'
            + '">sobota: <span class="open-houers-days">9:00-21:00</span></span><br/>' +
            '<span class="' +
            '@if(date("D") == "Sun")' +
            'active-day' +
            '@endif'
            + '">niedziela handlowa: <span class="open-houers-days">9:00-21:00</span></span></div>';


        // Stworzenie popupu dla markera
        marker.bindPopup(contentString);

        // Dodanie markera do grupy
        markerCluster.addLayer(marker);
        @endforeach

        // Dodanie grupy markerów do mapy
        map.addLayer(markerCluster);


        @endif
    });
</script>
