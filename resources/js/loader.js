import {
    initLeafletSwiper,
    initLeafletPromoSwiper,
    initCategorySwiper,
    initCategorySwiperSmall,
    initSwiperInfo,
    initSwiperBlog,
    initSwiperLeafletSingle,
    initSwiperCategoryBlog, initSwiperVoucherPromo, initShopsSwiper, initProductSwiper, initSwiperLeafletSingleOther
} from "./swiper/instances";

import {debounce, restoreInputStyle} from "./filter/helpers";
import {
    handleQuadrupleSearch,
    handleSingleDropdownSearch,
    handleTripleSearch,
    handleTripleSwiperSearch
} from "./filter/search-helpers";


document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ DOM załadowany, inicjalizuję Swipery...");

    initLeafletPromoSwiper();
    initLeafletSwiper();
    initSwiperInfo();
    initShopsSwiper();
    initProductSwiper();
    initCategorySwiper();
    initCategorySwiperSmall();
    initSwiperBlog();
    initSwiperLeafletSingle();
    initSwiperLeafletSingleOther();
    initSwiperCategoryBlog();
    initSwiperVoucherPromo();

    console.log("✅ Wszystkie Swipery zostały zainicjalizowane.");


    const filterBoxes = document.querySelectorAll('.filter-box');

    filterBoxes.forEach(filterBox => {
        const input = filterBox.querySelector('.search-input');
        const dropdownUrl = filterBox.querySelector('.dropdown-url');
        const dropdownValue = dropdownUrl ? dropdownUrl.getAttribute('data-dropdown') : null;
        const resultsBoxId = input.getAttribute('data-results-box-id');
        const resultsBox = document.getElementById(resultsBoxId);
        const swiperSmall = filterBox.querySelector('.swiper-category-small');

        const searchType = input.getAttribute('data-search-type');
        const containerId = input.getAttribute('data-container-id');
        const swiperBig = filterBox.querySelector('.leaflet');
        console.log(containerId); // Sprawdź, czy containerId ma wartość

        const swiperInstance = containerId && document.querySelector(`#${containerId}`)
            ? document.querySelector(`#${containerId}`).swiper
            : null;

        console.log(swiperInstance); // Sprawdź, czy containerId ma wartość

        const clearButton = input.parentElement.querySelector('.clear-button');

        const categorySelect = filterBox.querySelector('#category-select');
        const timeSelect = filterBox.querySelector('#time-select');
        const typeSelect = filterBox.querySelector('#type-select');
        const subcategorySelect = swiperSmall ? swiperSmall.getAttribute('data-subcategory') : null;


        let type, time;
        if (typeSelect){
            type = typeSelect.value ? typeSelect.value : null;
        } else {
            type = null;
        }

        if (timeSelect){
            time = timeSelect.value ? timeSelect.value : null;
        } else {
            time = null;
        }



        console.log(dropdownValue,subcategorySelect, type, time);

        // Funkcja do wywołania wyszukiwania
        function performSearch() {
            const query = input.value.trim();

            let selectCategory = '';
            if(categorySelect !== null)
            {
                selectCategory = categorySelect.value ? categorySelect.value : 'all';
            } else if(dropdownValue !== null)
            {
                selectCategory = dropdownValue;
            }

            let timeCategory = '';
            if(timeSelect !== null)
            {
                timeCategory = timeSelect.value ? timeSelect.value : 'all';
            }

            let typeCategory = '';
            if(typeSelect !== null)
            {
                typeCategory = typeSelect.value ? typeSelect.value : 'all';
            }

            let typeSubCategory = '';
            if(subcategorySelect !== null)
            {
                typeSubCategory = subcategorySelect ? subcategorySelect : 'all';
            }


            clearButton.classList.toggle('hidden', query.length === 0);

            const  minLength = searchType === 'leaflets' ? 1 : 2;

            if (query.length >= minLength) {
                switch (searchType){
                    case 'places':
                    case 'products-retailers':
                        handleSingleDropdownSearch(query, searchType, resultsBox, input);
                        break;

                    case 'leaflets':
                        if(swiperInstance){
                            handleTripleSwiperSearch(query, searchType, selectCategory, timeCategory, resultsBox, input, swiperInstance);
                        } else {
                            handleTripleSearch(query, searchType, selectCategory, timeCategory, resultsBox, input, containerId, typeSubCategory);
                        }
                        break;

                    case 'retailers':
                    case 'products':
                        handleTripleSearch(query, searchType, selectCategory, timeCategory, resultsBox, input, containerId, typeSubCategory);
                        break;

                    case 'vouchers':
                        handleQuadrupleSearch(query, searchType, selectCategory, typeCategory, timeCategory, resultsBox, input, containerId);
                        break;
                }

            } else if (query.length === 0) {
                switch (searchType){
                    case 'places':
                    case 'products-retailers':
                        resultsBox.innerHTML = '';
                        restoreInputStyle(input, resultsBox);
                        resultsBox.classList.add('hidden');
                        break;

                    case 'leaflets':
                        if(swiperInstance){
                            handleTripleSwiperSearch('', searchType, selectCategory, timeCategory, resultsBox, input, swiperInstance);
                        } else {
                            handleTripleSearch('', searchType, selectCategory, timeCategory, resultsBox, input, containerId, typeSubCategory);
                        }
                        break;

                    case 'retailers':
                    case 'products':

                        handleTripleSearch(query, searchType, selectCategory, timeCategory, resultsBox, input, containerId, typeSubCategory);
                        break;

                    case 'vouchers':
                        handleQuadrupleSearch(query, searchType, selectCategory, typeCategory, timeCategory, resultsBox, input, containerId);
                        break;

                }

            }
        }

        // Nasłuchuj na input, kategoriach i czasie
        if (input) {
            input.addEventListener('input', debounce(performSearch, 300));
        }

        if (categorySelect) {
            categorySelect.addEventListener('change', performSearch);
        }

        if (timeSelect) {
            timeSelect.addEventListener('change', performSearch);
        }

        if (typeSelect) {
            typeSelect.addEventListener('change', performSearch);
        }

        if (clearButton) {
            clearButton.addEventListener('click', function () {
                if (input) {
                    input.value = '';
                }
                clearButton.classList.add('hidden');
                performSearch();
            });
        }

        document.addEventListener('mousedown', function (event) {
            if (!input.contains(event.target) && !resultsBox.contains(event.target)) {
                resultsBox.innerHTML = '';
                restoreInputStyle(input, resultsBox, true);
            }
        });
    });





    const flashMessage = document.getElementById('flash-message');
    if (flashMessage) {
        flashMessage.classList.add('transition', 'duration-3000', 'ease-out', 'opacity-0');
        // Ukryj komunikat po 5 sekundach:
        setTimeout(() => {
            flashMessage.remove(); // Usuwa <div> z DOM
        }, 2500);
    }

});
