// document.addEventListener('DOMContentLoaded', function() {
//     const searchInputs = document.querySelectorAll('.search-input');
//
//     function debounce(func, delay) {
//         let debounceTimer;
//         return function() {
//             const context = this;
//             const args = arguments;
//             clearTimeout(debounceTimer);
//             debounceTimer = setTimeout(() => func.apply(context, args), delay);
//         }
//     }
//
//     function sendSearchData(query, callback) {
//         fetch(`/search?query=${encodeURIComponent(query)}`)
//             .then(response => response.json())
//             .then(data => {
//                 callback(data);
//             })
//             .catch(error => console.error('Błąd:', error));
//     }
//
//     searchInputs.forEach(input => {
//         // Pobierz id resultsBox przypisany do tego inputa
//         const resultsBoxId = input.getAttribute('data-results-box-id');
//         const resultsBox = document.getElementById(resultsBoxId);
//         let focusedResultIndex = -1;
//
//         function displayResults(data) {
//             resultsBox.innerHTML = ''; // Czyści poprzednie wyniki
//             let hasResults = false;
//
//             // Dodajemy nagłówek i wyniki dla produktów, jeśli są dostępne
//             if (data.produkty && data.produkty.length > 0) {
//                 hasResults = true;
//                 const produktyHeader = document.createElement('div');
//                 produktyHeader.textContent = 'Produkty';
//                 produktyHeader.classList.add('mx-4', 'py-1', 'text-xs', 'font-base', 'text-gray-400');
//                 resultsBox.appendChild(produktyHeader);
//
//                 data.produkty.forEach((produkt) => {
//                     const resultLink = document.createElement('a');
//                     resultLink.href = '#';
//                     resultLink.classList.add('block', 'px-4', 'py-1', 'hover:bg-gray-100', 'cursor-pointer', 'text-sm', 'text-gray-700', 'item');
//                     resultLink.tabIndex = -1;
//
//                     const logoImg = document.createElement('img');
//                     logoImg.src = 'https://zakupy.biedronka.pl/dw/image/v2/BKFJ_PRD/on/demandware.static/-/Sites-PL_Master_Catalog/default/dw86fc0dc7/images/hi-res/359277.jpg';
//                     logoImg.alt = `${produkt.name} logo`;
//                     logoImg.classList.add('inline-block', 'w-6', 'h-6', 'mr-2');
//
//                     resultLink.appendChild(logoImg);
//                     resultLink.appendChild(document.createTextNode(produkt.name));
//
//                     resultsBox.appendChild(resultLink);
//                 });
//             }
//
//             // Dodajemy nagłówek i wyniki dla sklepów, jeśli są dostępne
//             if (data.sklepy && data.sklepy.length > 0) {
//                 hasResults = true;
//                 const sklepyHeader = document.createElement('div');
//                 sklepyHeader.textContent = 'Sklepy';
//                 sklepyHeader.classList.add('mx-4', 'py-1', 'text-xs', 'font-base', 'text-gray-400', 'mt-2');
//                 if (data.produkty && data.produkty.length > 0) {
//                     sklepyHeader.classList.add('border-t', 'border-gray-200');
//                 }
//                 resultsBox.appendChild(sklepyHeader);
//
//                 data.sklepy.forEach((sklep) => {
//                     const resultLink = document.createElement('a');
//                     resultLink.href = '#';
//                     resultLink.classList.add('block', 'px-4', 'py-1', 'hover:bg-gray-100', 'cursor-pointer', 'text-sm', 'text-gray-700', 'hover:rounded-b-lg', 'item');
//                     resultLink.tabIndex = -1;
//
//                     const logoImg = document.createElement('img');
//                     logoImg.src = `${sklep.logo}`;
//                     logoImg.alt = `${sklep.name} logo`;
//                     logoImg.classList.add('inline-block', 'w-6', 'h-6', 'mr-2');
//
//                     resultLink.appendChild(logoImg);
//                     resultLink.appendChild(document.createTextNode(sklep.name));
//
//                     resultsBox.appendChild(resultLink);
//                 });
//             }
//
//             if (hasResults) {
//                 input.classList.remove('rounded-3xl');
//                 input.classList.add('rounded-t-3xl', 'border-t', 'border-l', 'border-r', 'border-gray-200');
//             } else {
//                 input.classList.remove('rounded-3xl');
//                 input.classList.add('rounded-t-3xl', 'border-t', 'border-l', 'border-r', 'border-gray-200');
//                 resultsBox.innerHTML = '<p class="p-4 text-gray-500 text-sm">Nie znaleziono wyników.</p>';
//             }
//
//             focusedResultIndex = -1;
//             resultsBox.classList.remove('hidden');
//             input.setAttribute('aria-expanded', 'true');
//
//             const resultsItems = resultsBox.querySelectorAll('a.item');
//             resultsItems.forEach((result, index) => {
//                 result.addEventListener('keydown', (event) => handleNavigation(event, resultsItems));
//             });
//         }
//
//         function handleNavigation(event, resultsItems) {
//             if (event.key === 'ArrowDown') {
//                 event.preventDefault();
//                 if (focusedResultIndex < resultsItems.length - 1) {
//                     focusedResultIndex++;
//                     focusResult(resultsItems);
//                 }
//             } else if (event.key === 'ArrowUp') {
//                 event.preventDefault();
//                 if (focusedResultIndex > 0) {
//                     focusedResultIndex--;
//                     focusResult(resultsItems);
//                 } else if (focusedResultIndex === 0) {
//                     focusedResultIndex = -1;
//                     clearHighlight(resultsItems);
//                     input.focus();
//                 }
//             } else if (event.key === 'Escape') {
//                 clearHighlight(resultsItems);
//                 input.focus();
//                 resultsBox.classList.add('hidden');
//             } else if (event.key === 'Enter' && focusedResultIndex > -1) {
//                 event.preventDefault();
//                 resultsItems[focusedResultIndex].click();
//             }
//         }
//
//         function clearHighlight(resultsItems) {
//             resultsItems.forEach(result => result.classList.remove('bg-gray-200'));
//         }
//
//         function focusResult(resultsItems) {
//             resultsItems.forEach((result, index) => {
//                 if (index === focusedResultIndex) {
//                     result.classList.add('bg-gray-200');
//                     result.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
//                 } else {
//                     result.classList.remove('bg-gray-200');
//                 }
//             });
//         }
//
//         input.addEventListener('input', debounce(function(event) {
//             const query = input.value;
//             if (query.length < 2) {
//                 resultsBox.innerHTML = '';
//                 resultsBox.classList.add('hidden');
//                 input.setAttribute('aria-expanded', 'false');
//                 input.classList.remove('rounded-t-3xl', 'border-t', 'border-l', 'border-r');
//                 input.classList.add('rounded-3xl');
//             } else {
//                 sendSearchData(query, displayResults);
//             }
//         }, 300));
//
//         input.addEventListener('keydown', (event) => {
//             const resultsItems = resultsBox.querySelectorAll('a.item');
//             handleNavigation(event, resultsItems);
//         });
//
//         document.addEventListener('mousedown', function(event) {
//             if (!input.contains(event.target) && !resultsBox.contains(event.target)) {
//                 resultsBox.classList.add('hidden');
//                 input.setAttribute('aria-expanded', 'false');
//                 input.classList.remove('rounded-t-3xl', 'border-t', 'border-l', 'border-r');
//                 input.classList.add('rounded-3xl');
//             }
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', function() {
    const searchInputs = document.querySelectorAll('.search-input');

    function debounce(func, delay) {
        let debounceTimer;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(context, args), delay);
        }
    }

    function sendSearchData(query, searchType, callback) {
        let searchUrl;

        // Wybór URL-a na podstawie typu wyszukiwania
        if (searchType === 'produkty-sklepy') {
            searchUrl = `/search?query=${encodeURIComponent(query)}`;
        } else if (searchType === 'miejscowosci') {
            searchUrl = `/search-location?query=${encodeURIComponent(query)}`;
        }

        fetch(searchUrl)
            .then(response => response.json())
            .then(data => {
                callback(data, searchType);
            })
            .catch(error => console.error('Błąd:', error));
    }

    searchInputs.forEach(input => {
        const resultsBoxId = input.getAttribute('data-results-box-id');
        const resultsBox = document.getElementById(resultsBoxId);
        const searchType = input.getAttribute('data-search-type');
        let focusedResultIndex = -1;

        function displayResults(data, searchType) {
            resultsBox.innerHTML = ''; // Czyści poprzednie wyniki
            let hasResults = false;

            // Obsługa wyników dla produktów i sklepów
            if (searchType === 'produkty-sklepy') {
                if (data.produkty && data.produkty.length > 0) {
                    hasResults = true;
                    const produktyHeader = document.createElement('div');
                    produktyHeader.textContent = 'Produkty';
                    produktyHeader.classList.add('mx-4', 'py-1', 'text-xs', 'font-base', 'text-gray-400');
                    resultsBox.appendChild(produktyHeader);

                    data.produkty.forEach((produkt) => {
                        const resultLink = createResultLink(produkt, 'produkty');
                        resultsBox.appendChild(resultLink);
                    });
                }

                if (data.sklepy && data.sklepy.length > 0) {
                    hasResults = true;
                    const sklepyHeader = document.createElement('div');
                    sklepyHeader.textContent = 'Sklepy';
                    sklepyHeader.classList.add('mx-4', 'py-1', 'text-xs', 'font-base', 'text-gray-400', 'mt-2');
                    if (data.produkty && data.produkty.length > 0) {
                        sklepyHeader.classList.add('border-t', 'border-gray-200');
                    }
                    resultsBox.appendChild(sklepyHeader);

                    data.sklepy.forEach((sklep) => {
                        const resultLink = createResultLink(sklep, 'sklepy');
                        resultsBox.appendChild(resultLink);
                    });
                }
            }

            // Obsługa wyników dla miejscowości
            if (searchType === 'miejscowosci' && data.miejscowosci && data.miejscowosci.length > 0) {
                hasResults = true;
                const miejscowosciHeader = document.createElement('div');
                miejscowosciHeader.textContent = 'Miejscowości';
                miejscowosciHeader.classList.add('mx-4', 'py-1', 'text-xs', 'font-base', 'text-gray-400');
                resultsBox.appendChild(miejscowosciHeader);

                data.miejscowosci.forEach((miejscowosc) => {
                    const resultLink = createResultLink(miejscowosc, 'miejscowosci');
                    resultsBox.appendChild(resultLink);
                });
            }

            if (hasResults) {
                input.classList.remove('rounded-3xl');
                input.classList.add('rounded-t-3xl', 'border-t', 'border-l', 'border-r', 'border-gray-200');
            } else {
                input.classList.remove('rounded-3xl');
                input.classList.add('rounded-t-3xl', 'border-t', 'border-l', 'border-r', 'border-gray-200');
                resultsBox.innerHTML = '<p class="p-4 text-gray-500 text-sm">Nie znaleziono wyników.</p>';
            }

            focusedResultIndex = -1;
            resultsBox.classList.remove('hidden');
            input.setAttribute('aria-expanded', 'true');

            const resultsItems = resultsBox.querySelectorAll('a.item');
            resultsItems.forEach((result, index) => {
                result.addEventListener('keydown', (event) => handleNavigation(event, resultsItems));
            });
        }

        function createResultLink(data, type) {
            const resultLink = document.createElement('a');
            resultLink.href = '#';
            resultLink.classList.add('block', 'px-4', 'py-1', 'hover:bg-gray-100', 'cursor-pointer', 'text-sm', 'text-gray-700', 'item');
            resultLink.tabIndex = -1;

            const logoImg = document.createElement('img');
            logoImg.src = type === 'produkty'
                ? 'https://zakupy.biedronka.pl/dw/image/v2/BKFJ_PRD/on/demandware.static/-/Sites-PL_Master_Catalog/default/dw86fc0dc7/images/hi-res/359277.jpg'
                : (type === 'sklepy' ? `${data.logo}` : 'path/to/default-location-logo.png'); // Ścieżka do domyślnego logo dla miejscowości
            logoImg.alt = `${data.name} logo`;
            logoImg.classList.add('inline-block', 'w-6', 'h-6', 'mr-2');

            resultLink.appendChild(logoImg);
            resultLink.appendChild(document.createTextNode(data.name));

            return resultLink;
        }

        function handleNavigation(event, resultsItems) {
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                if (focusedResultIndex < resultsItems.length - 1) {
                    focusedResultIndex++;
                    focusResult(resultsItems);
                }
            } else if (event.key === 'ArrowUp') {
                event.preventDefault();
                if (focusedResultIndex > 0) {
                    focusedResultIndex--;
                    focusResult(resultsItems);
                } else if (focusedResultIndex === 0) {
                    focusedResultIndex = -1;
                    clearHighlight(resultsItems);
                    input.focus();
                }
            } else if (event.key === 'Escape') {
                clearHighlight(resultsItems);
                input.focus();
                resultsBox.classList.add('hidden');
            } else if (event.key === 'Enter' && focusedResultIndex > -1) {
                event.preventDefault();
                resultsItems[focusedResultIndex].click();
            }
        }

        function clearHighlight(resultsItems) {
            resultsItems.forEach(result => result.classList.remove('bg-gray-200'));
        }

        function focusResult(resultsItems) {
            resultsItems.forEach((result, index) => {
                if (index === focusedResultIndex) {
                    result.classList.add('bg-gray-200');
                    result.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                } else {
                    result.classList.remove('bg-gray-200');
                }
            });
        }

        input.addEventListener('input', debounce(function(event) {
            const query = input.value;
            if (query.length < 2) {
                resultsBox.innerHTML = '';
                resultsBox.classList.add('hidden');
                input.setAttribute('aria-expanded', 'false');
                input.classList.remove('rounded-t-3xl', 'border-t', 'border-l', 'border-r');
                input.classList.add('rounded-3xl');
            } else {
                sendSearchData(query, searchType, displayResults);
            }
        }, 300));

        input.addEventListener('keydown', (event) => {
            const resultsItems = resultsBox.querySelectorAll('a.item');
            handleNavigation(event, resultsItems);
        });

        document.addEventListener('mousedown', function(event) {
            if (!input.contains(event.target) && !resultsBox.contains(event.target)) {
                resultsBox.classList.add('hidden');
                input.setAttribute('aria-expanded', 'false');
                input.classList.remove('rounded-t-3xl', 'border-t', 'border-l', 'border-r');
                input.classList.add('rounded-3xl');
            }
        });
    });
});
