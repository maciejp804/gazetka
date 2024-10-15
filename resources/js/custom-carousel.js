const trendingLeaflets = {
    loop: false,
    rewind: true,
    margin: 30,
    nav: true,
    navText: ['<i class="fa-solid fa fa-angle-left"></i>', '<i class="fa-solid fa-angle-right"></i>'],
    dots: true,
    responsive: {
        0: {
            items: 1,
            margin: 10,
            nav: false,
            dotsEach: 3,
        },
        375: {
            items: 2,
            margin: 5,
            nav: false,
        },
        425: {
            items: 2,
            margin: 5,
            nav: false,
        },
        768: {
            items: 3,
            margin: 9,
        },
        1000: {
            items: 4
        },
        1300: {
            items: 5,
            margin: 18,
        },
    }
}

const infoCarousel = {
    loop: false,
    rewind: true,
    margin: 30,
    nav: true,
    navText: ['<i class="fa-solid fa fa-angle-left"></i>', '<i class="fa-solid fa-angle-right"></i>'],
    dots: true,
    responsive: {
        0: {
            items: 2,
            margin: 10,
            nav: false,

        },
        375: {
            items: 2,
            margin: 5,
            nav: false,
        },
        425: {
            items: 3,
            margin: 5,
            nav: false,
        },
        768: {
            items: 3,
            margin: 9,
        },
        1000: {
            items: 4
        },
        1300: {
            items: 5,
            margin: 18,
        },
    }
}

const couponsCarousel = {
    loop: false,
    rewind: true,
    margin: 30,
    nav: true,
    navText: ['<i class="fa-solid fa fa-angle-left"></i>', '<i class="fa-solid fa-angle-right"></i>'],
    dots: true,
    responsive: {
        0: {
            items: 1,
            margin: 10,
            nav: false,

        },
        375: {
            items: 1,
            margin: 5,
            nav: false,
        },
        425: {
            items: 1,
            margin: 5,
            nav: false,
        },
        768: {
            items: 3,
            margin: 9,
        },
        1000: {
            items: 3
        },
        1300: {
            items: 3,
            margin: 18,
        },
    }
}


$(document).ready(function () {
    $('.trending-leaflets').owlCarousel(trendingLeaflets);
    $('.info-carousel').owlCarousel(infoCarousel);
    $('.trending-coupons').owlCarousel(couponsCarousel);

});


