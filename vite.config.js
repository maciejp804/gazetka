import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/owl.carousel.min.css',
                'resources/css/owl.theme.default.min.css',
                'resources/js/app.js',
                'resources/js/jquery-3.7.1.min.js',
                'resources/js/owl.carousel.min.js',
                'resources/js/custom-carousel.js',
                'resources/js/custom-swiper.js',
                'resources/js/leaflet-swiper.js',
                'resources/js/filter.js',
                'resources/js/rating.js',
                'resources/js/geolocation.js',
            ],
            refresh: true,
        }),
    ],
});
