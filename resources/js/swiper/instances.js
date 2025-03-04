import { initSwiper } from "./helpers";
import { Grid, Navigation, Pagination, Zoom, Autoplay, FreeMode } from "swiper/modules";

// ✅ Konfiguracja dla .leaflet
export function initLeafletSwiper() {
    if (document.querySelector(".leaflet")) {
        console.log("✅ Inicjalizuję Swiper dla .leaflet");
        initSwiper(".leaflet", {
            modules: [Navigation, Pagination, Grid],
            slidesPerView: 2,
            spaceBetween: 5,
            grid: {rows: 2, fill: "row"},
            breakpoints: {
                320: {slidesPerView: 2, spaceBetween: 25, grid: {rows: 2, fill: "row"}},
                425: {slidesPerView: 2, spaceBetween: 25, grid: {rows: 2, fill: "row"}},
                475: {slidesPerView: 3, spaceBetween: 5, grid: {rows: 2, fill: "row"}},
                640: {slidesPerView: 3, spaceBetween: 5, grid: {rows: 2, fill: "row"}},
                768: {slidesPerView: 4, spaceBetween: 5, grid: {rows: 2, fill: "row"}},
                1024: {slidesPerView: 5, spaceBetween: 5, grid: {rows: 3, fill: "row"}},
                1440: {slidesPerView: 5, spaceBetween: 15, grid: {rows: 3, fill: "row"}},
            },
            pagination: {el: ".swiper-pagination", dynamicBullets: true, clickable: true},
        }, ".button-prev-leaflet", ".button-next-leaflet");
    } else {
    console.warn("❌ Nie znaleziono Swipera .leaflet lub `initSwiper` nie istnieje.");
    }
}

// ✅ Konfiguracja dla .leafletPromo
export function initLeafletPromoSwiper() {
    if (document.querySelector(".leafletPromo")) {
        console.log("✅ Inicjalizuję Swiper dla .leafletPromo");
        initSwiper('.leafletPromo', {
            modules: [Navigation, Pagination, Grid, Zoom],
            observer: true,
            observeParents: true,
            slidesPerView: 2,
            spaceBetween: 5,
            grid: {rows: 2, fill: 'row'},
            breakpoints: {
                320: {slidesPerView: 2, spaceBetween: 25, grid: {rows: 2}},
                425: {slidesPerView: 2, spaceBetween: 15, grid: {rows: 2}},
                475: {slidesPerView: 2, spaceBetween: 25, grid: {rows: 2}},
                640: {slidesPerView: 3, spaceBetween: 5, grid: {rows: 2}},
                768: {slidesPerView: 4, spaceBetween: 5, grid: {rows: 1}},
                1024: {slidesPerView: 5, spaceBetween: 5, grid: {rows: 1}},
                1440: {slidesPerView: 5, spaceBetween: 7, grid: {rows: 1}}
            },
            pagination: {el: ".swiper-pagination", dynamicBullets: true, clickable: true},
        }, ".button-prev-leafletPromo", ".button-next-leafletPromo");
    } else {
        console.warn("❌ Nie znaleziono Swipera .leafletPromo lub `initSwiper` nie istnieje.");
    }
}

// ✅ Konfiguracja dla .category-swiper
export function initCategorySwiper() {
    if (document.querySelector(".category-swiper")) {
        console.log("✅ Inicjalizuję Swiper dla .category-swiper");
        initSwiper('.category-swiper', {
            modules: [Navigation, Pagination, Grid],
            slidesPerView: 3,
            spaceBetween: 5,
            grid: { rows : 2, fill: 'row'},
            breakpoints: {
                320: { slidesPerView: 3, spaceBetween: 5, grid: { rows : 2, fill: 'row'}},
                375: { slidesPerView: 3, spaceBetween: 10, grid: { rows : 2, fill: 'row'}},
                425: { slidesPerView: 3, spaceBetween: 10, grid: { rows : 2, fill: 'row'}},
                475: { slidesPerView: 4, spaceBetween: 5, grid: { rows : 2, fill: 'row'}},
                640: { slidesPerView: 5, spaceBetween: 5, grid: { rows : 1, fill: 'row'}},
                768: { slidesPerView: 5, spaceBetween: 5, grid: { rows : 1, fill: 'row'}},
                1024: { slidesPerView: 7, spaceBetween: 18, grid: { rows : 1, fill: 'row'}},
                1440: { slidesPerView: 7, spaceBetween: 25, grid: { rows : 1, fill: 'row'}}
            },
            pagination: {el: ".swiper-pagination", dynamicBullets: true,clickable: true}
        }, '.button-prev-category-swiper', '.button-next-category-swiper');
    } else {
        console.warn("❌ Nie znaleziono Swipera .category-swiper lub `initSwiper` nie istnieje.");
    }
}

// ✅ Konfiguracja dla .category-swiper-small
export function initCategorySwiperSmall() {
    if (document.querySelector(".category-swiper-small")) {
        console.log("✅ Inicjalizuję Swiper dla .category-swiper-small");
        initSwiper('.category-swiper-small', {
            modules: [Navigation, Grid],
            slidesPerView: 2,
            spaceBetween: 5,
            grid: { rows : 1, fill: 'row'},
            breakpoints: {
                320: { slidesPerView: 4, spaceBetween: 5, grid: { rows : 1, fill: 'row'}},
                375: { slidesPerView: 5, spaceBetween: 10, grid: { rows : 1}},
                425: { slidesPerView: 5, spaceBetween: 10, grid: { rows : 1}},
                475: { slidesPerView: 5, spaceBetween: 10, grid: { rows: 1}},
                640: { slidesPerView: 10, spaceBetween: 10, grid: { rows: 1}},
                768: { slidesPerView: 10, spaceBetween: 10},
                1024: { slidesPerView: 10, spaceBetween: 18, grid: { rows : 1}},
                1440: { slidesPerView: 10, spaceBetween: 25, grid: { rows : 1}}
            }
        }, '.prev-swiper', '.next-swiper');
    } else {
        console.warn("❌ Nie znaleziono Swipera .category-swiper-small lub `initSwiper` nie istnieje.");
    }
}

// ✅ Konfiguracja dla .swiper-shops
export function initShopsSwiper() {
    if (document.querySelector(".swiper-shops")) {
        console.log("✅ Inicjalizuję Swiper dla .swiper-shops");
        initSwiper('.swiper-shops', {
            modules: [Navigation, Pagination, Grid],
            slidesPerView: 2,
            spaceBetween: 5,
            grid: { rows: 2, fill: 'row'},
            breakpoints: {
                320: { slidesPerView: 2, spaceBetween: 5},
                375: { slidesPerView: 2, spaceBetween: 5},
                425: { slidesPerView: 2, spaceBetween: 25},
                475: { slidesPerView: 3, spaceBetween: 10},
                640: { slidesPerView: 3, spaceBetween: 5},
                768: { slidesPerView: 4, spaceBetween: 5, grid: { rows: 1 }},
                1024: { slidesPerView: 5, spaceBetween: 5, grid: { rows: 1 }},
                1440: { slidesPerView: 5, spaceBetween: 15, grid: { rows: 1 }}
            },
            pagination: {el: ".swiper-pagination", dynamicBullets: true, clickable: true}
        }, '.button-prev-swiper-shops', '.button-next-swiper-shops');
    } else {
        console.warn("❌ Nie znaleziono Swipera .swiper-shops lub `initSwiper` nie istnieje.");
    }
}

// ✅ Konfiguracja dla .swiper-product
export function initProductSwiper() {
    if (document.querySelector(".swiper-product")) {
        console.log("✅ Inicjalizuję Swiper dla .swiper-product");
        initSwiper('.swiper-product', {
            modules: [Navigation, Pagination, Grid],
            slidesPerView: 2,
            spaceBetween: 5,
            grid: { rows: 2, fill: 'row'},
            breakpoints: {
                320: { slidesPerView: 2, spaceBetween: 5},
                375: { slidesPerView: 2, spaceBetween: 5},
                425: { slidesPerView: 2, spaceBetween: 25},
                475: { slidesPerView: 3, spaceBetween: 10},
                640: { slidesPerView: 3, spaceBetween: 5},
                768: { slidesPerView: 4, spaceBetween: 5, grid: { rows: 1 }},
                1024: { slidesPerView: 5, spaceBetween: 5, grid: { rows: 1 }},
                1440: { slidesPerView: 5, spaceBetween: 15, grid: { rows: 1 }}
            },
            pagination: {el: ".swiper-pagination", dynamicBullets: true, clickable: true}
        }, '.button-prev-swiper-product', '.button-next-swiper-product');
    } else {
        console.warn("❌ Nie znaleziono Swipera .mySwiper lub `initSwiper` nie istnieje.");
    }
}

// ✅ Konfiguracja dla .swiper-info
export function initSwiperInfo() {
    if (document.querySelector(".swiper-info")) {
        console.log("✅ Inicjalizuję Swiper dla .swiper-info");
        initSwiper('.swiper-info', {
            modules: [Pagination, Navigation],
            slidesPerView: 5,
            spaceBetween: 5,
            breakpoints: {
                320: { slidesPerView: 2, spaceBetween: 5},
                425:{ slidesPerView: 2, spaceBetween: 10},
                475: { slidesPerView: 2, spaceBetween: 10},
                640: { slidesPerView: 4, spaceBetween: 10},
                1024: { slidesPerView: 5, spaceBetween: 15, loop:false},
            },
            pagination: { el: ".swiper-pagination", dynamicBullets: true, clickable: true}
        }, '.button-prev-swiper-info', '.button-next-swiper-info');
    } else {
        console.warn("❌ Nie znaleziono Swipera .swiper-info lub `initSwiper` nie istnieje.");
    }
}

// ✅ Konfiguracja dla .swiper-blog
export function initSwiperBlog() {
    if (document.querySelector(".swiper-blog")) {
        console.log("✅ Inicjalizuję Swiper dla .swiper-blog");
        initSwiper('.swiper-blog', {
            modules: [Navigation, Pagination, Grid],
            slidesPerView: 1,
            spaceBetween: 5,
            grid: { rows : 2, fill: 'row'},
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 5},
                425:{ slidesPerView: 2, spaceBetween: 10},
                475: { slidesPerView: 2, spaceBetween: 10},
                640: { slidesPerView: 3, spaceBetween: 10, grid: { rows : 1}},
                768: { slidesPerView: 4, spaceBetween: 10, grid: { rows : 1}},
                1024: { slidesPerView: 4, spaceBetween: 15, grid: { rows : 1}},
                1060: { slidesPerView: 5, spaceBetween: 15, grid: { rows : 1}},
            },
            pagination: { el: ".swiper-pagination", dynamicBullets: true, clickable: true}
        }, '.button-prev-swiper-blog', '.button-next-swiper-blog');
    } else {
        console.warn("❌ Nie znaleziono Swipera .swiper-blog lub `initSwiper` nie istnieje.");
    }
}

export function initSwiperLeafletSingle() {
    if (document.querySelector(".leafletSingle")) {
        console.log("✅ Inicjalizuję Swiper dla .leafletSingle");
        initSwiper('.leafletSingle', {
            modules: [Navigation, Pagination, Grid, Zoom],
            slidesPerView: 2,
            spaceBetween: 5,
            grid: {rows: 1, fill: 'row'},
            breakpoints: {
                320: {slidesPerView: 2, spaceBetween: 25, grid: {rows: 1}},
                425: {slidesPerView: 3, spaceBetween: 10, grid: {rows: 1}},
                475: {slidesPerView: 3, spaceBetween: 5},
                640: {slidesPerView: 3, spaceBetween: 5, grid: {rows: 1}},
                768: {slidesPerView: 4, spaceBetween: 5, grid: {rows: 1}},
                1024: {slidesPerView: 5, spaceBetween: 5, grid: {rows: 1}},
                1440: {slidesPerView: 5, spaceBetween: 15, grid: {rows: 1}}
            },
            pagination: {el: ".swiper-pagination", dynamicBullets: true, clickable: true}
        }, '.button-prev-leafletSingle', '.button-next-leafletSingle');
    } else {
        console.warn("❌ Nie znaleziono Swipera .leafletSingle lub `initSwiper` nie istnieje.");
    }
}

export function initSwiperCategoryBlog() {
    if (document.querySelector(".swiper-category-blog")) {
        console.log("✅ Inicjalizuję Swiper dla .swiper-category-blog");
        setTimeout(() => {
            const skeletonElement= document.getElementById('skeleton-slider');
            const actualElement = document.getElementById('actual-slider');

            if (skeletonElement && actualElement) {
                skeletonElement.classList.add('!hidden');
                actualElement.classList.remove('!hidden');
            }


            // Inicjalizacja Swipera
            initSwiper('.swiper-category-blog', {
                modules: [Navigation, FreeMode],
                slidesPerView: 'auto',
                spaceBetween: 5,
                freeMode: true,
                navigation: { enabled: false},
                breakpoints: {
                    375: {spaceBetween: 5},
                    425: {spaceBetween: 10},
                    475: {spaceBetween: 10},
                    640: {spaceBetween: 10},
                    768: {spaceBetween: 10},
                    1024: {spaceBetween: 10},
                    1060: {spaceBetween: 10},
                    1440: {spaceBetween: 15},
                }
            }, '.button-prev', '.button-next');
        }, 1000);
    } else {
        console.warn("❌ Nie znaleziono Swipera .swiper-category-blog lub `initSwiper` nie istnieje.");
    }
}

export function initSwiperVoucherPromo() {
    if (document.querySelector(".vouchers-swiper-promo")) {
        console.log("✅ Inicjalizuję Swiper dla .vouchers-swiper-promo");
        setTimeout(() => {

            const skeletonVoucherElement= document.getElementById('skeleton-slider-vouchers');
            const actualVoucherElement = document.getElementById('actual-slider-vouchers');

            if (skeletonVoucherElement && actualVoucherElement) {
                skeletonVoucherElement.classList.add('!hidden');
                actualVoucherElement.classList.remove('!hidden');
            }


            // Inicjalizacja Swipera kuponów
            initSwiper('.vouchers-swiper-promo', {
                modules: [Navigation, Pagination, Grid],
                slidesPerView: 2,
                spaceBetween: 5,
                grid: { rows : 2, fill: 'row'},
                breakpoints: {
                    320: {slidesPerView: 1,spaceBetween: 10},
                    375: {slidesPerView: 1,spaceBetween: 20},
                    425: {slidesPerView: 1,spaceBetween: 30},
                    475: {slidesPerView: 2,spaceBetween: 10},
                    640: {slidesPerView: 2,spaceBetween: 30},
                    768: {slidesPerView: 3,spaceBetween: 20},
                    1024: {slidesPerView: 4,spaceBetween: 15, grid: { rows : 1, fill: 'row'}},
                    1440: {slidesPerView: 3,spaceBetween: 20, grid: { rows : 1, fill: 'row'}},
                },
                pagination: { el: ".swiper-pagination", dynamicBullets: true, clickable: true}
            }, '.button-prev-vouchers-swiper-promo', '.button-next-vouchers-swiper-promo');
        }, 1000);
    } else {
        console.warn("❌ Nie znaleziono Swipera .vouchers-swiper-promo lub `initSwiper` nie istnieje.");
    }
}
