document.addEventListener('DOMContentLoaded', () => {
    // Sprawdź, czy ciasteczko z geolokalizacją istnieje
    const geoCookie = getCookie('user_location');

    if (geoCookie) {
        try {
            const decodedCookie = decodeURIComponent(geoCookie); // Rozkodowanie wartości
            const parsedGeoCookie = JSON.parse(decodedCookie);
            if (parsedGeoCookie.latitude && parsedGeoCookie.longitude) {
                console.log('Ciasteczko z poprawnymi danymi geolokalizacji istnieje:', parsedGeoCookie);
                return; // Jeśli ciasteczko istnieje, pomijamy dalsze sprawdzanie lokalizacji
            }
        } catch (e) {
            console.error('Błąd podczas parsowania ciasteczka geolokalizacji:', e.message);
        }
    } else {
        console.log('Brak ciasteczka. Lokalizacja...');
        // Jeśli ciasteczko nie istnieje, pobierz lokalizację
        if (mainDomain === 'gazetkapromocyjna.local') {
            console.log('Używanie symulowanej lokalizacji.');
            getGeolocationLocal('warszawa'); // Domyślna symulowana lokalizacja
        } else if ('geolocation' in navigator) {
            console.log('Pobieranie rzeczywistej lokalizacji...');
            navigator.geolocation.getCurrentPosition(
                (position) => handleSuccess(position, mainDomain),
                handleError,
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0,
                }
            );
        } else {
            console.error('Geolocation API nie jest dostępne w tej przeglądarce.');
        }
    }
});

// Funkcja do pobierania ciasteczka
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

// Funkcja do ustawiania ciasteczka
function setCookie(name, value, days, mainDomain) {
    const expires = new Date(Date.now() + days * 24 * 60 * 60 * 1000).toUTCString();
    document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/; domain=${mainDomain}`;
}

// Funkcja symulująca geolokalizację dla określonych miejsc
function getGeolocationLocal(option) {
    let optionLat, optionLng;

    switch (option) {
        case 'warszawa':
            optionLat = 52.2297;
            optionLng = 21.0122;
            break;
        case 'wielen':
            optionLat = 52.892222;
            optionLng = 16.173611;
            break;
        case 'chelst':
            optionLat = 52.8253752;
            optionLng = 15.9538823;
            break;
        case 'gmina':
            optionLat = 52.852456;
            optionLng = 16.225328;
            break;
        default:
            console.error(`Nieznana opcja: ${option}. Używanie domyślnej lokalizacji.`);
            optionLat = 0;
            optionLng = 0;
    }

    const fakePosition = {
        coords: {
            latitude: optionLat,
            longitude: optionLng,
            accuracy: 100,
            altitude: null,
            altitudeAccuracy: null,
            heading: null,
            speed: null,
        },
        timestamp: Date.now(),
    };

    handleSuccess(fakePosition, mainDomain);
}

// Callback obsługujący sukces geolokalizacji
function handleSuccess(position, mainDomain) {
    const { latitude, longitude } = position.coords;
    console.log('Pobrano lokalizację:', latitude, longitude);

    setCookie('user_location', JSON.stringify({ latitude, longitude }), 7, mainDomain);
    fetchNearestLocation(latitude, longitude, mainDomain);
}

// Callback obsługujący błąd geolokalizacji
function handleError(error) {
    console.error('Błąd podczas pobierania lokalizacji:', error.message);
}

// Funkcja do wysyłania lokalizacji na serwer
function fetchNearestLocation(latitude, longitude, mainDomain ) {
    fetch('/api/nearest-location', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ latitude, longitude, mainDomain  }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                console.error('Błąd z serwera:', data.error);
                return;
            }

            console.log('Najbliższa lokalizacja:', data.location);
        })
        .catch((error) => {
            console.error('Błąd podczas wysyłania danych:', error);
        });
}
