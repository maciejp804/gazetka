import Swiper from "swiper";
import { Grid, Navigation, Pagination, Zoom, Autoplay, FreeMode} from "swiper/modules";

// Helper function to toggle navigation buttons
function toggleNavButtons(swiper, prevSelector, nextSelector) {
    const prevButton = document.querySelector(prevSelector);
    const nextButton = document.querySelector(nextSelector);

    // Sprawdzenie, czy przyciski istnieją
    if (!prevButton || !nextButton) {
        console.warn('One or both navigation buttons not found for', swiper);
        return;
    }

    // Sprawdzenie szerokości ekranu
    if (window.innerWidth <= 769) {
        // Na mniejszych ekranach przyciski są ukryte
        prevButton.style.display = 'none';
        nextButton.style.display = 'none';
        return; // Nie wykonuj dalszych działań
    }

    // Show both buttons by default
    prevButton.style.display = 'flex';
    nextButton.style.display = 'flex';

    // Hide the previous button if at the beginning
    if (swiper.isBeginning) {
        prevButton.style.display = 'none';
    }

    // Hide the next button if at the end
    if (swiper.isEnd) {
        nextButton.style.display = 'none';
    }
}

// Universal function to initialize Swiper instances with showing slider after loading
function initSwiper(selector, options, prevSelector, nextSelector) {
    const swiperElements = document.querySelectorAll(selector);

    swiperElements.forEach((swiperElement, index) => {
        // Unikalne selektory nawigacyjne dla każdej instancji
        const instancePrevSelector = `${prevSelector}-${index + 1}`;
        const instanceNextSelector = `${nextSelector}-${index + 1}`;

        const swiper = new Swiper(swiperElement, {
            ...options,
            navigation: {
                nextEl: instanceNextSelector,
                prevEl: instancePrevSelector,
            },
            on: {
                init: function () {
                    // Pobieranie przycisków nawigacyjnych
                    const prevButton = document.querySelector(instancePrevSelector);
                    const nextButton = document.querySelector(instanceNextSelector);

                    // Sprawdzenie, czy przyciski istnieją, zanim wykonamy operacje na `classList`
                    if (prevButton && nextButton) {
                        // Sprawdzenie, czy ekran jest wystarczająco duży, aby pokazać przyciski
                        if (window.innerWidth >= 768) {
                            prevButton.classList.remove('hidden');
                            nextButton.classList.remove('hidden');
                        }
                    }

                    // Wywołanie toggleNavButtons dla przycisków nawigacyjnych
                    toggleNavButtons(this, instancePrevSelector, instanceNextSelector);
                },
                slideChange: function () {
                    toggleNavButtons(this, instancePrevSelector, instanceNextSelector);
                },
            }
        });

        // Funkcja do ponownej kontroli widoczności przycisków przy zmianie rozmiaru okna
        window.addEventListener('resize', () => {
            const prevButton = document.querySelector(instancePrevSelector);
            const nextButton = document.querySelector(instanceNextSelector);

            if (prevButton && nextButton) {
                if (window.innerWidth < 768) {
                    prevButton.classList.add('hidden');
                    nextButton.classList.add('hidden');
                } else {
                    prevButton.classList.remove('hidden');
                    nextButton.classList.remove('hidden');
                }
            }
        });
    });
}

window.addEventListener('load', function () {

    // Leaflet Promo Swiper
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
    }, '.button-prev-swiper', '.button-next-swiper');

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
    }, '.button-prev-swiper', '.button-next-swiper');

    // Category swiper
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
    }, '.swiper-button-prev', '.swiper-button-next');

    // Category swiper
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

    // Universal swiper
    initSwiper('.mySwiper', {
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
    }, '.button-prev', '.button-next');

    // Universal swiper
    initSwiper('.leaflet', {
        modules: [Navigation, Pagination, Grid],
        slidesPerView: 2,
        spaceBetween: 5,
        grid: { rows : 2, fill: 'row'},
        breakpoints: {
            320: { slidesPerView: 2, spaceBetween: 25, grid: { rows : 2, fill: 'row'}},
            425: { slidesPerView: 2, spaceBetween: 25, grid: { rows : 2, fill: 'row'}},
            475: { slidesPerView: 3, spaceBetween: 5, grid: { rows : 2, fill: 'row'}},
            640: { slidesPerView: 3, spaceBetween: 5, grid: { rows : 2, fill: 'row'}},
            768: { slidesPerView: 4, spaceBetween: 5, grid: { rows : 2, fill: 'row'}},
            1024: { slidesPerView: 5, spaceBetween: 5, grid: { rows : 3, fill: 'row'}, navigation: { enabled: false}},
            1440: { slidesPerView: 5, spaceBetween: 15, grid: { rows : 3, fill: 'row'}, navigation: { enabled: false}},
        },
        pagination: { el: ".swiper-pagination", dynamicBullets: true, clickable: true}
    }, '.button-prev-swiper', '.button-next-swiper');

    // Blog swiper
    initSwiper('.swiper-info', {
        modules: [Navigation, Autoplay],
        slidesPerView: 5,
        spaceBetween: 5,
        loop: true,
        autoplay: true,
        breakpoints: {
            320: { slidesPerView: 2, spaceBetween: 5},
            425:{ slidesPerView: 2, spaceBetween: 10},
            475: { slidesPerView: 2, spaceBetween: 10},
            640: { slidesPerView: 4, spaceBetween: 10},
            1024: { slidesPerView: 5, spaceBetween: 15, loop:false},
        },
        pagination: { el: ".swiper-pagination", dynamicBullets: true, clickable: true}
    }, '.swiper-button-prev', '.swiper-button-next');

    initSwiper('.swiper-blog', {
        modules: [Navigation, Pagination, Autoplay, Grid],
        slidesPerView: 1,
        spaceBetween: 5,
        loop: true,
        autoplay: false,
        grid: { rows : 2, fill: 'row'},
        breakpoints: {
            320: { slidesPerView: 1, spaceBetween: 5},
            425:{ slidesPerView: 2, spaceBetween: 10},
            475: { slidesPerView: 2, spaceBetween: 10},
            640: { slidesPerView: 3, spaceBetween: 10, grid: { rows : 1}},
            768: { slidesPerView: 4, spaceBetween: 10, grid: { rows : 1}},
            1024: { slidesPerView: 4, spaceBetween: 15, grid: { rows : 1}, navigation: { enabled: false}},
            1060: { slidesPerView: 5, spaceBetween: 15, grid: { rows : 1}, navigation: { enabled: false}},
        },
        pagination: { el: ".swiper-pagination", dynamicBullets: true, clickable: true}
    }, '.button-prev-swiper', '.button-next-swiper');



});

document.addEventListener('DOMContentLoaded', () => {
    // Symulujemy ładowanie danych – po 1 sekundzie zamieniamy skeleton na slider
    setTimeout(() => {
        document.getElementById('skeleton-slider').classList.add('hidden');
        document.getElementById('actual-slider').classList.remove('!hidden');

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
});


/* Swiper sieci handlowych na stronie sieci handlowych  */
const swiper5 = new Swiper('.retailers-swiper', {
    // configure Swiper to use modules
    modules: [Navigation, Pagination, Grid],
    slidesPerView: 2,
    spaceBetween: 5,
    grid: {
        rows : 2,
        fill: 'row',

    },
    breakpoints: {
        // when window width is >= 320px
        320: {
            slidesPerView: 2,
            spaceBetween: 10,
            grid: {
                rows : 3,
                fill: 'row',

            },

        },
        375: {
            slidesPerView: 2,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        425: {
            slidesPerView: 2,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        475: {
            slidesPerView: 3,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 15,
            grid: {
                rows : 3,
            }
        },
        1440: {
            slidesPerView: 5,
            spaceBetween: 15,
            grid: {
                rows : 4,
            }
        },

    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});


/* Swiper gazetek promocyjnych na stronie gazetki-promocyjne  */
const swiper6 = new Swiper('.leaflets-swiper', {
    // configure Swiper to use modules
    modules: [Navigation, Pagination, Grid],
    slidesPerView: 2,
    spaceBetween: 5,
    grid: {
        rows : 2,
        fill: 'row',
    },
    breakpoints: {
        // when window width is >= 320px
        320: {
            slidesPerView: 2,
            spaceBetween: 10,
            grid: {
                rows : 3
            },

        },
        375: {
            slidesPerView: 2,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        425: {
            slidesPerView: 2,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        475: {
            slidesPerView: 3,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 15,
            grid: {
                rows : 3,
            }
        },
        1440: {
            slidesPerView: 5,
            spaceBetween: 15,
            grid: {
                rows : 4,
            }
        },

    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});


/* Swiper kuponów na stronie kuponów  */
const swiper7 = new Swiper('.vouchers-swiper', {
    // configure Swiper to use modules
    modules: [Navigation, Pagination, Grid],
    slidesPerView: 2,
    spaceBetween: 5,
    grid: {
        rows : 2,
        fill: 'row',
    },
    breakpoints: {
        // when window width is >= 320px
        320: {
            slidesPerView: 2,
            spaceBetween: 10,
            grid: {
                rows : 3
            },

        },
        375: {
            slidesPerView: 2,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        425: {
            slidesPerView: 2,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        475: {
            slidesPerView: 3,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 10,
            grid: {
                rows : 3,
            }
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 15,
            grid: {
                rows : 3,
            }
        },
        1440: {
            slidesPerView: 3,
            spaceBetween: 35,
            grid: {
                rows : 4,
            }
        },

    },
    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

/* Swiper kuponów na stronie kuponów  */
const swiper8 = new Swiper('.vouchers-swiper-promo', {
    // configure Swiper to use modules
    modules: [Navigation, Pagination, Grid],
    slidesPerView: 2,
    spaceBetween: 5,
    grid: {
        rows : 2,
        fill: 'row',
    },
    breakpoints: {
        // when window width is >= 320px
        320: {
            slidesPerView: 1,
            spaceBetween: 10,
            grid: {
                rows : 2
            },

        },
        375: {
            slidesPerView: 1,
            spaceBetween: 20,
            grid: {
                rows : 2,
            }
        },
        425: {
            slidesPerView: 1,
            spaceBetween: 30,
            grid: {
                rows : 2,
            }
        },
        475: {
            slidesPerView: 2,
            spaceBetween: 10,
            grid: {
                rows : 2,
            }
        },
        640: {
            slidesPerView: 2,
            spaceBetween: 30,
            grid: {
                rows : 2,
            }
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 20,
            grid: {
                rows : 2,
            }
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 15,
            grid: {
                rows : 1,
            }
        },
        1440: {
            slidesPerView: 3,
            spaceBetween: 20,
            grid: {
                rows : 1,
            }
        },

    },
    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});




