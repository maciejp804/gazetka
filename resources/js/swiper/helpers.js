import Swiper from "swiper";
import { Grid, Navigation, Pagination, Zoom, Autoplay, FreeMode } from "swiper/modules";

// ✅ Funkcja do ukrywania/pokazywania przycisków nawigacji
export function toggleNavButtons(swiper, prevSelector, nextSelector) {
    const prevButton = document.querySelector(prevSelector);
    const nextButton = document.querySelector(nextSelector);

    if (!prevButton || !nextButton) {
        console.warn("One or both navigation buttons not found for", swiper);
        return;
    }

    const totalSlides = swiper.slides.length;
    const slidesPerView = swiper.params.slidesPerView || 1;


    if (totalSlides <= slidesPerView || window.innerWidth <= 769) {
        prevButton.style.display = "none";
        nextButton.style.display = "none";
    } else {
        prevButton.style.display = swiper.isBeginning ? "none" : "flex";
        nextButton.style.display = swiper.isEnd ? "none" : "flex";
    }
}

// ✅ Funkcja do inicjalizacji Swipera
export function initSwiper(selector, options, prevSelector, nextSelector) {

    if (selector instanceof HTMLElement) {
        console.error("❌ BŁĄD: `selector` powinien być stringiem, a nie elementem HTML!", selector);
        return;
    }

    const swiperElements = document.querySelectorAll(selector);

    swiperElements.forEach((swiperElement, index) => {
        const instancePrevSelector = `${prevSelector}`;
        const instanceNextSelector = `${nextSelector}`;

        const swiper = new Swiper(swiperElement, {
            ...options,
            navigation: { nextEl: instanceNextSelector, prevEl: instancePrevSelector },
            on: {
                init: function () {
                    toggleNavButtons(this, instancePrevSelector, instanceNextSelector);
                },
                slideChange: function () {
                    toggleNavButtons(this, instancePrevSelector, instanceNextSelector);
                },
            },
        });

        // Automatyczna kontrola przycisków nawigacyjnych przy zmianie rozmiaru okna
        window.addEventListener("resize", () => toggleNavButtons(swiper, instancePrevSelector, instanceNextSelector));
    });
}
