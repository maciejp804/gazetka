import Swiper from "swiper";
import {HashNavigation, Navigation, Pagination, Zoom} from "swiper/modules";

document.addEventListener('DOMContentLoaded', function () {
    let isMobile = window.innerWidth <= 768;
    let redirectTimeout; // Zmienna do przechowywania identyfikatora timeout
    const countdownElement = createCountdownElement(); // Tworzymy element odliczania

    // Sprawdź hash po załadowaniu strony i zmodyfikuj go, jeśli potrzeba
    correctHashIfNeeded();

    // Nasłuchujemy zmian hash
    window.addEventListener('hashchange', function () {
        correctHashIfNeeded();
    });

    // Inicjalizacja głównego slidera (swiper9)
    const swiper9 = new Swiper('.swiper-container', {
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
            watchState: true, // Hash URL będzie aktualizowany w miarę zmiany slajdów
        },
        on: {
            init: function () {
                // Ukryj preloader i pokaż slider
                document.getElementById('preloader').style.display = 'none';
                document.querySelector('.swiper-container').style.display = 'block';

            },
            zoomChange: function (swipe9, scale) {
                toggleClickableAreas(scale); // Obsługa widoczności klikalnych obszarów w zależności od stanu zoomu
            }
        }
    });


    let swiper10Instances = {}; // Zmienna przechowująca instancje nested sliderów

    // Funkcja do inicjalizacji nested slidera dla danego slajdu
    function initializeNestedSlider(slideIndex) {

        const slide = swiper9.slides[slideIndex];
        const nestedSwiperElement = slide.querySelector('.sub-swiper');

        if (nestedSwiperElement && !swiper10Instances[slideIndex]) {
            swiper10Instances[slideIndex] = new Swiper(nestedSwiperElement, {
                loop: false,
                followFinger: true,
                slidesPerView: 1,
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
        }
    }


    // Resetowanie zoomu i inicjalizacja/dezaktywacja nested slidera przy zmianie slajdów w swiper9
    swiper9.on('slideChange', function () {
        swiper9.zoom.out();  // Resetowanie zoomu

        // Zatrzymaj obecne odliczanie, jeśli takie istnieje
        stopRedirectCountdown();

        if (swiper9.isEnd) {
            console.log('Osiągnięto ostatni slajd, rozpoczynam odliczanie do przekierowania.');
            startRedirectCountdown();
        }

        // Przy zmianie slajdu pokaż nested slider, jeśli był ukryty
        const slides = swiper9.slides;
        slides.forEach(slide => {
            slide.classList.remove('swiper-slide-zoomed');  // Usuwanie klasy zoom
            const nestedSwiperWrapper = slide.querySelector('.sub-swiper-wrapper');
            if (nestedSwiperWrapper) {
                nestedSwiperWrapper.classList.remove('hidden');
            }
        });

        const activeIndex = swiper9.activeIndex;
        initializeNestedSlider(activeIndex);  // Inicjalizacja nested slidera


    });


    // Obsługa kliknięć na przyciskach nawigacji nested slidera
    document.querySelectorAll('.sub-swiper-next, .sub-swiper-prev').forEach(button => {
        button.addEventListener('click', function (evt) {
            evt.stopPropagation();  // Zatrzymanie propagacji
        });
    });

    // Funkcja do korekty hash, jeśli jest liczbą parzystą
    function correctHashIfNeeded() {
        const hash = window.location.hash.replace('#', ''); // Pobieramy hash bez znaku #
        if (hash && !isNaN(hash)) {
            const pageIndex = parseInt(hash, 10); // Konwertujemy hash na liczbę całkowitą

            // Jeżeli hash jest liczbą parzystą, zmień go na najbliższą liczbę nieparzystą
            if (pageIndex % 2 === 0 && isMobile === false) {
                const correctedIndex = pageIndex + 1; // Ustawiamy na najbliższą nieparzystą liczbę
                window.location.hash = `#${correctedIndex}`; // Aktualizujemy hash w URL

                // Przejdź do odpowiedniego slajdu po korekcji hashu
                const targetIndex = Array.from(document.querySelectorAll('.swiper-slide'))
                    .findIndex(slide => slide.dataset.hash === `slide-${correctedIndex}`);

                if (targetIndex !== -1) {
                    swiper9.slideTo(targetIndex);
                }
            } else {
                // Jeśli hash jest już nieparzysty, przejdź do odpowiedniego slajdu w Swiperze
                const targetIndex = Array.from(document.querySelectorAll('.swiper-slide'))
                    .findIndex(slide => slide.dataset.hash === `slide-${hash}`);

                if (targetIndex !== -1) {
                    swiper9.slideTo(targetIndex);
                }
            }
        }
    }

    // Funkcja do ukrywania klikalnych obszarów podczas zoomu
    function toggleClickableAreas(scale) {
        const clickableAreas = document.querySelectorAll('.clickable');

        if (scale > 1) {
            clickableAreas.forEach(area => {
                area.style.display = 'none'; // Ukrywanie klikalnych obszarów
            });
        } else {
            clickableAreas.forEach(area => {
                area.style.display = 'block'; // Przywracanie klikalnych obszarów
            });
        }
    }


    swiper9.on('reachEnd', function () {
        startRedirectCountdown();
    });

    // Funkcja do rozpoczęcia odliczania przekierowania
    function startRedirectCountdown() {
        let countdown = 5; // 5 sekund odliczania
        countdownElement.querySelector('span').textContent = `Przekierowanie za ${countdown} sekund...`;
        document.body.appendChild(countdownElement);

        // Aktualizuj odliczanie co sekundę
        const interval = setInterval(() => {
            countdown--;
            if (countdown > 0) {
                countdownElement.querySelector('span').textContent = `Przekierowanie za ${countdown} sekund...`;
            } else {
                clearInterval(interval);
            }
        }, 1000);

        // Po 5 sekundach przekieruj do następnej strony (zmień URL na odpowiedni)
        redirectTimeout = setTimeout(() => {
            window.location.href = "https://example.com/nastepna-strona"; // Zmienny adres URL
        }, 5000);

        // Dodaj przycisk do anulowania
        countdownElement.querySelector('button').addEventListener('click', function () {
            clearInterval(interval);
            stopRedirectCountdown();
        });
    }

    // Funkcja do zatrzymania odliczania przekierowania
    function stopRedirectCountdown() {
        if (redirectTimeout) {
            clearTimeout(redirectTimeout);
            redirectTimeout = null;
        }
        if (document.body.contains(countdownElement)) {
            document.body.removeChild(countdownElement);
        }
    }

    // Funkcja tworząca element odliczania
    function createCountdownElement() {
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
});


// document.addEventListener('DOMContentLoaded', function () {
//     let isMobile = window.innerWidth <= 768;
//     let redirectTimeout; // Zmienna do przechowywania identyfikatora timeout
//     const countdownElement = createCountdownElement(); // Tworzymy element odliczania
//
//     // Sprawdź hash po załadowaniu strony i zmodyfikuj go, jeśli potrzeba
//     correctHashIfNeeded();
//
//     // Nasłuchujemy zmian hash
//     window.addEventListener('hashchange', function () {
//         correctHashIfNeeded();
//     });
//
//     // Inicjalizacja głównego slidera (swiper9)
//     const swiper9 = new Swiper('.swiper-container', {
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
//         },
//         hashNavigation: {
//             watchState: true, // Hash URL będzie aktualizowany w miarę zmiany slajdów
//         },
//         on: {
//             init: function () {
//                 // Ukryj preloader i pokaż slider
//                 document.getElementById('preloader').style.display = 'none';
//                 document.querySelector('.swiper-container').style.display = 'block';
//             },
//             zoomChange: function (swipe9, scale) {
//                 toggleClickableAreas(scale); // Obsługa widoczności klikalnych obszarów w zależności od stanu zoomu
//             },
//             slideChange: function () {
//                 // Sprawdź, czy aktywny slajd zawiera zagnieżdżony slider
//                 handleNestedSliderNavigation();
//             }
//         }
//     });
//
//     let swiper10Instances = {}; // Zmienna przechowująca instancje nested sliderów
//
//     // Funkcja do inicjalizacji zagnieżdżonego slidera dla danego slajdu
//     function initializeNestedSlider(slideIndex) {
//         const slide = swiper9.slides[slideIndex];
//         const nestedSwiperElement = slide.querySelector('.sub-swiper');
//
//         if (nestedSwiperElement && !swiper10Instances[slideIndex]) {
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
//         }
//     }
//
//     // Funkcja do przełączania kontroli przycisków nawigacji
//     function handleNestedSliderNavigation() {
//         const activeIndex = swiper9.activeIndex;
//         const activeSlide = swiper9.slides[activeIndex];
//         const nestedSwiperElement = activeSlide.querySelector('.sub-swiper');
//
//         // Przywracanie nawigacji dla głównego slidera
//         swiper9.params.navigation.nextEl = '.swiper-button-next';
//         swiper9.params.navigation.prevEl = '.swiper-button-prev';
//         swiper9.navigation.update();
//
//         if (nestedSwiperElement) {
//             initializeNestedSlider(activeIndex); // Inicjalizacja zagnieżdżonego slidera, jeśli jeszcze nie istnieje
//
//             const nestedSwiperInstance = swiper10Instances[activeIndex];
//             if (nestedSwiperInstance) {
//                 // Przełączenie kontroli nawigacji na zagnieżdżony slider
//                 swiper9.params.navigation.nextEl = activeSlide.querySelector('.sub-swiper-next');
//                 swiper9.params.navigation.prevEl = activeSlide.querySelector('.sub-swiper-prev');
//                 swiper9.navigation.update();
//
//                 // Zaktualizowanie nawigacji, aby przyciski sterowały zagnieżdżonym sliderem
//                 const nextButton = activeSlide.querySelector('.sub-swiper-next');
//                 const prevButton = activeSlide.querySelector('.sub-swiper-prev');
//
//                 if (nextButton && prevButton) {
//                     nextButton.addEventListener('click', function (e) {
//                         e.stopPropagation();
//                         nestedSwiperInstance.slideNext();
//                     });
//
//                     prevButton.addEventListener('click', function (e) {
//                         e.stopPropagation();
//                         nestedSwiperInstance.slidePrev();
//                     });
//                 }
//             }
//         }
//     }
//
//     // Inicjalizacja sliderów zagnieżdżonych
//     swiper9.on('slideChange', function () {
//         swiper9.zoom.out();  // Resetowanie zoomu
//
//         // Przy zmianie slajdu pokaż zagnieżdżony slider, jeśli był ukryty
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
//     });
//
//     // Obsługa kliknięć na przyciskach nawigacji zagnieżdżonego slidera
//     document.querySelectorAll('.sub-swiper-next, .sub-swiper-prev').forEach(button => {
//         button.addEventListener('click', function (evt) {
//             evt.stopPropagation();  // Zatrzymanie propagacji
//         });
//     });
//
//     // Funkcja do korekty hash, jeśli jest liczbą parzystą
//     function correctHashIfNeeded() {
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
//         startRedirectCountdown();
//     });
//
//     // Funkcja do rozpoczęcia odliczania przekierowania
//     function startRedirectCountdown() {
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
