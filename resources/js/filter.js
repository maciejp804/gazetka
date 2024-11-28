function debounce(func, delay) {
    let debounceTimer;
    return function () {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    };
}

function toggleInputStyle(input, isResultsVisible) {
    input.classList.toggle('rounded-3xl', !isResultsVisible);
    input.classList.toggle('rounded-t-3xl', isResultsVisible);
    input.classList.toggle('border-t', isResultsVisible);
    input.classList.toggle('border-l', isResultsVisible);
    input.classList.toggle('border-r', isResultsVisible);
}


function handleSingleDropdownSearch(query, searchType, resultsBox, input) {
    const searchUrl = `/search/single/dropdown?query=${encodeURIComponent(query)}&searchType=${searchType}`;

    fetch(searchUrl)
        .then(response => response.json())
        .then(data => {
            const cleanedHtml = data.html.replace(/\s/g, '');

            if (cleanedHtml === '<div></div>') {
                resultsBox.innerHTML = '<p class="p-4 text-gray-500 text-sm">Nie znaleziono wyników.</p>';
                toggleInputStyle(input,true);
                input.classList.add('border-gray-200');
                resultsBox.classList.remove('hidden');
            } else {
                resultsBox.innerHTML = data.html;
                toggleInputStyle(input,true);
                input.classList.add('border-gray-200');
                resultsBox.classList.remove('hidden');
            }

            input.setAttribute('aria-expanded', 'true');
            setupKeyboardNavigation(input, resultsBox);
        })
        .catch(error => console.error('Błąd:', error));
}

function handleTripleSwiperSearch(query, searchType, categorySelect, timeSelect, resultsBox, input, swiperInstance) {
    console.log(timeSelect);
    const searchUrl = `/search/triple/swiper?query=${encodeURIComponent(query)}&category=${encodeURIComponent(categorySelect)}&time=${encodeURIComponent(timeSelect)}&searchType=${searchType}`;

    fetch(searchUrl)
        .then(response => response.json())
        .then(data => {
            const cleanedHtml = data.html.replace(/\s/g, '');
            console.log(cleanedHtml);
            if (cleanedHtml === '') {
                data.html = '<p class="flex justify-center w-full p-4 text-gray-500 text-lg">Nie znaleziono gazetek.</p>';
            }

            updateSwiperContent(swiperInstance, data.html);

        })
        .catch(error => console.error('Błąd:', error));
}

function handleTripleSearch(query, searchType, categorySelect, timeSelect, resultsBox, input, containerId) {

    const searchUrl = `/search/triple?query=${encodeURIComponent(query)}&category=${encodeURIComponent(categorySelect)}&time=${encodeURIComponent(timeSelect)}&searchType=${searchType}`;
    const results = document.getElementById(containerId);
    const answer = searchType === 'leaflets'  ? 'Nie znaleziono gazetek.' : 'Nie znaleziono żadnej sieci handlowej.';


    fetch(searchUrl)
        .then(response => response.json())
        .then(data => {
            const cleanedHtml = data.html.replace(/\s/g, '');

            if (cleanedHtml === '<div></div>' || cleanedHtml === '') {

                data.html = '<p class="flex justify-center w-full p-4 text-gray-500 text-sm">' + answer + '</p>';

                results.innerHTML = data.html;
            } else {

                results.innerHTML = data.html;

            }

            input.setAttribute('aria-expanded', 'true');
            setupKeyboardNavigation(input, resultsBox);
        })
        .catch(error => console.error('Błąd:', error));
}

function updateSwiperContent(swiperInstance, html) {
    const wrapper = swiperInstance.el.querySelector('.swiper-wrapper');
    wrapper.innerHTML = html;
    swiperInstance.update();
}

function setupKeyboardNavigation(input, resultsBox) {
    const resultsItems = resultsBox.querySelectorAll('a.item');
    let focusedResultIndex = -1;

    function focusResult(index) {
        resultsItems.forEach((item, i) => {
            if (i === index) {
                item.classList.add('bg-gray-200');
                item.focus();
            } else {
                item.classList.remove('bg-gray-200');
            }
        });
    }

    input.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowDown' && resultsItems.length > 0) {
            event.preventDefault();
            focusedResultIndex = 0;
            focusResult(focusedResultIndex);
        }
    });

    resultsItems.forEach((item, index) => {
        item.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                focusedResultIndex = (focusedResultIndex + 1) % resultsItems.length;
                focusResult(focusedResultIndex);
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                if (focusedResultIndex === 0) {
                    input.focus();
                    restoreInputStyle(input, resultsBox, false);
                } else {
                    focusedResultIndex = (focusedResultIndex - 1 + resultsItems.length) % resultsItems.length;
                    focusResult(focusedResultIndex);
                }
            } else if (event.key === 'Escape') {
                input.focus();
                restoreInputStyle(input, resultsBox);
            } else if (event.key === 'Enter') {
                event.preventDefault();
                item.click();
            }
        });
    });
}

function restoreInputStyle(input, resultsBox, hideResultsBox = true, highlightClass = 'bg-gray-200') {
    if (!input || !resultsBox) return;

    if (hideResultsBox && resultsBox.innerHTML.trim() === '') {
        resultsBox.classList.add('hidden');
        toggleInputStyle(input,false);
    } else {
        const items = resultsBox.querySelectorAll(`.${highlightClass}`);
        items.forEach(item => item.classList.remove(highlightClass));
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const searchInputs = document.querySelectorAll('.search-input');

    searchInputs.forEach(input => {
        const resultsBoxId = input.getAttribute('data-results-box-id');
        const resultsBox = document.getElementById(resultsBoxId);
        const searchType = input.getAttribute('data-search-type');
        const containerId = input.getAttribute('data-container-id');
        const swiperInstance = containerId && document.querySelector(`#${containerId}`)
            ? document.querySelector(`#${containerId}`).swiper
            : null;


        const clearButton = input.parentElement.querySelector('.clear-button');

        const categorySelect = document.querySelector('#category-select');
        const timeSelect = document.querySelector('#time-select');



        // Funkcja do wywołania wyszukiwania
        function performSearch() {
            const query = input.value.trim();

            let selectCategory = '';
            if(categorySelect !== null)
            {
                selectCategory = categorySelect.value ? categorySelect.value : 'all';
            }
            let timeCategory = '';
            if(timeSelect !== null)
            {
                timeCategory = timeSelect.value ? timeSelect.value : 'all';
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
                            handleTripleSearch(query, searchType, selectCategory, timeCategory, resultsBox, input, containerId);
                        }
                        break;

                    case 'retailers':
                    case 'products':
                    case 'vouchers':
                            handleTripleSearch(query, searchType, selectCategory, timeCategory, resultsBox, input, containerId);
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
                            handleTripleSearch('', searchType, selectCategory, timeCategory, resultsBox, input, containerId);
                        }
                        break;

                    case 'retailers':
                    case 'products':
                    case 'vouchers':
                        handleTripleSearch('', searchType, selectCategory, timeCategory, resultsBox, input, containerId);
                        break;

                }

            }
        }

        // Nasłuchuj zmian w polach select i input
        input.addEventListener('input', debounce(performSearch, 300));

        if (categorySelect) {
            categorySelect.addEventListener('change', performSearch);
        }

        if (timeSelect) {
            timeSelect.addEventListener('change', performSearch);
        }


        clearButton.addEventListener('click', function () {
            input.value = '';
            clearButton.classList.add('hidden');

           performSearch();
        });

        document.addEventListener('mousedown', function (event) {
            if (!input.contains(event.target) && !resultsBox.contains(event.target)) {
                resultsBox.innerHTML = '';
                restoreInputStyle(input, resultsBox, true);
            }
        });
    });
});
