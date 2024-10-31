import Swiper from "swiper";
import {
    Grid,
    HashNavigation,
    Keyboard,
    Navigation,
    Pagination,
    Scrollbar,
    Zoom,
    Autoplay,
    FreeMode
} from "swiper/modules";


function initializeSwipers1() {
    // Pobierz wszystkie elementy Swipera na stronie
    const swipers = document.querySelectorAll('.mySwiper');

    swipers.forEach((swiperElement, index) => {
        // Unikalne identyfikatory nawigacji na podstawie indeksu lub atrybutu
        const nextButton = document.querySelector(`.button-next-${index + 1}`);
        const prevButton = document.querySelector(`.button-prev-${index + 1}`);
        const pagination = swiperElement.querySelector('.swiper-pagination');

        // Inicjalizacja Swipera dla każdej instancji
        new Swiper(swiperElement, {
            modules: [Navigation, Pagination, Grid],
            slidesPerView: 2,
            spaceBetween: 5,
            grid: {
                rows: 2,
                fill: 'row',
            },
            breakpoints: {
                320: { slidesPerView: 2, spaceBetween: 5 },
                375: { slidesPerView: 2, spaceBetween: 5 },
                425: { slidesPerView: 2, spaceBetween: 25 },
                475: { slidesPerView: 3, spaceBetween: 10 },
                640: { slidesPerView: 3, spaceBetween: 5 },
                768: { slidesPerView: 4, spaceBetween: 5, grid: { rows: 1 } },
                1024: { slidesPerView: 5, spaceBetween: 5, grid: { rows: 1 } },
                1440: { slidesPerView: 5, spaceBetween: 15, grid: { rows: 1 } }
            },
            pagination: {
                el: pagination,
                clickable: true,
            },
            navigation: {
                nextEl: nextButton,
                prevEl: prevButton,
            }
        });
        console.log('wykonuje się');
    });
}

// Wywołaj funkcję, gdy strona się załaduje
document.addEventListener('DOMContentLoaded', initializeSwipers1);

const swiper2 = new Swiper('.leafletPromo', {
    // configure Swiper to use modules
    modules: [Navigation, Pagination, Grid, Zoom],
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
            spaceBetween: 25,
            grid: {
                rows : 2,
                fill: 'row',

            },

        },
        425: {
            spaceBetween: 25,
            },
        475: {
            slidesPerView: 3,
            spaceBetween: 5,
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 5,
            grid: {
                rows : 2,
            }
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 5,
            grid: {
                rows : 1,
            }
        },
        1024: {
            slidesPerView: 5,
            spaceBetween: 5,
            grid: {
                rows : 1,
            }
        },
        1440: {
            slidesPerView: 5,
            spaceBetween: 15,
            grid: {
                rows : 1,
            }
        },

    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: '.button-next-swiper',
        prevEl: '.button-prev-swiper',
    },
    on: {
        init: function() {
            // Hide previous button at the start
            toggleNavButtons(this, '.button-prev-swiper', '.button-next-swiper');
        },
        slideChange: function() {
            // Toggle visibility of buttons after each slide change
            toggleNavButtons(this, '.button-prev-swiper', '.button-next-swiper');
        },
        reachBeginning: function() {
            // Hide the previous button at the start
            document.querySelector('.button-prev-swiper').style.display = 'none';
        },
        reachEnd: function() {
            // Hide the next button at the end
            document.querySelector('.button-next-swiper').style.display = 'none';
        }
    }
});

const swiper3 = new Swiper('.category-swiper', {
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
            spaceBetween: 5,
            grid: {
                rows : 2,
                fill: 'row',

            },

        },
        375: {
            slidesPerView: 3,
            spaceBetween: 5,
            grid: {
                rows : 2,
            }
        },
        425: {
            slidesPerView: 3,
            spaceBetween: 10,
            grid: {
                rows : 1,
            }
        },
        475: {
            slidesPerView: 4,
            spaceBetween: 5,
        },
        640: {
            slidesPerView: 5,
            spaceBetween: 5
        },
        768: {
            slidesPerView: 5,
            spaceBetween: 5
        },
        1024: {
            slidesPerView: 7,
            spaceBetween: 18,
            grid: {
                rows : 1,
            }
        },
        1440: {
            slidesPerView: 7,
            spaceBetween: 25,
            grid: {
                rows : 1,
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

const swiper4 = new Swiper('.leaflet', {
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
            spaceBetween: 25,
            grid: {
                rows : 2,
                fill: 'row',

            },

        },
        425: {
            spaceBetween: 25,
        },
        475: {
            slidesPerView: 3,
            spaceBetween: 5,
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 5,
            grid: {
                rows : 2,
            }
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 5,
            grid: {
                rows : 1,
            }
        },
        1024: {
            slidesPerView: 5,
            spaceBetween: 5,
            grid: {
                rows : 3,
            },
            navigation: {
                enabled: false,
            },
        },
        1440: {
            slidesPerView: 5,
            spaceBetween: 15,
            grid: {
                rows : 3,
            },
            navigation: {
                enabled: false,
            },
        },

    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next hidden',
        prevEl: '.swiper-button-prev hidden',
    },
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

const swiper11 = new Swiper('.swiperCategory', {
    // configure Swiper to use modules
    modules: [Navigation, FreeMode],
    slidesPerView: "auto",
    spaceBetween: 5,
    freeMode: true,
    breakpoints: {
        // when window width is >= 320px
        320: {
            spaceBetween: 5,
        },
        425: {
            spaceBetween: 10,
        },
        475: {
            spaceBetween: 10,
        },
        1440: {
            spaceBetween: 15,
        }
    },
    navigation: {
        nextEl: ".button-next",
        prevEl: ".button-prev",
    },
    on: {
        init: function() {
            // Hide previous button at the start
            toggleNavButtons(this, ".button-prev", ".button-next");
        },
        slideChange: function() {
            // Toggle visibility of buttons after each slide change
            toggleNavButtons(this, ".button-prev", ".button-next");
        },
        reachBeginning: function() {
            // Hide the previous button at the start
            document.querySelector('.button-prev').style.display = 'none';
        },
        reachEnd: function() {
            // Hide the next button at the end
            document.querySelector('.button-next').style.display = 'none';
        }
    }
});

const swiperInfo = new Swiper('.swiper-info', {
    // configure Swiper to use modules
    modules: [Navigation, Autoplay],
    slidesPerView: 5,
    spaceBetween: 5,
    loop: true,
    autoplay: true,
    breakpoints: {
        // when window width is >= 320px
        320: {
            slidesPerView: 2,
            spaceBetween: 5,
        },
        425: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        475: {
            spaceBetween: 10,
        },
        640: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1024: {
            spaceBetween: 15,
            slidesPerView: 5,
            loop: false ,
        }
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    }
});

const swiperBlog = new Swiper('.swiper-blog', {
    // configure Swiper to use modules
    modules: [Navigation, Autoplay],
    slidesPerView: 2,
    spaceBetween: 5,
    loop: true,
    autoplay: true,
    breakpoints: {
        // when window width is >= 425px
        425: {
            slidesPerView: 2,
            spaceBetween: 10,
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 10,
        },
        1024:{
            slidesPerView: 4,
            spaceBetween: 15,
        },
        1060: {
            slidesPerView: 5,
            spaceBetween: 15,
            loop: false,

        }
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    }
});

// Helper function to toggle navigation buttons
function toggleNavButtons(swiper, prevSelector, nextSelector) {
    const prevButton = document.querySelector(prevSelector);
    const nextButton = document.querySelector(nextSelector);

    if (!prevButton || !nextButton) {
        console.warn('One or both navigation buttons not found for', swiper);
        return;
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



