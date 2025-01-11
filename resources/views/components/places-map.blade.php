@props(['markers', 'items', 'voivodeship' => 'Wszystkie', 'mainDomain', 'latitude', 'longitude', 'scale' => 6])

<div class="flex relative h-full w-full z-10">
    <!-- Panel boczny -->
    <div id="sidebar" class="absolute top-3 left-12 grid grid-cols-2 gap-2 w-60 lg:w-1/2 z-20">
        <x-select-drpodown-url type="maps" :items="$items" :category="$voivodeship" class="col-span-2 lg:col-span-1"/>

        <div class="relative col-span-2 lg:col-span-1">
            <input
                type="text"
                id="search-input"
                class="w-full bg-white-50 rounded-3xl text-sm placeholder-gray-400 focus:outline-none focus:ring-0 border border-gray-200 focus:border-gray-200 h-12 pr-10"
                placeholder="Szukaj miejscowości..."
                autocomplete="off"
            />
            <button
                id="clear-input"
                class="absolute top-2.5 right-3 text-gray-400 hover:text-gray-600 hidden"
            >
                &times;
            </button>
            <ul
                id="marker-list"
                class="w-full max-h-[440px] scrollbar-thin overflow-y-auto bg-white border border-gray-200 rounded-lg hidden"
            ></ul>
        </div>

    </div>

    <!-- Mapa -->
    <div id="map" class="w-full h-[700px] z-10"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inicjalizacja mapy
        const map = L.map('map',{
            gestureHandling: true
        }).setView([{{$latitude}}, {{$longitude}}], {{$scale}});

        // Dodanie warstwy TileLayer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Inicjalizacja MarkerClusterGroup
        const markers = L.markerClusterGroup({
            iconCreateFunction: function (cluster) {
                const childMarkers = cluster.getAllChildMarkers();
                const groups = new Set(childMarkers.map(marker => marker.group));
                let clusterColor = 'bg-gray-500';

                if (groups.has('mazowieckie')) clusterColor = groupColors['mazowieckie'];
                else if (groups.has('pomorskie')) clusterColor = groupColors['pomorskie'];
                else {
                    const firstGroup = groups.values().next().value;
                    clusterColor = groupColors[firstGroup] || 'bg-gray-500';
                }

                return L.divIcon({
                    html: `<div class="flex items-center justify-center ${clusterColor} rounded-full text-xs text-white w-10 h-10">
                    ${cluster.getChildCount()}</div>`,
                    className: "custom-cluster-icon",
                    iconSize: [40, 40]
                });
            }
        });

        // Mapa kolorów dla województw
        const groupColors = {
            'dolnoslaskie': 'bg-yellow-500',
            'kujawsko-pomorskie': 'bg-red-500',
            'lubelskie': 'bg-green-500',
            'lubuskie': 'bg-green-500',
            'lodzkie': 'bg-orange-500',
            'malopolskie': 'bg-blue-500',
            'mazowieckie': 'bg-blue-500',
            'opolskie': 'bg-green-500',
            'podkarpackie': 'bg-green-500',
            'podlaskie': 'bg-green-500',
            'pomorskie': 'bg-blue-500',
            'slaskie': 'bg-red-500',
            'swietokrzyskie': 'bg-yellow-500',
            'warminsko-mazurskie': 'bg-yellow-500',
            'wielkopolskie': 'bg-blue-500',
            'zachodniopomorskie': 'bg-red-500',
            'default': 'bg-gray-500'
        };

        // Dane markerów
        const locations = [
                @foreach($markers as $marker)
            {
                id: {{ $marker->id }},
                name: "{{ $marker->name }}",
                lat: {{ $marker->lat }},
                lng: {{ $marker->lng }},
                slug: "{{ $marker->slug }}",
                voivodeship: "{{ $marker->voivodeship->name }}",
                group: "{{ $marker->voivodeship->slug ?? 'default' }}"
            }{{ !$loop->last ? ',' : '' }}
                @endforeach
        ];

        const markerObjects = [];

        // Dodanie markerów
        locations.forEach(location => {
            const colorClass = groupColors[location.group] || groupColors['default'];

            const html = `<div class="flex justify-center ${colorClass} px-2 py-1 rounded text-xs text-gray-200">
            ${location.name}</div>`;

            const customIcon = L.divIcon({
                className: "",
                html: html,
                iconSize: [80, 40],
                iconAnchor: [20, 20]
            });

            const marker = L.marker([location.lat, location.lng], { icon: customIcon });

            marker.id = location.id;
            marker.group = location.group;
            markerObjects.push(marker);
            markers.addLayer(marker);

            marker.on('click', () => {
                map.flyTo(marker.getLatLng(), 15, { duration: 1.5 });
                marker.openPopup();
                setTimeout(() => {
                    window.location.href = `http://{{$mainDomain}}/${location.slug}`;
                }, 500);
            });
        });

        map.addLayer(markers);

        const sidebar = document.getElementById("marker-list");
        const searchInput = document.getElementById("search-input");
        const clearButton = document.getElementById("clear-input");

        // Aktualizacja panelu bocznego
        const updateSidebar = () => {
            sidebar.innerHTML = "";

            if (searchInput.value.length >= 3) {
                sidebar.classList.remove("hidden");
                locations.forEach(location => {
                    if (location.name.toLowerCase().startsWith(searchInput.value.toLowerCase())) {
                        const marker = markerObjects.find(marker => marker.id === location.id);
                        if (map.getBounds().contains(marker.getLatLng())) {
                            const li = document.createElement("li");
                            li.innerHTML = `<span class="text-sm">${location.name}</span>
                                    <span class="text-xs">(${location.voivodeship})</span>`;
                            li.classList.add("bg-white", "text-gray-700", "hover:bg-blue-550", "hover:text-white", "p-1", "cursor-pointer");

                            li.addEventListener("click", () => {
                                // Przejście do markera na mapie
                                map.flyTo(marker.getLatLng(), 15, { duration: 1.5 });
                                marker.openPopup();

                                // Czyszczenie inputa i ukrywanie listy
                                searchInput.value = "";
                                sidebar.classList.add("hidden");
                                clearButton.classList.add("hidden");
                            });

                            sidebar.appendChild(li);
                        }
                    }
                });
            } else {
                sidebar.classList.add("hidden");
            }
        };

        // Czyszczenie pola wyszukiwania
        clearButton.addEventListener("click", () => {
            searchInput.value = "";
            sidebar.classList.add("hidden");
            clearButton.classList.add("hidden");
        });

        // Pokaż przycisk X, gdy wprowadzony tekst
        searchInput.addEventListener("input", () => {
            if (searchInput.value.length > 0) {
                clearButton.classList.remove("hidden");
            } else {
                clearButton.classList.add("hidden");
                sidebar.classList.add("hidden");
            }
            updateSidebar();
        });

        // Ukrycie listy wyników po kliknięciu poza nią
        document.addEventListener("click", (event) => {
            if (!sidebar.contains(event.target) && event.target !== searchInput) {
                sidebar.classList.add("hidden");
            }
        });
    });

</script>
