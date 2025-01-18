document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('#star-rating span');
    const ratingForm = document.getElementById('ratingForm');
    const ratingInput = document.getElementById('selectedRatingInput');

    // Pobrana z backendu średnia ocena (do podświetlenia na starcie)
    // Załóżmy, że jest to liczba całkowita lub zaokrąglamy do najbliższej:


    let hoveredRating = 0;   // Ocena przy najechaniu myszką
    let selectedRating = 0;  // Ocena faktycznie kliknięta

    /**
     * FUNKCJA PODŚWIETLAJĄCA GWIAZDKI
     */
    function highlightStars(rating) {
        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-rating'));
            if (starValue <= rating) {
                star.classList.add('text-amber-600'); // np. bursztynowy kolor
            } else {
                star.classList.remove('text-amber-600');
            }
        });
    }

    /**
     * PODŚWIETLENIE GWIAZDEK NA PODSTAWIE ŚREDNIEJ OCENY
     * (wywołujemy to raz po załadowaniu)
     */
    highlightStars(averageRating);

    /**
     * OBSŁUGA ZDARZEŃ MYSZKI
     */
    stars.forEach(star => {
        // 1. Najechanie myszką
        star.addEventListener('mouseover', () => {
            hoveredRating = parseInt(star.getAttribute('data-rating'));
            highlightStars(hoveredRating);
        });

        // 2. Wyjechanie myszką
        star.addEventListener('mouseout', () => {
            if (selectedRating > 0) {
                // Jeśli użytkownik już kliknął, przywracamy jego kliknięcie
                highlightStars(selectedRating);
            } else {
                // W przeciwnym razie przywracamy średnią ocenę
                highlightStars(averageRating);
            }
        });

        // 3. Kliknięcie (ustawiamy ocenę, wysyłamy formularz)
        star.addEventListener('click', () => {
            selectedRating = parseInt(star.getAttribute('data-rating'));
            highlightStars(selectedRating);

            // Przypisujemy oceny do hidden input i submitujemy
            ratingInput.value = selectedRating;
            ratingForm.submit();
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

//     document.addEventListener('DOMContentLoaded', () => {
//     // Zmienna przechowująca początkową średnią ocenę (z backendu).
//     // Możesz pobrać ją dynamicznie, np. z dataset lub z kontrolera.
//         if (Number.isNaN(averageRating)) {
//             // Brak ocen
//             console.log('Brak ocen, averageRating to null lub undefined');
//         } else {
//             console.log(`Średnia ocena: ${averageRating}`);
//         }
//     // Liczba już oddanych głosów:
//     // Możesz również pobrać ją dynamicznie, np. z dataset.
//     let ratingCount = parseInt("{{ $ratingCount }}") || 0;
//
//     // ID i typ ocenianego obiektu (dla polimorficznej relacji)
//     // Wstaw tu swoją logikę. Poniżej przykładowe na sztywno:
//     //const rateableId = ;              // np. ID produktu
//     const rateableType = 'App\\Models\\Product';
//
//     // Zbieramy wszystkie gwiazdki
//     const stars = document.querySelectorAll('#star-rating span');
//
//     // Element do wyświetlania tekstu o ocenie (aktualizujemy go po kliknięciu)
//     const ratingInfo = document.getElementById('rating-info');
//
//     // Zmienna przechowująca aktualnie WYBRANĄ ocenę (klikniętą)
//     let selectedRating = 0;
//
//     /**
//      * FUNKCJE POMOCNICZE
//      */
//
//     // Podświetla gwiazdki w zależności od przekazanego ratingu
//     function highlightStars(rating) {
//     stars.forEach(star => {
//     const starValue = parseInt(star.getAttribute('data-rating'));
//     // Jeśli wartość gwiazdki <= rating, włącz klasę
//     if (starValue <= rating) {
//     star.classList.add('text-amber-600'); // klasa Tailwind do podświetlenia
// } else {
//     star.classList.remove('text-amber-600');
// }
// });
// }
//
//     // Resetuje wszystkie gwiazdki (usuwa podświetlenie)
//     function resetStars() {
//     stars.forEach(star => {
//     star.classList.remove('text-amber-600');
// });
// }
//
//     // Ustaw wstępne podświetlenie na podstawie averageRating
//     // np. wartość 3.6 można zaokrąglić do 4 lub pokusić się o pół-gwiazdki
//     function initAverageRating() {
//     highlightStars(Math.round(averageRating));
// }
//
//     // Funkcja wysyłająca ocenę do backendu (Laravel)
//     async function submitRating(rating) {
//     try {
//     const response = await fetch('/ratings', {
//     method: 'POST',
//     headers: {
//     'Content-Type': 'application/json',
//     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
// },
//     body: JSON.stringify({
//     rateable_id: rateableId,
//     rateable_type: rateableType,
//     rating: rating,
//
// }),
// });
//
//     if (response.ok) {
//     // Oczekujemy, że serwer zwróci nam np. JSON z nową średnią i liczbą głosów
//     const result = await response.json();
//         console.log(result);
//     // Przykład: { newAverage: 3.78, newCount: 121 }
//     if (result.newAverage && result.newCount) {
//     // Aktualizujemy localne zmienne i UI
//      updateRatingInfo(result.newAverage, result.newCount);
// }
//
//     alert('Dziękujemy za ocenę!');
// } else {
//     alert('Wystąpił błąd. Spróbuj ponownie później.');
// }
// } catch (error) {
//     console.error('Błąd wysyłania oceny:', error);
//     alert('Wystąpił błąd. Spróbuj ponownie później.');
// }
// }
//
//     // Funkcja aktualizująca widoczną średnią i liczbę głosów
//     function updateRatingInfo(newAverage, newCount) {
//     // Ustawiamy nowe wartości w zmiennych
//     ratingCount = newCount;
//     // Optionalnie można uśrednić do 2 miejsc po przecinku
//     const formattedAverage = parseFloat(newAverage).toFixed(2);
//
//     // Uaktualniamy tekst w ratingInfo
//     ratingInfo.textContent = `${formattedAverage}/5 - ${ratingCount} (głosów)`;
//     console.log('formattedAverage ' + formattedAverage);
//     // Ewentualnie podświetlamy gwiazdki wg nowej średniej,
//     // jeśli chcesz, by po oddaniu oceny pokazywało się faktyczne "zbliżone" podświetlenie.
//     highlightStars(Math.round(newAverage));
// }
//
//     /**
//      * GŁÓWNA LOGIKA OBSŁUGI
//      */
//
//     // 1. Podświetlamy gwiazdki na podstawie aktualnej średniej, jeśli chcesz
//     //    wyświetlać je od razu po załadowaniu:
//     initAverageRating();
//
//     // 2. Nasłuchiwanie zdarzeń dla każdej gwiazdki
//     stars.forEach(star => {
//     // Najechanie myszką (hover)
//     star.addEventListener('mouseover', () => {
//     resetStars();
//     highlightStars(star.getAttribute('data-rating'));
// });
//
//     // Zjechanie myszką (mouseout)
//     star.addEventListener('mouseout', () => {
//     resetStars();
//     // Jeśli użytkownik już wybrał ocenę, przywróć ją:
//     if (selectedRating > 0) {
//     highlightStars(selectedRating);
// } else {
//     // w przeciwnym razie przywróć stan odpowiadający averageRating
//     initAverageRating();
// }
// });
//
//     // Kliknięcie w gwiazdkę (wybór oceny)
//     star.addEventListener('click', () => {
//     selectedRating = parseInt(star.getAttribute('data-rating'));
//     resetStars();
//     highlightStars(selectedRating);
//     // Możesz też natychmiast zaktualizować widok (np. "Ocena: 4")
//     // Albo dopiero po pomyślnym zapisie na serwerze.
//     submitRating(selectedRating);
// });
// });
// });

//     document.addEventListener('DOMContentLoaded', () => {
//     const stars = document.querySelectorAll('#star-rating span');
//     const ratingValue = document.getElementById('rating-value');
//     let selectedRating = 0;
//
//     stars.forEach(star => {
//     // Podświetlenie gwiazdek przy najechaniu
//     star.addEventListener('mouseover', () => {
//     resetStars();
//     highlightStars(star.getAttribute('data-rating'));
// });
//
//     // Reset gwiazdek po wyjściu
//     star.addEventListener('mouseout', () => {
//     resetStars();
//     if (selectedRating > 0) highlightStars(selectedRating);
// });
//
//     // Zapisanie oceny
//     star.addEventListener('click', () => {
//     selectedRating = star.getAttribute('data-rating');
//     //ratingValue.textContent = `Ocena: ${selectedRating}`;
//     submitRating(selectedRating); // Funkcja wysyłająca ocenę do backendu
// });
// });
//
//     // Funkcja podświetlania gwiazdek
//     function highlightStars(rating) {
//     stars.forEach(star => {
//     if (star.getAttribute('data-rating') <= rating) {
//     star.classList.add('text-amber-600');
// }
// });
// }
//
//     // Funkcja resetowania gwiazdek
//     function resetStars() {
//     stars.forEach(star => {
//     star.classList.remove('text-amber-600');
// });
// }
//
//     // Wysyłanie oceny do backendu
//     async function submitRating(rating) {
//     try {
//     const response = await fetch('/ratings', {
//     method: 'POST',
//     headers: {
//     'Content-Type': 'application/json',
//     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
// },
//     body: JSON.stringify({
//     rateable_id: 1, // ID obiektu ocenianego
//     rateable_type: 'App\\Models\\Product', // Typ obiektu
//     rating: rating,
// }),
// });
//
//     if (response.ok) {
//     const result = await response.json();
//     alert('Dziękujemy za ocenę!');
// } else {
//     alert('Wystąpił błąd. Spróbuj ponownie później.');
// }
// } catch (error) {
//     console.error('Błąd wysyłania oceny:', error);
//     alert('Wystąpił błąd. Spróbuj ponownie później.');
// }
// }
// });
