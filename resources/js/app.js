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

// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination, Grid} from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/grid';
import 'swiper/css/scrollbar';
import 'swiper/css/zoom';
import 'swiper/css/history';




