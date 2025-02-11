import './bootstrap';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/grid';
import 'swiper/css/scrollbar';
import 'swiper/css/zoom';
import 'swiper/css/history';
import 'swiper/css/free-mode';

import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

import L from 'leaflet';
import { GestureHandling } from "leaflet-gesture-handling";

import 'leaflet/dist/leaflet.css';
import "leaflet-gesture-handling/dist/leaflet-gesture-handling.css";
import 'leaflet.markercluster';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
import 'leaflet.markercluster/dist/MarkerCluster.css';

window.Alpine = Alpine;

Alpine.plugin(collapse)

Alpine.start();



document.addEventListener('DOMContentLoaded', () => {

    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
        flashMessage.classList.add('transition', 'duration-3000', 'ease-out', 'opacity-0');
        // Ukryj komunikat po 5 sekundach:
        setTimeout(() => {
            flashMessage.remove(); // Usuwa <div> z DOM
        }, 2500);
    }


});



