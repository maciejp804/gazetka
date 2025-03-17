import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // ✅ Ładowanie głównego CSS
                'resources/js/app.js',   // ✅ Ładowanie tylko `app.js`, który zawiera resztę importów
                'resources/js/rating.js',
                'resources/js/geolocation.js',
            ],
            refresh: true, // ✅ Automatyczne odświeżanie po zmianach w plikach
        }),
    ],
});
