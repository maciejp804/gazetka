import './bootstrap';

import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'

window.Alpine = Alpine;

Alpine.plugin(collapse)

Alpine.start();

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/grid';
import 'swiper/css/scrollbar';
import 'swiper/css/zoom';
import 'swiper/css/history';
import 'swiper/css/free-mode';




