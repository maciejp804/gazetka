import Swiper from "swiper";
import { HashNavigation, Navigation, Pagination, Zoom } from "swiper/modules";

document.addEventListener('DOMContentLoaded', function () {

    let isMobile = window.innerWidth <= 768;
    let redirectTimeout;
    const countdownElement = createCountdownElement();

    correctHashIfNeeded();

    window.addEventListener('hashchange', function () {
        console.log('hashchange');
        correctHashIfNeeded();
    });

    // Inicjalizacja głównego Swipera
    const swiper9 = new Swiper('.swiper-container', {
        speed: 300,
        modules: [Navigation, Pagination, Zoom, HashNavigation],
        loop: false,
        followFinger: true,
        direction: 'horizontal',
        zoom: {
            maxRatio: 3,
            scale: 3
        },
        pagination: {
            el: '.swiper-pagination',
            type: "fraction",
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        hashNavigation: {
            watchState: true,
        },
        on: {
            init: function () {
                document.getElementById('preloader').style.display = 'none';
                document.querySelector('.swiper-container').style.display = 'block';
                updateNestedSwiperHeight();
            },
            slideChangeTransitionEnd: function () {
                updateNestedSwiperHeight();
            },
            zoomChange: function (swipe9, scale) {
                toggleClickableAreas(scale);
            }
        }
    });

    let swiper10Instances = {};

    function initializeNestedSlider(slideIndex) {
        console.log('Initializing nested slider for slide:', slideIndex);
        const slide = swiper9.slides[slideIndex];
        const nestedSwiperElement = slide.querySelector('.sub-swiper');

        if (nestedSwiperElement) {
            swiper10Instances[slideIndex] = new Swiper(nestedSwiperElement, {
                loop: false,
                followFinger: true,
                slidesPerView: 1,
                observer: true,
                observeParents: true,
                breakpoints: {
                    769: {
                        slidesPerView: 2
                    }
                },
                direction: 'horizontal',
                nested: true,
                allowTouchMove: true,
                navigation: {
                    nextEl: slide.querySelector('.sub-swiper-next'),
                    prevEl: slide.querySelector('.sub-swiper-prev'),
                },
            });

            updateNestedSwiperHeight();
        }
    }

    swiper9.on('slideChange', function () {
        console.log('slideChange');
        swiper9.zoom.out();

        stopRedirectCountdown();

        if (swiper9.isEnd) {
            console.log('Osiągnięto ostatni slajd, rozpoczynam odliczanie do przekierowania.');
            startRedirectCountdown();
        }

        const slides = swiper9.slides;
        slides.forEach(slide => {
            slide.classList.remove('swiper-slide-zoomed');
            const nestedSwiperWrapper = slide.querySelector('.sub-swiper-wrapper');
            if (nestedSwiperWrapper) {
                nestedSwiperWrapper.classList.remove('hidden');
            }
        });

        const activeIndex = swiper9.activeIndex;
        initializeNestedSlider(activeIndex);
    });

    document.querySelectorAll('.sub-swiper-next, .sub-swiper-prev').forEach(button => {
        button.addEventListener('click', function (evt) {
            console.log('clicked');
            evt.stopPropagation();
        });
    });

    function correctHashIfNeeded() {
        console.log('correctHashIfNeeded');
        const hash = window.location.hash.replace('#', '');
        if (hash && !isNaN(hash)) {
            const pageIndex = parseInt(hash, 10);

            if (pageIndex % 2 === 0 && isMobile === false) {
                const correctedIndex = pageIndex + 1;
                window.location.hash = `#${correctedIndex}`;

                const targetIndex = Array.from(document.querySelectorAll('.swiper-slide'))
                    .findIndex(slide => slide.dataset.hash === `slide-${correctedIndex}`);

                if (targetIndex !== -1) {
                    swiper9.slideTo(targetIndex);
                }
            } else {
                const targetIndex = Array.from(document.querySelectorAll('.swiper-slide'))
                    .findIndex(slide => slide.dataset.hash === `slide-${hash}`);

                if (targetIndex !== -1) {
                    swiper9.slideTo(targetIndex);
                }
            }
        }
    }

    function toggleClickableAreas(scale) {
        console.log('toggleClickableAreas');
        const clickableAreas = document.querySelectorAll('.clickable');
        const subSlider = document.querySelectorAll('.sub-swiper');

        if (scale > 1) {
            clickableAreas.forEach(area => {
                area.style.display = 'none';
            });
            subSlider.forEach(slider => {
                slider.style.display = 'none';
            })
        } else {
            clickableAreas.forEach(area => {
                area.style.display = 'block';
            });
            subSlider.forEach(slider => {
                slider.style.display = 'block';
            })
        }
    }

    swiper9.on('reachEnd', function () {
        console.log('Reach End');
        startRedirectCountdown();
    });

    function startRedirectCountdown() {
        console.log('Redirect Countdown');
        let countdown = 5;
        countdownElement.querySelector('span').textContent = `Przekierowanie za ${countdown} sekund...`;
        document.body.appendChild(countdownElement);

        const interval = setInterval(() => {
            countdown--;
            if (countdown > 0) {
                countdownElement.querySelector('span').textContent = `Przekierowanie za ${countdown} sekund...`;
            } else {
                clearInterval(interval);
            }
        }, 1000);

        redirectTimeout = setTimeout(() => {
            window.location.href = "https://example.com/nastepna-strona";
        }, 5000);

        countdownElement.querySelector('button').addEventListener('click', function () {
            clearInterval(interval);
            stopRedirectCountdown();
        });
    }

    function stopRedirectCountdown() {
        console.log('Redirect Countdown');
        if (redirectTimeout) {
            clearTimeout(redirectTimeout);
            redirectTimeout = null;
        }
        if (document.body.contains(countdownElement)) {
            document.body.removeChild(countdownElement);
        }
    }

    function createCountdownElement() {
        console.log('createCountdownElement');
        const element = document.createElement('div');
        element.style.position = 'fixed';
        element.style.bottom = '20px';
        element.style.right = '20px';
        element.style.backgroundColor = '#f0f0f0';
        element.style.padding = '10px';
        element.style.border = '1px solid #ccc';
        element.style.borderRadius = '5px';
        element.style.zIndex = '9999';
        element.innerHTML = `<span></span> <button>Anuluj</button>`;
        return element;
    }

    function updateNestedSwiperHeight() {
        const activeSlide = document.querySelector('.swiper-container .swiper-slide-active');
        if (!activeSlide) return;

        const nestedSwiperElement = activeSlide.querySelector('.sub-swiper');
        if (nestedSwiperElement) {
            const newHeight = activeSlide.clientHeight;
            nestedSwiperElement.style.height = `${newHeight}px`; // Ustawianie wysokości
            console.log(`Ustawiono wysokość nested Swipera na: ${newHeight}px`);
        }
    }


    swiper9.on('init', updateNestedSwiperHeight);
    swiper9.on('slideChangeTransitionEnd', updateNestedSwiperHeight);
    window.addEventListener('resize', updateNestedSwiperHeight);
});


// import Swiper from "swiper";
// import {HashNavigation, Navigation, Pagination, Zoom} from "swiper/modules";
//
// document.addEventListener('DOMContentLoaded', function () {
//
//     let isMobile = window.innerWidth <= 768;
//     let redirectTimeout; // Zmienna do przechowywania identyfikatora timeout
//     const countdownElement = createCountdownElement(); // Tworzymy element odliczania
//
//     // Sprawdź hash po załadowaniu strony i zmodyfikuj go, jeśli potrzeba
//     correctHashIfNeeded();
//
//     // Nasłuchujemy zmian hash
//     window.addEventListener('hashchange', function () {
//         console.log('hashchange');
//         correctHashIfNeeded();
//     });
//
//     // Inicjalizacja głównego slidera (swiper9)
//     const swiper9 = new Swiper('.swiper-container', {
//         speed:300,
//         modules: [Navigation, Pagination, Zoom, HashNavigation],
//         loop: false,
//         followFinger: true,
//         direction: 'horizontal',
//         zoom: {
//             maxRatio: 3,
//             scale: 3
//         },
//         pagination: {
//             el: '.swiper-pagination',
//             type: "fraction",
//         },
//         navigation: {
//             nextEl: '.swiper-button-next',
//             prevEl: '.swiper-button-prev',
//
//         },
//         hashNavigation: {
//             watchState: true, // Hash URL będzie aktualizowany w miarę zmiany slajdów
//         },
//         on: {
//             init: function () {
//                 // Ukryj preloader i pokaż slider
//                 document.getElementById('preloader').style.display = 'none';
//                 document.querySelector('.swiper-container').style.display = 'block';
//
//             },
//             zoomChange: function (swipe9, scale) {
//                 toggleClickableAreas(scale); // Obsługa widoczności klikalnych obszarów w zależności od stanu zoomu
//             }
//         }
//     });
//
//
//     let swiper10Instances = {}; // Zmienna przechowująca instancje nested sliderów
//
//     // Funkcja do inicjalizacji nested slidera dla danego slajdu
//     function initializeNestedSlider(slideIndex) {
//         console.log('Initializing nested slider for slide:', slideIndex); // Sprawdzenie inicjalizacji
//         const slide = swiper9.slides[slideIndex];
//         const nestedSwiperElement = slide.querySelector('.sub-swiper');
//
//
//             swiper10Instances[slideIndex] = new Swiper(nestedSwiperElement, {
//                 loop: false,
//                 followFinger: true,
//                 slidesPerView: 1,
//                 breakpoints: {
//                     769: {
//                         slidesPerView: 2
//                     }
//                 },
//                 direction: 'horizontal',
//                 nested: true,
//                 allowTouchMove: true,
//                 navigation: {
//                     nextEl: slide.querySelector('.sub-swiper-next'),
//                     prevEl: slide.querySelector('.sub-swiper-prev'),
//                 },
//             });
//
//     }
//
//
//
//     // Resetowanie zoomu i inicjalizacja/dezaktywacja nested slidera przy zmianie slajdów w swiper9
//     swiper9.on('slideChange', function () {
//         console.log('slideChange');
//         swiper9.zoom.out();  // Resetowanie zoomu
//
//         // Zatrzymaj obecne odliczanie, jeśli takie istnieje
//         stopRedirectCountdown();
//
//         if (swiper9.isEnd) {
//             console.log('Osiągnięto ostatni slajd, rozpoczynam odliczanie do przekierowania.');
//             startRedirectCountdown();
//         }
//
//         // Przy zmianie slajdu pokaż nested slider, jeśli był ukryty
//         const slides = swiper9.slides;
//         slides.forEach(slide => {
//             slide.classList.remove('swiper-slide-zoomed');  // Usuwanie klasy zoom
//             const nestedSwiperWrapper = slide.querySelector('.sub-swiper-wrapper');
//             if (nestedSwiperWrapper) {
//                 nestedSwiperWrapper.classList.remove('hidden');
//             }
//         });
//
//         const activeIndex = swiper9.activeIndex;
//         initializeNestedSlider(activeIndex);  // Inicjalizacja nested slidera
//
//
//     });
//
//
//     // Obsługa kliknięć na przyciskach nawigacji nested slidera
//     document.querySelectorAll('.sub-swiper-next, .sub-swiper-prev').forEach(button => {
//         button.addEventListener('click', function (evt) {
//             console.log('clicked');
//             evt.stopPropagation();  // Zatrzymanie propagacji
//
//         });
//     });
//
//     // Funkcja do korekty hash, jeśli jest liczbą parzystą
//     function correctHashIfNeeded() {
//         console.log('correctHashIfNeeded');
//         const hash = window.location.hash.replace('#', ''); // Pobieramy hash bez znaku #
//         if (hash && !isNaN(hash)) {
//             const pageIndex = parseInt(hash, 10); // Konwertujemy hash na liczbę całkowitą
//
//             // Jeżeli hash jest liczbą parzystą, zmień go na najbliższą liczbę nieparzystą
//             if (pageIndex % 2 === 0 && isMobile === false) {
//                 const correctedIndex = pageIndex + 1; // Ustawiamy na najbliższą nieparzystą liczbę
//                 window.location.hash = `#${correctedIndex}`; // Aktualizujemy hash w URL
//
//                 // Przejdź do odpowiedniego slajdu po korekcji hashu
//                 const targetIndex = Array.from(document.querySelectorAll('.swiper-slide'))
//                     .findIndex(slide => slide.dataset.hash === `slide-${correctedIndex}`);
//
//                 if (targetIndex !== -1) {
//                     swiper9.slideTo(targetIndex);
//                 }
//             } else {
//                 // Jeśli hash jest już nieparzysty, przejdź do odpowiedniego slajdu w Swiperze
//                 const targetIndex = Array.from(document.querySelectorAll('.swiper-slide'))
//                     .findIndex(slide => slide.dataset.hash === `slide-${hash}`);
//
//                 if (targetIndex !== -1) {
//                     swiper9.slideTo(targetIndex);
//                 }
//             }
//         }
//     }
//
//     // Funkcja do ukrywania klikalnych obszarów podczas zoomu
//     function toggleClickableAreas(scale) {
//         console.log('toggleClickableAreas');
//         const clickableAreas = document.querySelectorAll('.clickable');
//
//         if (scale > 1) {
//             clickableAreas.forEach(area => {
//                 area.style.display = 'none'; // Ukrywanie klikalnych obszarów
//             });
//         } else {
//             clickableAreas.forEach(area => {
//                 area.style.display = 'block'; // Przywracanie klikalnych obszarów
//             });
//         }
//     }
//
//
//     swiper9.on('reachEnd', function () {
//         console.log('Reach End');
//         startRedirectCountdown();
//     });
//
//     // Funkcja do rozpoczęcia odliczania przekierowania
//     function startRedirectCountdown() {
//         console.log('Redirect Countdown');
//         let countdown = 5; // 5 sekund odliczania
//         countdownElement.querySelector('span').textContent = `Przekierowanie za ${countdown} sekund...`;
//         document.body.appendChild(countdownElement);
//
//         // Aktualizuj odliczanie co sekundę
//         const interval = setInterval(() => {
//             countdown--;
//             if (countdown > 0) {
//                 countdownElement.querySelector('span').textContent = `Przekierowanie za ${countdown} sekund...`;
//             } else {
//                 clearInterval(interval);
//             }
//         }, 1000);
//
//         // Po 5 sekundach przekieruj do następnej strony (zmień URL na odpowiedni)
//         redirectTimeout = setTimeout(() => {
//             window.location.href = "https://example.com/nastepna-strona"; // Zmienny adres URL
//         }, 5000);
//
//         // Dodaj przycisk do anulowania
//         countdownElement.querySelector('button').addEventListener('click', function () {
//             clearInterval(interval);
//             stopRedirectCountdown();
//         });
//     }
//
//     // Funkcja do zatrzymania odliczania przekierowania
//     function stopRedirectCountdown() {
//         console.log('Redirect Countdown');
//         if (redirectTimeout) {
//             clearTimeout(redirectTimeout);
//             redirectTimeout = null;
//         }
//         if (document.body.contains(countdownElement)) {
//             document.body.removeChild(countdownElement);
//         }
//     }
//
//     // Funkcja tworząca element odliczania
//     function createCountdownElement() {
//         console.log('createCountdownElement');
//         const element = document.createElement('div');
//         element.style.position = 'fixed';
//         element.style.bottom = '20px';
//         element.style.right = '20px';
//         element.style.backgroundColor = '#f0f0f0';
//         element.style.padding = '10px';
//         element.style.border = '1px solid #ccc';
//         element.style.borderRadius = '5px';
//         element.style.zIndex = '9999';
//         element.innerHTML = `<span></span> <button>Anuluj</button>`;
//         return element;
//     }
// });
