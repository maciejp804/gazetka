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

    const searchUrl = `/search/triple/swiper?query=${encodeURIComponent(query)}&category=${encodeURIComponent(categorySelect)}&time=${encodeURIComponent(timeSelect)}&searchType=${searchType}`;

    fetch(searchUrl)
        .then(response => response.json())
        .then(data => {
            const cleanedHtml = data.html.replace(/\s/g, '');

            if (cleanedHtml === '') {
                data.html = '<p class="flex justify-center w-full p-4 text-gray-500 text-lg">Nie znaleziono gazetek.</p>';
            }

            updateSwiperContent(swiperInstance, data.html);

        })
        .catch(error => console.error('Błąd:', error));
}

function handleTripleSearch(query, searchType, categorySelect, timeSelect, resultsBox, input, containerId, subcategory, currentPage = 1 ) {

    const searchUrl = `/search/triple?` +
        `query=${encodeURIComponent(query)}` +
        `&category=${encodeURIComponent(categorySelect)}` +
        `&time=${encodeURIComponent(timeSelect)}` +
        `&searchType=${searchType}` +
        `&page=${currentPage}` +
        `&subcategory=${subcategory}` +
        `&limit=10`;

    const results = document.getElementById(containerId);
    const answer = searchType === 'leaflets'  ? 'Nie znaleziono gazetek.' : 'Nie znaleziono żadnej sieci handlowej.';
    const h1Header = document.getElementsByTagName('h1');

    fetch(searchUrl)
        .then(response => response.json())
        .then(data => {
            const cleanedHtml = data.html.replace(/\s/g, '');

            if (cleanedHtml === '<div></div>' || cleanedHtml === '') {

                data.html = '<p class="flex justify-center w-full p-4 text-gray-500 text-sm">' + answer + '</p>';

                results.innerHTML = data.html;
                if (h1Header.length > 0) {
                    // np. przewiń okno do pierwszego h1
                    h1Header[0].scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            } else {

                results.innerHTML = data.html;
                if (h1Header.length > 0) {
                    // np. przewiń okno do pierwszego h1
                    h1Header[0].scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }

            }

            // Obsługa paginacji
            if (data.pagination) {
                renderPagination(
                    containerId,
                    data.pagination,
                    query, searchType,
                    categorySelect, timeSelect,
                    resultsBox, input
                );
            }

            input.setAttribute('aria-expanded', 'true');
            setupKeyboardNavigation(input, resultsBox);
        })
           .catch(error => console.error('Błąd:', error));

}

function handleQuadrupleSearch(query, searchType, categorySelect, typeSelect, timeSelect, resultsBox, input, containerId, currentPage = 1) {

    const searchUrl = `/search/quadruple?` +
        `query=${encodeURIComponent(query)}` +
        `&category=${encodeURIComponent(categorySelect)}` +
        `&type=${encodeURIComponent(typeSelect)}` +
        `&time=${encodeURIComponent(timeSelect)}` +
        `&searchType=${searchType}` +
        `&page=${currentPage}` +
        `&limit=10`;

    const results = document.getElementById(containerId);
    const answer = searchType === 'vouchers'  ? 'Brak ofert z danej kategorii, zmień parametry wyszukiwania.' : 'Zmień parametry wyszukiwania.';
    const h1Header = document.getElementsByTagName('h1');

    fetch(searchUrl)
        .then(response => response.json())
        .then(data => {
            const cleanedHtml = data.html.replace(/\s/g, '');
            console.log(cleanedHtml);
            if (cleanedHtml === '<div></div>' || cleanedHtml === '') {

                data.html = '<p class="flex justify-center w-full p-4 text-gray-500 text-sm">' + answer + '</p>';

                results.innerHTML = data.html;

                // Ustalamy, gdzie jest nasz div

                if (h1Header.length > 0) {
                    // np. przewiń okno do pierwszego h1
                    h1Header[0].scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            } else {

                results.innerHTML = data.html;

                if (h1Header.length > 0) {
                    // np. przewiń okno do pierwszego h1
                    h1Header[0].scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }

            // Obsługa paginacji
            if (data.pagination) {
                renderPagination(
                    containerId,
                    data.pagination,
                    query, searchType,
                    categorySelect, timeSelect,
                    resultsBox, input, typeSelect
                );
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
function renderPagination(containerId, pagination, query, searchType, categorySelect, timeSelect, resultsBox, input, typeSelect = null) {

    const resultsContainer = document.getElementById(containerId);

    // Usunięcie starej paginacji, by się nie duplikowała
    const existingPagination = document.querySelector('.custom-pagination');
    if (existingPagination) {
        existingPagination.remove();
    }

    const paginationDiv = document.createElement('div');
    paginationDiv.classList.add('custom-pagination', 'flex', 'items-center', 'p-4');

    if(pagination.totalPages > 1){
        paginationDiv.classList.add('justify-between');
        // Poprzednia
        const prevButton = document.createElement('button');
        prevButton.textContent = 'Poprzednia';
        prevButton.classList.add('px-4','py-2', 'bg-gray-200');

        if (pagination.currentPage <= 1) {
            prevButton.classList.add('text-gray-500', 'cursor-not-allowed');
        } else {
            prevButton.classList.add('hover:bg-gray-300');
        }
        prevButton.disabled = pagination.currentPage <= 1;
        prevButton.addEventListener('click', () => {
            if (typeSelect == null){
                handleTripleSearch(query, searchType, categorySelect, timeSelect, resultsBox, input, containerId, pagination.currentPage - 1);
            } else {
                handleQuadrupleSearch(query, searchType, categorySelect, typeSelect, timeSelect, resultsBox, input, containerId, pagination.currentPage - 1)
            }
        });

        // Następna
        const nextButton = document.createElement('button');
        nextButton.textContent = 'Następna';
        nextButton.classList.add('px-4','py-2', 'bg-gray-200');
        if (pagination.currentPage >= pagination.totalPages)
        {
            nextButton.classList.add('text-gray-500', 'cursor-not-allowed');
        } else {
            nextButton.classList.add('hover:bg-gray-300');
        }
        nextButton.disabled = pagination.currentPage >= pagination.totalPages;
        nextButton.addEventListener('click', () => {
            if (typeSelect == null){
                handleTripleSearch(query, searchType, categorySelect, timeSelect, resultsBox, input, containerId, pagination.currentPage + 1);
            } else {
                handleQuadrupleSearch(query, searchType, categorySelect, typeSelect, timeSelect, resultsBox, input, containerId, pagination.currentPage + 1)
            }


        });

        // Info o numerze strony
        const pageInfo = document.createElement('span');
        pageInfo.textContent = `Strona ${pagination.currentPage} z ${pagination.totalPages}`;
        pageInfo.classList.add('mx-2');

        // Dodajemy wszystko do kontenera
        paginationDiv.appendChild(prevButton);
        paginationDiv.appendChild(pageInfo);
        paginationDiv.appendChild(nextButton);
    } else {
        if (pagination.total > 0){
            paginationDiv.classList.add('justify-center');
            const infoSpan = document.createElement('span');
            infoSpan.textContent = `Koniec`;
            infoSpan.classList.add('text-sm', 'text-gray-700');
            paginationDiv.appendChild(infoSpan);
        }
    }

    resultsContainer.appendChild(paginationDiv);
}


document.addEventListener('DOMContentLoaded', () => {
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
        const swiperInstance = containerId && document.querySelector(`#${containerId}`)
            ? document.querySelector(`#${containerId}`).swiper
            : null;


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
});
