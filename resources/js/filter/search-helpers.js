import {toggleInputStyle, setupKeyboardNavigation, updateSwiperContent} from "./helpers";


export function handleSingleDropdownSearch(query, searchType, resultsBox, input, leafletId = null, pageId = null) {
    const searchUrl = `/search/single/dropdown?query=${encodeURIComponent(query)}&searchType=${searchType}&leafletId=${leafletId}&pageId=${pageId}`;

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

export function handleTripleSwiperSearch(query, searchType, categorySelect, timeSelect, resultsBox, input, swiperInstance) {

    const searchUrl = `/search/triple/swiper?` +
        `query=${encodeURIComponent(query)}` +
        `&category=${encodeURIComponent(categorySelect)}&` +
        `time=${encodeURIComponent(timeSelect)}&` +
        `searchType=${searchType}`;

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

export function handleTripleSearch(query, searchType, categorySelect, timeSelect, resultsBox, input, containerId, subcategory = null, currentPage = 1 ) {

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
                    resultsBox, input, subcategory
                );
            }

            input.setAttribute('aria-expanded', 'true');
            setupKeyboardNavigation(input, resultsBox);
        })
        .catch(error => console.error('Błąd:', error));

}

export function handleQuadrupleSearch(query, searchType, categorySelect, typeSelect, timeSelect, resultsBox, input, containerId, currentPage = 1) {

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

function renderPagination(containerId, pagination, query, searchType, categorySelect, timeSelect, resultsBox, input, subcategory = null, typeSelect = null) {

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
                handleTripleSearch(query, searchType, categorySelect, timeSelect, resultsBox, input, containerId, subcategory, pagination.currentPage - 1);
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
                handleTripleSearch(query, searchType, categorySelect, timeSelect, resultsBox, input, containerId, subcategory, pagination.currentPage + 1);
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
